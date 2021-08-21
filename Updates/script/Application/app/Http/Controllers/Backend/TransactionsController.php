<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionsController extends Controller
{
    // View transactions page
    public function index()
    {
        // Paid transactions
        $paid_transactions = Transaction::where('payment_status', 2)->with('user')->orderbyDesc('id')->get();
        // Unpaid transactions
        $unpaid_transactions = Transaction::where('payment_status', 1)->with('user')->orderbyDesc('id')->get();
        // Canceled transactions
        $canceled_transactions = Transaction::where('payment_status', 3)->with('user')->orderbyDesc('id')->get();
        return view('backend.transactions', [
            'paid_transactions' => $paid_transactions,
            'unpaid_transactions' => $unpaid_transactions,
            'canceled_transactions' => $canceled_transactions,
        ]);
    }

    // View transaction
    public function view_transaction($id)
    {
        // Find transaction
        $transaction = Transaction::with('user')->find($id);
        // if data not null
        if ($transaction != null) {
            return view('backend.view.transaction', ['transaction' => $transaction]);
        } else {
            // Abort 404
            return abort(404);
        }
    }
}
