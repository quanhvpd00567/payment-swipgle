@extends('layouts.frontend')
@section('title', __('frontend.payments'))
@section('content')
<div class="swipgle-pages">
   <div class="page-header d-print-none">
      <div class="row align-items-center">
         <div class="col">
            <div class="page-pretitle">{{__('frontend.account')}}</div>
            <h2 class="page-title">{{__('frontend.payments')}}</h2>
         </div>
         <div class="col-auto ms-auto">
            <div class="btn-list">
               <a href="{{ route('user.dashboard') }}" class="btn">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <line x1="5" y1="12" x2="19" y2="12" />
                     <line x1="5" y1="12" x2="9" y2="16" />
                     <line x1="5" y1="12" x2="9" y2="8" />
                  </svg>
                  {{__('frontend.back_to_dashboard')}}
               </a>
            </div>
         </div>
      </div>
   </div>
   @if(session('error'))
   <div class="note note-danger">{{ session('error') }}</div>
   @endif
   <div class="note note-danger print-error-msg" style="display:none"><span></span></div>
   <div class="card mb-3">
      <div class="card-header">
         <h3 class="m-0">{{__('frontend.buy_more_space')}}</h3>
         <span class="col-auto ms-auto d-print-none">
         <img src="{{ asset('images/payments/payment-methods.png') }}" alt="Paypal" width="150">
         </span>
      </div>
      <div class="card-body">
         <form id="paymentForm" action="{{ route('create.payment') }}" method="POST">
            @csrf
            <div class="row">
               <div class="col-lg-4">
                  <div class="form-group">
                     <select name="space" id="space" class="form-select" required>
                        <option value="" selected disabled>{{__('frontend.choose_space')}}</option>
                        @foreach($prices as $price)
                        <option value="{{ $price->id }}">{{ formatBytes($price->space) }} = {{ price($price->price) }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="form-group">
                     <select name="method" id="method" class="form-select" required>
                        <option value="" selected disabled>{{__('frontend.choose_payment_method')}}</option>
                        @if($paypal->status == 1)
                        <option value="1">{{__('frontend.paypal')}}</option>
                        @endif
                        @if($stripe->status == 1)
                        <option value="2">{{__('frontend.stripe')}}</option>
                        @endif
                     </select>
                  </div>
               </div>
               <div class="col-lg-4">
                  <button id="proceedToCheckout" type="submit" class="proceedToCheckout btn btn-primary btn-pd w-100">{{__('frontend.proceed_to_checkout')}}</button>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="swipgle-transactions">
      @if($transactions->count() > 0)
      <div class="card">
         <div class="card-header">{{__('frontend.transactions')}}</div>
         <div class="table-responsive transferred-table">
            <table class="table card-table table-vcenter text-nowrap">
               <thead>
                  <tr>
                     <th>{{__('frontend.transaction_id')}}</th>
                     <th class="text-center">{{__('frontend.purchased_space')}}</th>
                     <th class="text-center">{{__('frontend.space_cost')}}</th>
                     <th class="text-center">{{__('frontend.payment_method')}}</th>
                     <th class="text-center">{{__('frontend.purchased_date')}}</th>
                     <th class="text-center">{{__('frontend.status')}}</th>
                     <th class="text-center">{{__('frontend.action')}}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($transactions as $transaction)
                  <tr>
                     <td>#{{ $transaction->id }}</td>
                     <td class="text-center @if($transaction->payment_status != 3)text-primary @else text-danger @endif"><strong>+{{ formatBytes($transaction->space) }}</strong></td>
                     <td class="text-center">{{ transaction_price($transaction->amount).' '.$transaction->currency }}</td>
                     <td class="text-center">{{ $transaction->method }}</td>
                     <td class="text-center">@datetime($transaction->created_at)</td>
                     <td class="text-center">{!! transactionStatus($transaction->payment_status) !!}</td>
                     <td class="text-center">
                        @if($transaction->payment_status == 3 or $transaction->payment_status == 2)
                        <a href="{{ route('view.user.transaction', $transaction->id) }}" class="btn btn-sm">{{__('frontend.view_transaction')}}</a>
                        @else 
                        <a href="{{ route('checkout', $transaction->generate_id) }}" class="btn btn-success btn-sm">{{__('frontend.pay')}}</a>
                        <a href="#" id="cancelTransaction" data-id="{{ $transaction->id }}" class="btn btn-danger btn-sm">{{__('frontend.cancel')}}</a>
                        @endif
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      {{$transactions->links()}}
      @else 
      <div class="empty py-5">
         <div class="empty-img"><img src="{{ asset('images/sections/empty.svg') }}" height="128" alt="Empty">
         </div>
         <p class="empty-title">{{__('frontend.no_transactions_found')}}</p>
         <p class="empty-subtitle text-muted">{{__('frontend.no_transactions_description')}}</p>
      </div>
      @endif
   </div>
</div>
@endsection