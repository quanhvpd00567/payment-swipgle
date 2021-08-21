@extends('layouts.frontend')
@section('title', __('frontend.dashboard'))
@section('content')
<div class="swipgle-pages">
   <div class="page-header d-print-none">
      <div class="row align-items-center">
         <div class="col">
            <div class="page-pretitle">{{__('frontend.overview')}}</div>
            <h2 class="page-title">{{__('frontend.dashboard')}}</h2>
         </div>
         <div class="col-auto ms-auto">
            <div class="btn-list">
               <span class="d-none d-sm-inline">
                  <a href="{{ url('/') }}" class="btn btn-white">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="10" y1="14" x2="21" y2="3" />
                        <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                     </svg>
                     {{__('frontend.start_transfer_btn')}}
                  </a>
               </span>
               <a href="{{ route('payments.page') }}" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <rect x="3" y="4" width="18" height="8" rx="3" />
                     <rect x="3" y="12" width="18" height="8" rx="3" />
                     <line x1="7" y1="8" x2="7" y2="8.01" />
                     <line x1="7" y1="16" x2="7" y2="16.01" />
                  </svg>
                  {{__('frontend.buy_more_space')}}
               </a>
            </div>
         </div>
      </div>
   </div>
   @if(session('success'))
     <div class="note note-success">{{ session('success') }}</div>
   @endif
   <div class="row">
      <div class="col-lg-4">
         <div class="box">
            <h1 class="@if(auth()->user()->space > 0)text-primary @else text-danger @endif">{{ formatBytes(auth()->user()->space) }}</h1>
            <h4>{{__('frontend.remaining_space')}}</h4>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="box">
            <h1>{{ number_format_short($total_files)}}</h1>
            <h4>{{__('frontend.transferred_files')}}</h4>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="box">
            <h1>{{ number_format_short($transactionsCount) }}</h1>
            <h4>{{__('frontend.transactions')}}</h4>
         </div>
      </div>
   </div>
   <div class="transferred-table mt-4">
      <h2 class="mb-3">{{__('transferred_files_activity')}}</h2>
      @if($transfers->count() > 0)
      <div class="card">
         <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap">
               <thead>
                  <tr>
                     <th>{{__('frontend.transfer_id')}}</th>
                     <th class="text-center">{{__('frontend.total_files')}}</th>
                     <th class="text-center">{{__('frontend.spend_space')}}</th>
                     <th class="text-center">{{__('frontend.transfer_date')}}</th>
                     <th class="text-center">{{__('frontend.expiry_date')}}</th>
                     <th class="text-center">{{__('frontend.status')}}</th>
                     <th class="text-center">{{__('frontend.transfer_method')}}</th>
                     <th class="text-center">{{__('frontend.action')}}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($transfers as $transfer)
                  <tr>
                     <td>{{ '#'.strtoupper($transfer->transfer_id) }}</td>
                     <td class="text-center">{{ number_format_short($transfer->total_files) }}</td>
                     <td class="text-center text-danger">- {{ formatBytes($transfer->spend_space) }}</td>
                     <td class="text-center">@datetime($transfer->created_at)</td>
                     <td class="text-center {{ expiry($transfer->expiry_time) }}">@datetime($transfer->expiry_time)</td>
                     <td class="text-center">{!! transfer_status($transfer->tranfer_status, $transfer->create_method) !!}</td>
                     <td class="text-center">{{ create_method($transfer->create_method) }}</td>
                     <td class="text-center"><a href="{{ route('view.transfer', $transfer->transfer_id) }}" class="btn btn-sm">{{__('frontend.view_btn')}}</a></td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      {{$transfers->links()}}
      @else 
      <div class="empty">
         <div class="empty-img"><img src="{{ asset('images/sections/empty.svg') }}" height="128" alt="Empty">
         </div>
         <p class="empty-title">{{__('frontend.no_activity_found')}}</p>
         <p class="empty-subtitle text-muted">{{__('frontend.no_activity_description')}}</p>
      </div>
      @endif
   </div>
</div>
@endsection