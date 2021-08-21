@extends('layouts.frontend')
@section('title', __('frontend.checkout').' - '.$transaction->generate_id)
@section('content')
<div class="swipgle-pages">
   <div class="card">
      <div class="card-header bg-swipgle-primary text-center d-block py-4">
         <a href="{{ url('/') }}">
         <img src="{{ logofav($settings->logo) }}" alt="{{ $settings->website_name }}" width="150">
         </a>
      </div>
      <div class="card-body checkout-card-body">
         <div class="row d-flex justify-content-center">
            <div class="col-sm-5 col-md-5 checkout-information">
               @if(session('error'))
               <div class="note note-danger">{{ session('error') }}</div>
               @endif
               <p>{{__('frontend.this_transaction_was_created_on')}}@datetime($transaction->created_at) {{__('frontend.to_purchase_an_amount_of_space')}}{{ formatBytes($transaction->space) }}</p>
               <div class="checkout-payment">
                  <form action="{{ route('new.payment') }}" method="POST" id="payment-form">
                     @csrf
                     <input type="hidden" name="checkout_token" value="{{ $transaction->generate_id }}">
                     <input type="hidden" name="checkout_method" value="{{ $transaction->method }}">
                     @if($transaction->method == "paypal")
                     <button class="btn btn-paypal" type="submit">
                        <h2>{{__('frontend.checkout_with')}}</h2>
                        <img src="{{ asset('images/payments/paypal.png') }}" alt="Paypal" width="90">
                     </button>
                     @elseif($transaction->method == "stripe")
                     <h3>{{__('Card details')}}</h3>
                     <div class="checkout-stripe-card mb-3" id="card-element">
                     </div>
                     <button class="btn btn-primary">{{__('frontend.pay_now_btn')}}</button>
                     @endif
                  </form>
               </div>
            </div>
            <div class="col-sm-3 col-md-4 offset-md-1 mobile-order-first checkout-right-side">
               <div class="py-4 d-flex justify-content-end">
                  <h6><a href="{{ route('payments.page') }}">{{__('frontend.cancel_and_back_to_payments')}}</a></h6>
               </div>
               <div class="bg-light rounded d-flex flex-column p-3 mb-3">
                  <div class="d-flex">
                     <div class="col-8">
                        <h1 class="m-0">{{__('frontend.space') }}</h1>
                     </div>
                     <div class="col-auto">
                        <h1 class="text-primary m-0">+{{ formatBytes($transaction->space) }}</h1>
                     </div>
                  </div>
               </div>
               <div class="bg-light rounded d-flex flex-column p-3">
                  <div class="d-flex">
                     <div class="col-8">
                        <h1 class="m-0">{{__('frontend.price') }}</h1>
                     </div>
                     <div class="col-auto">
                        <h1 class="text-success m-0">{{ transaction_price($transaction->amount).' '.$transaction->currency }}</h1>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="text-right checkout-powered-by">
            <span class="text-muted"><i>{{__('frontend.powered_by')}}</i></span>
            @if($transaction->method == "paypal")
            <a href="https://www.paypal.com" target="_blank"><img src="{{ asset('images/payments/paypal.png') }}" width="60" alt="paypal"></a>
            @elseif($transaction->method == "stripe")
            <a href="https://stripe.com" target="_blank"><img src="{{ asset('images/payments/stripe.png') }}" width="60" alt="stripe"></a>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection