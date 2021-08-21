<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Temp;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Storage;

class SettingsController extends Controller
{
    // View settings page
    public function index()
    {
        // get cache
        $cache = Temp::where('user_id', Auth::user()->id)->where('created_at', '<=', Carbon::now()->subMinutes(30))->sum('file_size');
        return view('frontend.user.settings', ['cache' => $cache]);
    }

    public function updateInfo(Request $request)
    {

        $validator = null;
        // if email is the same auth email
        if (Auth::user()->email === $request['email']) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'avatar' => ['max:2048', 'mimes:jpg,png,jpeg'],
            ]);
        } else {
            // if email is new must be unique
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'avatar' => ['max:2048', 'mimes:jpg,png,jpeg'],
            ]);
        }

        // Errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // if validate
        if ($validator) {
            $userId = Auth::user()->id; // user id
            $path = "cdn/avatars/";
            // if request avatar is null
            if ($request['avatar'] == null) {
                // update user information
                $update = User::where('id', $userId)
                    ->update(['name' => $request['name'], 'email' => $request['email']]);
                // if update
                if ($update) {
                    // Success response
                    return response()->json(['success' => __('alerts.success_info_update')]);
                }
            } else {
                $avatar = Auth::user()->avatar; // user avatar
                // if avatar is default
                if ($avatar != 'default.png') {
                    // if file exists delete it
                    if (file_exists($path . $avatar)) {
                        $deleteOldAvatar = File::delete($path . $avatar);
                    }
                }
                $string = Str::random(50); // 50 rendom string for new avatar name
                $avatarName = $string . '.' . $request->avatar->getclientoriginalextension(); // New avatar name
                $upload = $request->avatar->move($path, $avatarName); // move avatar to path
                // if upload
                if ($upload) {
                    // update user data
                    $update = User::where('id', $userId)
                        ->update([
                            'avatar' => $avatarName,
                            'name' => $request['name'],
                            'email' => $request['email'],
                        ]);
                    // if update
                    if ($update) {
                        // success response
                        return response()->json(['success' => __('alerts.success_info_update')]);
                    }
                } else {
                    // error response
                    return response()->json(['error' => [__('alerts.upload_error')]]);
                }

            }
        }
    }

    // Update user password
    public function updatePassword(Request $request)
    {
        // validate form
        $validator = Validator::make($request->all(), [
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:6', 'confirmed'],
            'new-password_confirmation' => ['required'],
        ]);

        // errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // if current password does not matches with the password
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return response()->json(['error' => [__('alerts.password_not_matches')]]);
        }

        // if password is the same as user current password
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return response()->json(['error' => [__('alerts.password_different')]]);
        }

        $user = Auth::user(); // auth user
        $user->password = bcrypt($request->get('new-password')); // new password request
        $user->save(); // save data
        // success response
        return response()->json(['success' => __('alerts.success_password_update')]);
    }

    // Delete user cache
    public function deleteCache()
    {
        // check if user has cache
        $temps = Temp::where('user_id', Auth::user()->id)->where('created_at', '<=', Carbon::now()->subMinutes(30))->get();
        // if data not null
        if ($temps->count() > 0) {
            // Count space
            $space = Temp::where('user_id', Auth::user()->id)->where('created_at', '<=', Carbon::now()->subMinutes(30))->sum('file_size');
            // update user
            $update = User::where('id', Auth::user()->id)->increment('space', $space);
            // if update
            if ($update) {
                // delete files
                foreach ($temps as $temp) {
                    // check file storage
                    if ($temp->file_storage == 1) {
                        // File path
                        $filePath = 'public/files/' . $temp->file_name;
                        // Delete file
                        if (Storage::disk('local')->has($filePath)) {
                            $delete = Storage::disk('local')->delete($filePath);
                        }
                    } elseif ($temp->file_storage == 2) {
                        // Delete file
                        if (Storage::disk('s3')->has($temp->file_name)) {
                            $delete = Storage::disk('s3')->delete($temp->file_name);
                        }
                    } else {
                        // error response
                        return response()->json(['error' => __('alerts.storage_error')]);
                    }
                }
                // delete cache
                $delete = Temp::where('user_id', Auth::user()->id)->where('created_at', '<=', Carbon::now()->subMinutes(30))->delete();
                // if delete
                if ($delete) {
                    // success response
                    return response()->json(['success' => __('alerts.cache_deleted')]);
                }
            } else {
                // error response
                return response()->json(['error' => __('alerts.cache_empty')]);
            }
        } else {
            // error response
            return response()->json(['error' => __('alerts.cache_empty')]);
        }
    }
}
