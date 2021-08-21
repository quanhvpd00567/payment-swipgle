<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
use Str;

class PaymentsController extends Controller
{
    public $gateway;

    // __construct
    public function __construct()
    {
        if (env('PAYPAL_TEST_MODE') != 1) {
            $mode = false;
        } else {
            $mode = true;
        }
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID')); // Paypal client ID
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET')); // Paypal Client secret
        $this->gateway->setTestMode($mode); // Paypal test mode
    }

    // View payments page
    public function index()
    {
        // Get prices
        $prices = Price::orderbyDesc('id')->get();
        // Get transactions
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderbyDesc('id')->paginate(10);
        // Get paypal data
        $paypal = DB::table('paypal')->find(1);
        // Get stripe data
        $stripe = DB::table('stripe')->find(1);
        return view('frontend.user.payments', ['prices' => $prices, 'transactions' => $transactions, 'paypal' => $paypal, 'stripe' => $stripe]);
    }

    // View transaction
    public function view_transaction($id)
    {
        // Get transaction
        $transaction = Transaction::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->whereIn('payment_status', [2, 3])
            ->first();
        // if data not null
        if ($transaction != null) {
            return view('frontend.user.view.transaction', ['transaction' => $transaction]);
        } else {
            // Abort 404
            return abort(404);
        }
    }

