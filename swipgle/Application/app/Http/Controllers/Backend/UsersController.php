<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    // View users page
    public function index()
    {
        // Get users
        $users = User::orderbyDesc('id')->get();
        return view('backend.users', ['users' => $users]);
    }

    // Add new admin
    public function add_user_store(Request $request)
    {
        // validate form
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $permission = 1; // permission 1 is admin
        $avatar = "default.png"; // default avatar

        // create the new user
        $register = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'avatar' => $avatar,
            'password' => Hash::make($request['password']),
            'permission' => $permission,
        ]);

        // if registered
        if ($register) {
            // Back with success message
            $request->session()->flash('success', 'New admin added successfully');
            return back();
        }
    }

    // Edit user
    public function edit_user($id)
    {
        // Get user data
        $user = User::find($id);
        // if not data null
        if ($user != null) {
            return view('backend.edit.user', ['user' => $user]);
        } else {
            // Abort 404
            return abort(404);
        }
    }

    // Update user information
    public function edit_user_store(Request $request)
    {
        // Get user info
        $user = User::where('id', $request->user_id)->first();
        // if data not null
        if ($user != null) {
            // check auth
            if ($request->user_id == Auth::user()->id) {
                return redirect()->back()->withErrors(['You cannot update your data']);
            }
            // validate form
            $validator = Validator::make($request->all(), [
                'status' => ['required', 'numeric'],
                'space' => ['required', 'numeric'],
            ]);

            // Send errors to view page
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // check status
            $status = array('1', '2');
            if (!in_array($request->status, $status)) {
                return redirect()->back()->withErrors(['status error, please refresh page and try again']);
            }

            // update user info
            $update = User::where('id', $request->user_id)->update([
                'status' => $request->status,
                'space' => $request->space,
            ]);

            // if registered
            if ($update) {
                // Back with success message
                $request->session()->flash('success', 'User updated successfully');
                return back();
            }
        } else {
            // back with error
            return redirect()->back()->withErrors(['User error, please refresh page and try again']);
        }

    }
}
