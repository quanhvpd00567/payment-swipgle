<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\User;
use Carbon\Carbon;
use Storage;

// use Illuminate\Http\Request;

class TransfersController extends Controller
{
    // View trasnfers page
    public function index()
    {
        // Get transfers using mail
        $mail_transfers = Transfer::where('create_method', 1)->with('user')->orderbyDesc('id')->get();
        // Get transfer by generate link
        $link_transfers = Transfer::where('create_method', 2)->with('user')->orderbyDesc('id')->get();
        return view('backend.transfers', ['mail_transfers' => $mail_transfers, 'link_transfers' => $link_transfers]);
    }

    // View transfer
    public function view_transfer($transfer_id)
    {
        // Get transfer data
        $transfer = Transfer::where('transfer_id', $transfer_id)->first();
        // if data not null
        if ($transfer != null) {
            // get transfer files
            $files = [];
            $transferFiles = explode(',', $transfer->transferted_files);
            foreach ($transferFiles as $transferFile) {
                $files[] = $transferFile;
            }
            // get trasnfer to emails
            $emails = [];
            $transferEmails = explode(',', $transfer->email_to);
            foreach ($transferEmails as $transferEmail) {
                $emails[] = $transferEmail;
            }
            return view('backend.view.transfer', ['transfer' => $transfer, 'files' => $files, 'emails' => $emails]);
        } else {
            // abort 404
            return abort(404);
        }
    }

    // Download files
    public function download_file($id, $file_name)
    {
        // get data
        $transfer = Transfer::where('id', $id)->where('transferted_files', 'LIKE', '%' . $file_name . '%')->where('tranfer_status', 1)->first();
        // if data not null
        if ($transfer != null) {
            // check file expiry
            if (Carbon::createFromFormat('Y-m-d H:i:s', $transfer->expiry_time)->isPast() != true) {
                // check storage
                if ($transfer->storage_method == 1) {
                    // File path
                    $filePath = 'public/files/' . $file_name;
                    // storage disk
                    $disk = Storage::disk('local');
                    // if file exists download it
                    if ($disk->has($filePath)) {
                        session()->put($file_name, $file_name);
                        return Storage::download($filePath);
                    } else {
                        // Abort 404
                        return abort(404);
                    }
                } elseif ($transfer->storage_method == 2) {
                    // storage disk
                    $disk = Storage::disk('s3');
                    // if file exists download it
                    if ($disk->has($file_name)) {
                        session()->put($file_name, $file_name);
                        return redirect($disk->temporaryUrl($file_name, now()->addHour(), ['ResponseContentDisposition' => 'attachment']));
                    } else {
                        // Abort 404
                        return abort(404);
                    }
                } else {
                    // Abort 404
                    return abort(404);
                }
            } else {
                // Abort 404
                return abort(404);
            }
        } else {
            // abort 404
            return abort(404);
        }
    }

    // Cancel transfer
    public function cancel_transfer($transfer_id)
    {
        // Check trasnfer
        $transfer = Transfer::where('transfer_id', $transfer_id)->where('tranfer_status', 1)->first();
        // if data not null
        if ($transfer != null) {
            // get transfer files
            $files = explode(',', $transfer->transferted_files);
            foreach ($files as $file) {
                if ($transfer->storage_method == 1) {
                    // Delete file
                    if (Storage::disk('local')->has('public/files/' . $file)) {
                        $delete = Storage::disk('local')->delete('public/files/' . $file);
                    }
                } elseif ($transfer->storage_method == 2) {
                    // Delete file
                    if (Storage::disk('s3')->has($file)) {
                        // Delete file from amazon s3
                        $delete = Storage::disk('s3')->delete($file);
                    }
                }
            }

            // Update transfer status
            $update = Transfer::where('transfer_id', $transfer_id)->where('tranfer_status', 1)->update(['tranfer_status' => 2]);
            // if update
            if ($update) {
                // update user space
                $updateUserSpace = User::where('id', $transfer->user_id)->increment('space', $transfer->spend_space);
                // if user space update
                if ($updateUserSpace) {
                    // Back with success message
                    session()->flash('success', 'Transfer canceled successfully');
                    return back();
                } else {
                    // back with error
                    return redirect()->back()->withErrors(['User space cannot be updated']);
                }
            } else {
                // back with error
                return redirect()->back()->withErrors(['Transfer cannot be updated']);
            }
        } else {
            // Abort 404
            return abort(404);
        }
    }
}
