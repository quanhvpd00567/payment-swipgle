@extends('layouts.frontend')
@section('title', __('frontend.view_transfer').' #'.$transfer->transfer_id)
@section('content')
<div class="swipgle-pages">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
           <div class="col">
             <div class="page-pretitle">{{__('frontend.account')}}</div>
             <h2 class="page-title">{{__('frontend.view_transfer') }}{{ ' #'.strtoupper($transfer->transfer_id) }}</h2>
           </div>
           <div class="col-auto ms-auto d-none d-lg-flex">
              <div class="btn-list">
                 <a href="{{ route('user.dashboard') }}" class="btn">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="9" y2="16" /><line x1="5" y1="12" x2="9" y2="8" /></svg>
                    {{__('frontend.back_to_dashboard')}}
                 </a>
              </div>
           </div>
        </div>
    </div>
    @if($transfer->tranfer_status == 2)
    <div class="note note-warning">
        {{__('frontend.transfer_canceled')}}
    </div>
    @endif
    <div class="row">
        @if($transfer->subject != null || $transfer->message != null)
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-swipgle-primary text-white">{{__('frontend.transfer_message')}}</div>
                <div class="card-body">
                    @if($transfer->subject != null)
                    <strong><i>{{__('frontend.transfer_subject')}}{{ ' : '.$transfer->subject }}</i></strong><br>
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
                <div class="card-header bg-swipgle-primary text-white">{{__('frontend.transfer_information')}}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex"><strong>{{__('frontend.transfer_id')}} :</strong> <span class="m-0 ms-auto">{{ strtoupper($transfer->transfer_id) }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.email_from')}} :</strong> <span class="m-0 ms-auto">{{ $transfer->email_from }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.expiry_date')}} :</strong> <span class="m-0 ms-auto {{ expiry($transfer->expiry_time) }}">@datetime($transfer->expiry_time)</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.protected_by_password')}} :</strong> <span class="m-0 ms-auto">@if($transfer->password != null){{__('frontend.yes')}}@else{{__('frontend.no')}}@endif</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.total_files')}} :</strong> <span class="m-0 ms-auto">{{ $transfer->total_files }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.transfer_method')}} :</strong> <span class="m-0 ms-auto">{{ create_method($transfer->create_method) }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.spend_space')}} :</strong> <span class="m-0 ms-auto text-danger">- {{ formatBytes($transfer->spend_space) }}</span></li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.status')}} :</strong> <span class="m-0 ms-auto">{!! transfer_status($transfer->tranfer_status, $transfer->create_method) !!}</li>
                    <li class="list-group-item d-flex"><strong>{{__('frontend.transfer_date')}} :</strong> <span class="m-0 ms-auto">@datetime($transfer->created_at)</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header bg-swipgle-primary text-white">{{__('frontend.transfered_files')}}</div>
                <div class="card-body">
                    @foreach($files as $file)
                    <li class="mb-2">{{ $file }}</li>
                    @endforeach
                </div>
            </div>
        </div>
        @if($transfer->email_to != null)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-swipgle-primary text-white">{{__('frontend.transfer_to_emails')}}</div>
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