<?php

namespace App\Http\Controllers\Backend\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Str;

class SettingsController extends Controller
{
    // View settings page
    public function index()
    {
        return view('backend.account.settings');
    }

    // update account information
    public function admin_update_info(Request $request)
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

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // if validate
        if ($validator) {
            $userId = Auth::user()->id; // user id
            // if request avatar is null
            if ($request->avatar == null) {
                // update user information
                $update = User::where('id', $userId)
                    ->update(['name' => $request->name, 'email' => $request->email]);
                // if update
                if ($update) {
                    // Back with success message
                    $request->session()->flash('success', 'Your information has been updated successfully');
                    return back();
                }
            } else {
                $avatar = Auth::user()->avatar; // user avatar
                $path = 'cdn/avatars/';
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
                            'name' => $request->name,
                            'email' => $request->email,
                        ]);
                    // if update
                    if ($update) {
                        // Back with success message
                        $request->session()->flash('success', 'Your information has been updated successfully');
                        return back();
                    }
                } else {
                    // Error response
                    return redirect()->back()->withErrors(['Upload error please refresh page and try again']);
                }

            }
        }
    }

    // update account password
    public function admin_update_password(Request $request)
    {
        // validate form
        $validator = Validator::make($request->all(), [
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:6', 'confirmed'],
            'new-password_confirmation' => ['required'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // if current password does not matches with the password
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // Error response
            return redirect()->back()->withErrors(['Your current password does not matches with the password you provided. Please try again.']);
        }

        // if password is the same as user current password
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            // Error response
            return redirect()->back()->withErrors(['New Password cannot be same as your current password. Please choose a different password.']);
        }

        $user = Auth::user(); // auth user
        $user->password = bcrypt($request->get('new-password')); // new password request
        $user->save(); // save data
        // Back with success message
        $request->session()->flash('success', 'Your password has been changed successfully');
        return back();
    }
}
