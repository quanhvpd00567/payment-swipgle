@extends('layouts.backend')
@section('title', 'Transfer #'.$transfer->transfer_id)
@section('content')
<div class="swipgle-backend-pages">
    @if($transfer->tranfer_status != 2)
    <a href="{{ route('cancel.transfer', $transfer->transfer_id) }}" onclick="return confirm('All files will be removed in this transfer and space will be refunded to the user account. Do you want to continue?')" class="btn btn-danger mb-3">{{__('Cancel This transfer')}}</a>
    @endif
    <div class="row">
        @if($transfer->subject != null || $transfer->message != null)
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-blue text-white">{{__('Transfer message')}}</div>
                <div class="card-body">
                    @if($transfer->subject != null)
                    <strong><i>{{__('Subject : ')}}{{ $transfer->subject }}</i></strong><br>
                    @endif
                    @if($transfer->message != null)
                    <i>{{ $transfer->message }}</i>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-blue text-white">{{__('Transfer information')}}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex"><strong>{{__('Transfer ID :')}}</strong> <span class="m-0 ms-auto">{{ strtoupper($transfer->transfer_id) }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('User :')}}</strong> <span class="m-0 ms-auto"><a href="{{ route('edit.user', $transfer->user->id) }}">{{ $transfer->user->name }}</a></span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Email from :')}}</strong> <span class="m-0 ms-auto">{{ $transfer->email_from }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Expiry date :')}}</strong> <span class="m-0 ms-auto {{ expiry($transfer->expiry_time) }}">@datetime($transfer->expiry_time)</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Protected by password :')}}</strong> <span class="m-0 ms-auto">@if($transfer->password != null){{__('Yes')}}@else{{__('No')}}@endif</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Total files :')}}</strong> <span class="m-0 ms-auto">{{ $transfer->total_files }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Transfer method :')}}</strong> <span class="m-0 ms-auto">{{ create_method($transfer->create_method) }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Spend space :')}}</strong> <span class="m-0 ms-auto text-danger">- {{ formatBytes($transfer->spend_space) }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('Status :')}}</strong> <span class="m-0 ms-auto">{!! transfer_status($transfer->tranfer_status, $transfer->create_method) !!}</li>
                    <li class="list-group-item d-flex"><strong>{{__('Transfer date :')}}</strong> <span class="m-0 ms-auto">@datetime($transfer->created_at)</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-blue text-white">{{__('Transfered files')}}</div>
                <div class="card-body">
                    @if(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $transfer->expiry_time)->isPast() != true && $transfer->tranfer_status != 2)
                    @foreach($files as $file)
                    <li class="mb-2"><a href="{{ route('admin.download.file', [$transfer->id, $file]) }}"><span class="me-3"><i class="fas fa-download"></i></span>{{ $file }}</a></li>
                    @endforeach
                    @else 
                    @foreach($files as $file)
                    <li class="mb-2">{{ $file }}</li>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        @if($transfer->email_to != null)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-blue text-white">{{__('Transfer to emails')}}</div>
                <div class="card-body">
                    @foreach($emails as $email)
                    <li class="mb-2">{{ $email }}</li>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection