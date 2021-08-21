<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use Auth;

class TransfersController extends Controller
{
    // View transfer
    public function index($transfer_id)
    {
        // Get transfer data
        $transfer = Transfer::where('user_id', Auth::user()->id)->where('transfer_id', $transfer_id)->first();
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
            return view('frontend.user.view.transfer', ['transfer' => $transfer, 'files' => $files, 'emails' => $emails]);
        } else {
            // abort 404
            return abort(404);
        }
    }
}
