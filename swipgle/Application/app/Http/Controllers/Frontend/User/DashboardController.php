<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transfer;
use Auth;

class DashboardController extends Controller
{
    // View user dashboard
    public function index()
    {
        // Count transactions
        $transactionsCount = Transaction::where('user_id', Auth::user()->id)->get()->count();
        // count total files transfered
        $total_files = Transfer::where('user_id', Auth::user()->id)->orderbyDesc('id')->sum('total_files');
        // Get transfers
        $transfers = Transfer::where('user_id', Auth::user()->id)->orderbyDesc('id')->paginate(10);
        return view('frontend.user.dashboard', ['transactionsCount' => $transactionsCount, 'total_files' => $total_files, 'transfers' => $transfers]);
    }
}
