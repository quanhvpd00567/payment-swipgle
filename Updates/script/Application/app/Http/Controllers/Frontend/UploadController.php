<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Temp;
use App\Models\Transfer;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;
use Str;

class UploadController extends Controller
{
    // Start uploading files
    public function index(Request $request)
    {
        // Check if user auth
        if (Auth::user()) {
            // Check auth space
            if (Auth::user()->space != 0) {
                try {
                    // if request file
                    if ($request->hasFile('uploads')) {
                        // Uploaded file
                        $file = $request->file('uploads');
                        // File size
                        $fileSize = $file->getSize();
                        // Check if there is space for this file
                        if (Auth::user()->space >= $fileSize) {
                            // Settings information
                            $settings = DB::table('settings')->where('id', 1)->first();
                            // give file new name
                            $string = Str::random(15);
                            // file type
                            $fileType = $file->getclientoriginalextension();
                            // new file name
                            $uploadName = $string . '.' . $fileType;
                            // Upload using storage
                            if ($settings->website_storage == 1) {
                                // upload path
                                $filePath = 'public/files/' . $uploadName;
                                // Put file in local storage
                                $upload = Storage::disk('local')->put($filePath, fopen($file, 'r+'));
                                // file storage
                                $file_storage = 1;
                            } elseif ($settings->website_storage == 2) {
                                // Storage file to amazon S3
                                $upload = Storage::disk('s3')->put($uploadName, fopen($file, 'r+'), 'public');
                                // file storage
                                $file_storage = 2;
                            } else {
                                // error response
                                return response()->json(array(
                                    'type' => 'error',
                                    'errors' => __('alerts.storage_error'),
                                ));
                            }
                            // if upload
                            if ($upload) {
                                // Create file temp
                                $temp = Temp::create([
                                    'user_id' => Auth::user()->id,
                                    'file_name' => $uploadName,
                                    'file_size' => $fileSize,
                                    'file_storage' => $file_storage,
                                ]);
                                // if temp created
                                if ($temp) {
                                    // Update user space
                                    $updateSpace = User::where('id', Auth::user()->id)->decrement('space', $fileSize);
                                    // if space update
                                    if ($updateSpace) {
                                        // success array
                                        $response = array(
                                            'type' => 'success',
                                            'msg' => 'success',
                                            'name' => $uploadName,
                                        );
                                        // success response
                                        return response()->json($response);
                                    } else {
                                        // error response
                                        return response()->json(array(
                                            'type' => 'error',
                                            'errors' => __('alerts.upload_error'),
                                        ));
                                    }
                                }
                            } else {
                                // error response
                                return response()->json(array(
                                    'type' => 'error',
                                    'errors' => __('alerts.upload_error'),
                                ));
                            }
                        } else {
                            // error response
                            return response()->json(array(
                                'type' => 'error',
                                'errors' => __('alerts.insufficient_space'),
                            ));
                        }
                    } else {
                        // error response
                        return response()->json(array(
                            'type' => 'error',
                            'errors' => __('alerts.illegal_request'),
                        ));
                    }
                } catch (\Exception $e) {
                    // error response
                    return response()->json(array(
                        'type' => 'error',
                        'errors' => $e->getMessage(),
                    ));
                }
            } else {
                // error response
                return response()->json(array(
                    'type' => 'error',
                    'errors' => __('alerts.insufficient_space'),
                ));
            }

        } else {
            // error response
            return response()->json(array(
                'type' => 'error',
                'errors' => __('alerts.login_required'),
            ));
        }
    }

    // Delete uploads
    public function deleteUploads($filename)
    {
        // If user auth
        if (Auth::user()) {
            // Find file
            $findFile = Temp::where('file_name', $filename)->where('user_id', Auth::user()->id)->first();
            // check if file is transfered or not
            $transfer = Transfer::where('user_id', Auth::user()->id)->where('transferted_files', 'LIKE', '%' . $filename . '%')->get();
            // if data not null
            if ($filename != null) {
                // if file already transfered
                if ($transfer->count() < 1) {
                    // Check storaage method
                    if ($findFile->file_storage == 1) {
                        // File path
                        $filePath = 'public/files/' . $filename;
                        // Delete file
                        if (Storage::disk('local')->has($filePath)) {
                            $delete = Storage::disk('local')->delete($filePath);
                        }
                    } elseif ($findFile->file_storage == 2) {
                        // if file exists in s3
                        if (Storage::disk('s3')->has($filename)) {
                            // Delete file from amazon s3
                            $delete = Storage::disk('s3')->delete($filename);
                        }
                    }

                    // update user
                    $update = User::where('id', Auth::user()->id)->increment('space', $findFile->file_size);
                }
                // delete from temp database
                $deleteFile = Temp::where('file_name', $filename)->where('user_id', Auth::user()->id)->delete();

            } else {
                // error response
                return response()->json(['error' => __('alerts.file_not_found')]);
            }
        }
    }
}
