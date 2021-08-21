@extends('layouts.frontend')
@section('title', __('frontend.transaction').' #'.$transaction->id)
@section('content')
<div class="swipgle-pages">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
           <div class="col">
             <div class="page-pretitle">{{__('frontend.account')}}</div>
             <h2 class="page-title">{{__('frontend.transaction')}}{{ ' #'.$transaction->id }}</h2>
           </div>
           <div class="col-auto ms-auto d-none d-lg-flex">
              <div class="btn-list">
                 <a href="{{ route('payments.page') }}" class="btn">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="9" y2="16" /><line x1="5" y1="12" x2="9" y2="8" /></svg>
                    {{__('frontend.back_to_payments')}}
                 </a>
              </div>
           </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-swipgle-secondary text-white">{{__('frontend.transaction')}}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex"><strong>{{__('frontend.transaction_id')}} :</strong> <span class="m-0 ms-auto">{{ $transaction->id }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.purchased_space')}} :</strong> <span class="m-0 ms-auto @if($transaction->payment_status != 3)text-primary @else text-danger @endif"><strong>+{{ formatBytes($transaction->space) }}</strong></span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.space_cost')}} :</strong> <span class="m-0 ms-auto"><strong>{{ transaction_price($transaction->amount).' '.$transaction->currency }}</strong></span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.payment_method')}} :</strong> <span class="m-0 ms-auto">{{ $transaction->method }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.purchased_date')}} :</strong> <span class="m-0 ms-auto">@datetime($transaction->created_at)</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.status')}} :</strong> <span class="m-0 ms-auto">{!! transactionStatus($transaction->payment_status) !!}</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection