<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessagesController extends Controller
{
    // View messages page
    public function index()
    {
        // Get all messages
        $messages = Message::with('user')->orderbyDesc('id')->paginate(10);
        return view('backend.messages', ['messages' => $messages]);
    }

    // View message
    public function view_message($id)
    {
        // Get message data
        $message = Message::with('user')->where('id', $id)->first();
        // If data not null
        if ($message != null) {
            // if message status = 1 update it to 2
            if ($message->status == 1) {
                $update = Message::where('id', $id)->update(['status' => 2]);
            }
            return view('backend.view.message', ['message' => $message]);
        } else {
            // if data null back to messages
            return redirect()->route('messages');
        }
    }

    // Delete message
    public function delete_message($id)
    {
        // Get message data
        $message = Message::where('id', $id)->first();
        // if data not null
        if ($message != null) {
            // delete message
            $delete = Message::where('id', $id)->delete();
            // if message deleted
            if ($delete) {
                // Back with success message
                session()->flash('success', 'Message deleted successfully');
                return back();
            } else {
                // Error response
                return redirect()->back()->withErrors(['Delete error please refresh page and try again']);
            }
        } else {
            // Error response
            return redirect()->back()->withErrors(['Delete error please refresh page and try again']);
        }
    }
}