    // Create new payment
    public function payment_create(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'space' => ['required'],
            'method' => ['required'],
        ]);

        // Errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // Check price
        $priceCheck = Price::where('id', $request->space)->first();
        // if data not null
        if ($priceCheck != null) {
            // Check request method
            if ($request->method == 1) {
                // Get paypal data
                $paypal = DB::table('paypal')->find(1);
                // Check if paypal is active or not
                if ($paypal->status == 1) {
                    // Check paypal information
                    if (env('PAYPAL_CLIENT_ID') == null or env('PAYPAL_CLIENT_SECRET') == null) {
                        // Error response
                        return response()->json(['error' => [__('alerts.paypal_missing_information')]]);
                    }
                    $method = "paypal"; // Set payment method
                } else {
                    // Error response
                    return response()->json(['error' => [__('alerts.payment_method_unavailable')]]);
                }
            } elseif ($request->method == 2) {
                // Get stripe data
                $stripe = DB::table('stripe')->find(1);
                // Check if stripe is active or not
                if ($stripe->status == 1) {
                    // Check stripe information
                    if (env('STRIPE_PUBLISHABLE_KEY') == null or env('STRIPE_SECRET_KEY') == null) {
                        // Error response
                        return response()->json(['error' => [__('alerts.stripe_missing_information')]]);
                    }
                    $method = "stripe"; // Set payment method
                } else {
                    // Error response
                    return response()->json(['error' => [__('alerts.payment_method_unavailable')]]);
                }

            } else {
                // Error response
                return response()->json(['error' => [__('alerts.payment_method_unavailable')]]);
            }

            $amount = $priceCheck->price; // Get price
            $user_id = Auth::user()->id; // User ID
            $generate_id = sha1(Str::random(30)); // Generate ID
            $space = $priceCheck->space; // Space
            $currency = env('WEBSITE_CURRENCY'); // Currency

            // create new transaction
            $newTransaction = Transaction::create([
                'user_id' => $user_id,
                'generate_id' => $generate_id,
                'space' => $space,
                'method' => $method,
                'amount' => $amount,
                'currency' => $currency,
            ]);

            // if trnsaction created
            if ($newTransaction) {
                // Success response
                return response()->json(['success' => route('checkout', $generate_id)]);
            }
        } else {
            // Error response
            return response()->json(['error' => [__('alerts.illegal_request')]]);
        }
    }

    // Checkout
    public function checkout($generate_id)
    {
        // Get transaction
        $transaction = Transaction::where('generate_id', $generate_id)
            ->where('user_id', Auth::user()->id)
            ->where('payment_status', 1)
            ->first();
        // If transaction no nul
        if ($transaction != null) {
            return view('frontend.checkout', ['transaction' => $transaction]);
        } else {
            // Abort 404
            return abort(404);
        }
    }

    // Start new payment
    public function charge(Request $request)
    {
        // Generated id
        $generate_id = $request->checkout_token;
        // Checkout method
        $method = $request->checkout_method;
        // if request generate_id
        if ($request->has('checkout_token')) {
            // Get transaction data
            $transaction = Transaction::where('generate_id', $generate_id)
                ->where('method', $method)
                ->where('user_id', Auth::user()->id)
                ->where('payment_status', 1)
                ->first();
            // If transaction no nul
            if ($transaction != null) {
                $amount = $transaction->amount; // checkout price
                $currency = $transaction->currency; // checkout currency
                if ($transaction->method == "paypal") {
                    // Get paypal data
                    $paypal = DB::table('paypal')->find(1);
                    // Check if paypal is active or not
                    if ($paypal->status == 1) {
                        // Check paypal information
                        if (env('PAYPAL_CLIENT_ID') == null or env('PAYPAL_CLIENT_SECRET') == null) {
                            // Back with error
                            $request->session()->flash('error', __('alerts.paypal_missing_information'));
                            return back();
                        }
                        try {
                            // New purchase
                            $response = $this->gateway->purchase(array(
                                'amount' => $amount,
                                'currency' => $currency,
                                'returnUrl' => route('payment.success'),
                                'cancelUrl' => route('payment.error'),
                            ))->send();

                            // get response data
                            $data = $response->getData();

                            if ($response->isRedirect()) {
                                // update transaction
                                $updateTransaction = Transaction::where('generate_id', $generate_id)
                                    ->where('method', $method)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('payment_status', 1)
                                    ->update(['payment_id' => $data['id']]);

                                // if trnsaction updated
                                if ($updateTransaction) {
                                    // Go to paypal
                                    return redirect($response->getRedirectUrl());
                                }
                            } else {
                                // Back with error
                                $request->session()->flash('error', $response->getMessage());
                                return back();
                            }
                        } catch (Exception $e) {
                            // Back with error
                            $request->session()->flash('error', $e->getMessage());
                            return back();
                        }
                    } else {
                        // Back with error
                        $request->session()->flash('error', __('alerts.payment_method_unavailable'));
                        return back();
                    }
                } elseif ($transaction->method == "stripe") {
                    // Check stripe information
                    if (env('STRIPE_PUBLISHABLE_KEY') == null or env('STRIPE_SECRET_KEY') == null) {
                        // Back with error
                        $request->session()->flash('error', __('alerts.stripe_missing_information'));
                        return back();
                    }
                    $stripeToken = $request->input('stripeToken');
                    // Check if request has stripe token
                    if ($stripeToken) {
                        try {
                            // Start checkout
                            $gateway = Omnipay::create('Stripe');
                            $gateway->setApiKey(env('STRIPE_SECRET_KEY'));
                            // Response
                            $response = $gateway->purchase([
                                'amount' => $amount,
                                'currency' => env('WEBSITE_CURRENCY'),
                                'token' => $stripeToken,
                            ])->send();

                            // If payments is successful
                            if ($response->isSuccessful()) {
                                $arr_payment_data = $response->getData(); // Get data
                                // update transaction
                                $updateTransaction = Transaction::where('generate_id', $generate_id)
                                    ->where('method', $method)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('payment_status', 1)
                                    ->update([
                                        'payment_id' => $arr_payment_data['id'],
                                        'payer_email' => Auth::user()->email,
                                        'payment_status' => 2,
                                    ]);
                                // if trnsaction updated
                                if ($updateTransaction) {
                                    // find user
                                    $user = User::where('id', $transaction->user_id)->first();
                                    // if user not null
                                    if ($user != null) {
                                        // update user space
                                        $updateUserSpace = User::where('id', $transaction->user_id)->increment('space', $transaction->space);
                                        // If update
                                        if ($updateUserSpace) {
                                            $request->session()->flash('success', __('alerts.paid_success'));
                                            return redirect()->route('user.dashboard');
                                        }
                                    } else {
                                        // Set session
                                        $request->session()->flash('error', __('alerts.addition_space_failed'));
                                        return redirect()->route('payments.page');
                                    }
                                }
                            } else {
                                // payment failed: display message to customer
                                $request->session()->flash('error', $response->getMessage());
                                return back();
                            }
                        } catch (Exception $e) {
                            // Back with error
                            $request->session()->flash('error', $e->getMessage());
                            return back();
                        }
                    } else {
                        // Back with error
                        $request->session()->flash('error', __('alerts.stripe_token_missing'));
                        return back();
                    }
                } else {
                    // Abort 404
                    return abort(404);
                }
            } else {
                // Back with error
                $request->session()->flash('error', __('alerts.checkout_token_authorized'));
                return back();
            }
        } else {
            // Back with error
            $request->session()->flash('error', __('alerts.checkout_token_authorized'));
            return back();
        }
    }

    // When payment success
    public function payment_success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();
                // Find transaction in database
                $findTransaction = Transaction::where('payment_id', $arr_body['id'])
                    ->where('payment_status', 1)
                    ->where('user_id', Auth::user()->id)
                    ->first();
                if ($findTransaction != null) {
                    // Update transaction
                    $updateTransaction = Transaction::where('payment_id', $arr_body['id'])->where('payment_status', 1)->update([
                        'payer_id' => $arr_body['payer']['payer_info']['payer_id'],
                        'payer_email' => $arr_body['payer']['payer_info']['email'],
                        'payment_status' => 2,
                    ]);
                    // if update
                    if ($updateTransaction) {
                        // find user
                        $user = User::where('id', $findTransaction->user_id)->first();
                        // if user not null
                        if ($user != null) {
                            // update user space
                            $updateUserSpace = User::where('id', $findTransaction->user_id)->increment('space', $findTransaction->space);
                            if ($updateUserSpace) {
                                session()->flash('success', __('alerts.paid_success'));
                                return redirect()->route('user.dashboard');
                            }
                        } else {
                            // Set session
                            session()->flash('error', __('alerts.addition_space_failed'));
                            return redirect()->route('payments.page');
                        }
                    }
                } else {
                    // Set session
                    session()->flash('error', __('alerts.unauthorized_transaction'));
                    return redirect()->route('payments.page');
                }

            } else {
                // Set session
                session()->flash('error', $response->getMessage());
                return redirect()->route('payments.page');
            }
        } else {
            // Set session
            session()->flash('error', __('alerts.transaction_declined'));
            return redirect()->route('payments.page');
        }
    }

    // If payment is canceled
    public function payment_error()
    {
        // Set session
        session()->flash('error', __('alerts.transaction_canceled'));
        return redirect()->route('payments.page');
    }

    // Cancel transaction
    public function cancel_payment($id)
    {
        // Get transaction data
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::user()->id)->first();
        // if data not null
        if ($transaction != null) {
            // update status
            $updateTransaction = Transaction::where('id', $id)->where('user_id', Auth::user()->id)->update(['payment_status' => 3]);
            // if update
            if ($updateTransaction) {
                // Success response
                return response()->json(['success' => __('alerts.transaction_canceled_successfully')]);
            }
        } else {
            // Error response
            return response()->json(['error' => __('alerts.illegal_request')]);
        }
    }

}
