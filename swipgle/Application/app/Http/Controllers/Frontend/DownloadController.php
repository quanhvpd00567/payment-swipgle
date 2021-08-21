<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;

class DownloadController extends Controller
{
    // View download page
    public function index($transfer_id)
    {
        // Get transfer data
        $transfer = Transfer::where('transfer_id', $transfer_id)->where('tranfer_status', 1)->first();
        // if data not null
        if ($transfer != null) {
            // check file expiry
            if (Carbon::createFromFormat('Y-m-d H:i:s', $transfer->expiry_time)->isPast() != true) {
                // check if transfer has password
                if ($transfer->password != null) {
                    // check if session has transfer_id
                    if (!session()->has($transfer_id)) {
                        // redirect to password page
                        return redirect()->route('download.password', $transfer_id);
                    }
                }
                // Get user data
                $user = User::where('id', $transfer->user_id)->first();
                // Get files
                $files = [];
                $transferFiles = explode(',', $transfer->transferted_files);
                foreach ($transferFiles as $transferFile) {
                    $files[] = $transferFile;
                }
                return view('frontend.download', ['transfer' => $transfer, 'user' => $user, 'files' => $files]);
            } else {
                // Abort 404
                return abort(404);
            }
        } else {
            // Abort 404
            return abort(404);
        }
    }

    // request download files
    public function request_download($id, $file_name)
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
                        // success message with link
                        return response()->json([
                            'download_link' => route('download.file', [$id, $file_name]),
                        ]);
                    } else {
                        // Error response
                        return response()->json([
                            'error' => __('alerts.file_not_found'),
                        ]);
                    }
                } elseif ($transfer->storage_method == 2) {
                    // storage disk
                    $disk = Storage::disk('s3');
                    // if file exists download it
                    if ($disk->has($file_name)) {
                        // success message with link
                        return response()->json([
                            'download_link' => route('download.file', [$id, $file_name]),
                        ]);
                    } else {
                        // Error response
                        return response()->json([
                            'error' => __('alerts.file_not_found'),
                        ]);
                    }
                } else {
                    // Error response
                    return response()->json([
                        'error' => __('alerts.storage_error'),
                    ]);
                }
            } else {
                // Error response
                return response()->json([
                    'error' => __('alerts.download_link_expired'),
                ]);
            }
        } else {
            // Error response
            return response()->json([
                'error' => __('alerts.file_not_found'),
            ]);
        }
    }

    // download files
    public function download($id, $file_name)
    {
        // get data
        $transfer = Transfer::where('id', $id)->where('transferted_files', 'LIKE', '%' . $file_name . '%')->where('tranfer_status', 1)->first();
        // if data not null
        if ($transfer != null) {
            // check file expiry
            if (Carbon::createFromFormat('Y-m-d H:i:s', $transfer->expiry_time)->isPast() != true) {
                // check if transfer has password
                if ($transfer->password != null) {
                    // check if session has transfer_id
                    if (!session()->has($transfer->transfer_id)) {
                        // redirect to password page
                        return redirect()->route('download.password', $transfer->transfer_id);
                    }
                }
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

    // protect files using password
    public function password($transfer_id)
    {
        // Get transfer data
        $transfer = Transfer::where('transfer_id', $transfer_id)->first();
        // if data not null
        if ($transfer != null) {
            // check if transfer has password
            if ($transfer->password == null) {
                // redirect to password page
                return redirect()->route('download.page', $transfer_id);
            }
            // check if session has transfer_id
            if (!session()->has($transfer_id)) {
                // Get user data
                $user = User::where('id', $transfer->user_id)->first();
                return view('frontend.password', ['user' => $user, 'transfer' => $transfer]);
            } else {
                // redirect to password page
                return redirect()->route('download.page', $transfer_id);
            }
        } else {
            // Abort 404
            return abort(404);
        }
    }

    // password submited
    public function password_store(Request $request)
    {
        // validate
        $this->validate($request, [
            'password' => ['required'],
        ]);

        // Get transfer data
        $transfer = Transfer::where('transfer_id', $request->transfer_id)->first();
        // if data not null
        if ($transfer != null) {
            // check if transfer has password
            if ($transfer->password != null) {
                // check password
                if (Hash::check($request->password, $transfer->password)) {
                    // set session
                    $request->session()->put($transfer->transfer_id, $transfer->transfer_id);
                    // back to files
                    return redirect()->route('download.page', $request->transfer_id);
                } else {
                    return redirect()->back()->withErrors(__('alerts.incorrect_password'));
                }

            } else {
                // redirect to password page
                return redirect()->route('download.page', $request->transfer_id);
            }
        } else {
            // back if data is null
            return redirect()->back();
        }

    }
}
