<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Temp;
use App\Models\Transfer;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Str;

class TransferController extends Controller
{
    // Handle expiry time
    private function swipgle_expiry($request_value)
    {
        // Get today datetime
        $date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->toDateTimeString());
        // Check if request is days or hour
        if ($request_value != 1) {
            // Check request value
            if ($request_value == 2) {
                $daysDays = 1; // one day
                $expiry = $date->addDays($daysDays); // Add 1 day
            } elseif ($request_value == 3) {
                $daysDays = 7; // 7 days
                $expiry = $date->addDays($daysDays); // Add 7 days
            } elseif ($request_value == 4) {
                $daysDays = 30; // 7 days
                $expiry = $date->addDays($daysDays); // Add 30 days
            } else {
                $daysHours = 1; // Much hours
                $expiry = $date->addHours($daysHours); // Add hours
            }
        } else {
            $daysHours = 1; // Much hours
            $expiry = $date->addHours($daysHours); // Add hours
        }
        return $expiry;
    }

    // Start ganarate link
    public function link(Request $request)
    {
        // check if user auth
        if (Auth::user()) {
            try {
                // check if there is file uploaded
                if ($request->has('files')) {
                    $files = []; // files array
                    $sizes = []; // sizes array
                    // Check if any file is empty
                    foreach ($request->input('files') as $file) {
                        if ($file == null) {
                            // Error response
                            return response()->json([
                                'error' => [__('alerts.missing_files')],
                            ]);
                        } else {
                            $files[] = $file; // files array
                            // get file sizes
                            $temps = Temp::where('file_name', $file)->where('user_id', Auth::user()->id)->get();
                            // if data not null
                            if ($temps->count() > 0) {
                                foreach ($temps as $temp) {
                                    $sizes[] = $temp->file_size; // sizes array
                                }
                            } else {
                                // Error response
                                return response()->json([
                                    'error' => [__('alerts.illegal_request')],
                                ]);
                            }
                        }
                    }

                    // Validate form
                    if ($request->link_password) {
                        $validator = Validator::make($request->all(), [
                            'link_from_email' => ['required', 'email'],
                            'link_subject' => ['max:150'],
                            'link_password' => ['min:8'],
                        ]);
                    } else {
                        $validator = Validator::make($request->all(), [
                            'link_from_email' => ['required', 'email'],
                            'link_subject' => ['max:150'],
                        ]);
                    }
                    // Errors response
                    if ($validator->fails()) {
                        return response()->json(['error' => $validator->errors()->all()]);
                    } else {
                        // get website settings
                        $settings = DB::table('settings')->where('id', 1)->first();
                        // check max files
                        if (count($files) > $settings->max_files) {
                            // Error response
                            return response()->json([
                                'error' => ['Max files allowed is' . $settings->max_files],
                            ]);
                        }
                        // check website storage
                        if ($settings->website_storage == 1) {
                            // set storage method
                            $storage_method = 1;
                        } elseif ($settings->website_storage == 2) {
                            // set storage method
                            $storage_method = 2;
                        } else {
                            // Error response
                            return response()->json([
                                'error' => ['Opps !! Storage error.'],
                            ]);
                        }
                        // check password
                        if ($request->link_password != null) {
                            $password = Hash::make($request->link_password); // password
                        } else {
                            $password = null; // set password as null
                        }
                        $user_id = Auth::user()->id; // user id
                        $transfer_id = Str::random(15); // transfer id
                        $transferted_files = implode(",", $files); // transfered files
                        $email_from = $request->link_from_email; // email from
                        $subject = $request->link_subject; // subject
                        $expiry_time = $this->swipgle_expiry($request->link_expiry_time); // expiry time
                        $total_files = count($files); // total files
                        $spend_space = array_sum($sizes); // spend space
                        $create_method = 2; // create method

                        // Start create new transfer
                        $transfer = Transfer::create([
                            'user_id' => $user_id,
                            'transfer_id' => $transfer_id,
                            'transferted_files' => $transferted_files,
                            'email_from' => $email_from,
                            'subject' => $subject,
                            'password' => $password,
                            'expiry_time' => $expiry_time,
                            'total_files' => $total_files,
                            'spend_space' => $spend_space,
                            'storage_method' => $storage_method,
                            'create_method' => $create_method,
                        ]);

                        // if transfer created
                        if ($transfer) {
                            // success message with link
                            return response()->json([
                                'msg' => __('alerts.link_generated'),
                                'link' => url('download/' . $transfer_id),
                            ]);
                        }

                    }
                } else {
                    // Error response
                    return response()->json([
                        'error' => [__('alerts.upload_files_required')],
                    ]);
                }
            } catch (\Exception $e) {
                // Error response
                return response()->json([
                    'error' => [$e->getMessage()],
                ]);
            }
        } else {
            // Error response
            return response()->json([
                'error' => [__('alerts.login_required')],
            ]);
        }
    }

    // Start transfer files
    public function send(Request $request)
    {
        // check if user auth
        if (Auth::user()) {
            try {
                // check if there is file uploaded
                if ($request->has('files')) {
                    $files = []; // files array
                    $sizes = []; // sizes array
                    // Check if any file is empty
                    foreach ($request->input('files') as $file) {
                        if ($file == null) {
                            // Error response
                            return response()->json([
                                'error' => [__('alerts.missing_files')],
                            ]);
                        } else {
                            $files[] = $file; // files array
                            // get file sizes
                            $temps = Temp::where('file_name', $file)->where('user_id', Auth::user()->id)->get();
                            // if data not null
                            if ($temps->count() > 0) {
                                foreach ($temps as $temp) {
                                    $sizes[] = $temp->file_size; // sizes array
                                }
                            } else {
                                // Error response
                                return response()->json([
                                    'error' => [__('alerts.illegal_request')],
                                ]);
                            }
                        }
                    }
                    // Get emails to
                    $emails = []; // emails
                    foreach ($request->input('email_to') as $email) {
                        $emails[] = $email;
                    }
                    // Validate form
                    if ($request->password) {
                        $validator = Validator::make($request->all(), [
                            'email_to.*' => ['required', 'email'],
                            'from_email' => ['required', 'email'],
                            'subject' => ['max:150'],
                            'message' => ['max:500'],
                            'link_password' => ['min:8'],
                        ]);
                    } else {
                        $validator = Validator::make($request->all(), [
                            'email_to.*' => ['required', 'email'],
                            'from_email' => ['required', 'email'],
                            'subject' => ['max:150'],
                            'message' => ['max:500'],
                        ]);
                    }
                    // Errors response
                    if ($validator->fails()) {
                        return response()->json(['error' => $validator->errors()->all()]);
                    } else {
                        // get website settings
                        $settings = DB::table('settings')->where('id', 1)->first();
                        // check max files
                        if (count($files) > $settings->max_files) {
                            // Error response
                            return response()->json([
                                'error' => [__('alerts.max_files_allowed') . $settings->max_files],
                            ]);
                        }
                        // check website storage
                        if ($settings->website_storage == 1) {
                            // set storage method
                            $storage_method = 1;
                        } elseif ($settings->website_storage == 2) {
                            // set storage method
                            $storage_method = 2;
                        } else {
                            // Error response
                            return response()->json([
                                'error' => [__('alerts.storage_error')],
                            ]);
                        }

                        // check password
                        if ($request->password != null) {
                            $pass = $request->password;
                            $password = Hash::make($pass); // password
                        } else {
                            $pass = "--";
                            $password = null; // set password as null
                        }
                        $user_id = Auth::user()->id; // user id
                        $transfer_id = Str::random(15); // transfer id
                        $transferted_files = implode(",", $files); // transfered files
                        $email_to = implode(",", $emails); // emails to
                        $email_from = $request->from_email; // email from
                        $subject = $request->subject; // subject
                        $message = $request->message; // subject
                        $expiry_time = $this->swipgle_expiry($request->expiry_time); // expiry time
                        $total_files = count($files); // total files
                        $spend_space = array_sum($sizes); // spend space
                        $create_method = 1; // create method

                        // Start create new transfer
                        $transfer = Transfer::create([
                            'user_id' => $user_id,
                            'transfer_id' => $transfer_id,
                            'transferted_files' => $transferted_files,
                            'email_to' => $email_to,
                            'email_from' => $email_from,
                            'subject' => $subject,
                            'message' => $message,
                            'password' => $password,
                            'expiry_time' => $expiry_time,
                            'total_files' => $total_files,
                            'spend_space' => $spend_space,
                            'storage_method' => $storage_method,
                            'create_method' => $create_method,
                        ]);

                        // if transfer created
                        if ($transfer) {
                            // check subject
                            if ($subject != null) {
                                $email_subject = $subject;
                            } else {
                                $email_subject = $email_from . __('mail.sent_you_some_files');
                            }

                            // check message
                            if ($message != null) {
                                $email_message = $message;
                            } else {
                                $email_message = $email_from . __('mail.sent_you_some_files');
                            }

                            $emailcontent = array(
                                'expiry' => $expiry_time, // expiry time
                                'email' => $email_from, // Mail from
                                'emailmessage' => $email_message, // Mail message
                                'filesize' => $spend_space, // File size
                                'password' => $pass, // transfer password
                                'download_link' => url('download/' . $transfer_id), // Download link
                                'files' => $files, // Transfered files
                            );
                            // Start new mail
                            Mail::send('mail.transfer', $emailcontent, function ($message) use ($emails, $email_subject) {
                                $message->to($emails)->subject($email_subject);
                            });
                            // success message
                            return response()->json([
                                'success' => __('alerts.files_transfered'),
                            ]);
                        }
                    }
                } else {
                    // Error response
                    return response()->json([
                        'error' => [__('alerts.upload_files_required')],
                    ]);
                }
            } catch (\Exception $e) {
                // Error response
                return response()->json([
                    'error' => [$e->getMessage()],
                ]);
            }
        } else {
            // Error response
            return response()->json([
                'error' => [__('alerts.login_required')],
            ]);
        }
    }
}
