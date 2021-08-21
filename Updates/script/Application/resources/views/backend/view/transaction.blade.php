@extends('layouts.backend')
@section('title', 'Transction #'.$transaction->id)
@section('content')
<div class="swipgle-backend-pages">
    <div class="card">
        <div class="card-header bg-swipgle-secondary text-white">{{__('Transaction information')}}</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex"><strong>{{__('Transaction ID :')}}</strong> <span class="m-0 ms-auto">{{ $transaction->id }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('User :')}}</strong> <span class="m-0 ms-auto"><a href="{{ route('edit.user', $transaction->user->id) }}">{{ $transaction->user->name }}</a></span></li>
            <li class="list-group-item d-flex"><strong>{{__('Payment ID :')}}</strong> <span class="m-0 ms-auto">{{ $transaction->payment_id ?? "--" }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Payer ID :')}}</strong> <span class="m-0 ms-auto">{{ $transaction->payer_id ?? "--" }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Payer email :')}}</strong> <span class="m-0 ms-auto">{{ $transaction->payer_email ?? "--" }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Space :')}}</strong> <span class="m-0 ms-auto @if($transaction->payment_status != 3)text-primary @else text-danger @endif"><strong>+{{ formatBytes($transaction->space) }}</strong></span></li>
            <li class="list-group-item d-flex"><strong>{{__('Space cost :')}}</strong> <span class="m-0 ms-auto"><strong>{{ transaction_price($transaction->amount).' '.$transaction->currency }}</strong></span></li>
            <li class="list-group-item d-flex"><strong>{{__('Payment method :')}}</strong> <span class="m-0 ms-auto">{{ $transaction->method }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Purchased date :')}}</strong> <span class="m-0 ms-auto">@datetime($transaction->created_at)</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Status :')}}</strong> <span class="m-0 ms-auto">{!! transactionStatus($transaction->payment_status) !!}</span></li>
        </ul>
    </div>
</div>
@endsection