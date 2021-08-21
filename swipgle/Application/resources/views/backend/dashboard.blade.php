@extends('layouts.backend')
@section('title', 'Dashboard')
@section('content')
<div class="row swipgle-backdash">
   <div class="col-lg-3">
      <div class="box bg-success text-white mb-3">
         <h1>{{ price($earnings) }}</h1>
         <h4>{{__('Total earnings in '.$settings->website_currency)}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-primary text-white mb-3">
         <h1>{{ number_format_short($transfers) }}</h1>
         <h4>{{__('Total transfers')}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-danger text-white mb-3">
         <h1>{{ number_format_short($users) }}</h1>
         <h4>{{__('Total users')}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-secondary text-white mb-3">
         <h1>{{ number_format_short($transactions) }}</h1>
         <h4>{{__('Total transactions')}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-info text-white">
         <h1>{{ price($today_earnings) }}</h1>
         <h4>{{__('Today earnings in '.$settings->website_currency)}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-dark text-white">
         <h1>{{ number_format_short($today_transfers) }}</h1>
         <h4>{{__('Today transfers')}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-warning text-white">
         <h1>{{ number_format_short($today_users) }}</h1>
         <h4>{{__('Today users')}}</h4>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="box bg-purple text-white">
         <h1>{{ number_format_short($today_transactions) }}</h1>
         <h4>{{__('Today transactions')}}</h4>
      </div>
   </div>
   <div class="col-lg-6">
      <div class="card mt-3">
         <div class="card-header">
            <h3 class="m-0">{{__('Statistics of users')}}</h3>
         </div>
         <div class="card-body pt-4">
            @if($users > 0)
            <div id="chart-users"></div>
            @else 
             @include('backend.includes.empty')
            @endif
         </div>
      </div>
   </div>
   <div class="col-lg-6">
      <div class="card mt-3">
         <div class="card-header">
            <h3 class="m-0">{{__('Last Joined Users')}}</h3>
         </div>
         <div class="card-body">
            @if($lastUsers->count() > 0)
            <div class="divide-y-4">
               @foreach($lastUsers as $user)
               <div class="new-user">
                  <div class="row">
                     <div class="col-auto">
                        <span class="avatar" style="background-image: url({{ avatar($user->avatar) }})"></span>
                     </div>
                     <div class="col">
                        <div class="text-truncate">
                           <strong><a href="{{ route('edit.user', $user->id) }}" class="text-dark">{{ $user->name }}</a></strong> {{__('Just joined.')}}
                        </div>
                        <div class="text-muted">{{ Carbon\Carbon::parse($user->created_at)->diffForHumans()}} </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
            @else
              @include('backend.includes.empty')
            @endif
         </div>
      </div>
   </div>
   <div class="col-lg-12">
      <div class="card mt-3">
         <div class="card-header">
            <h3 class="m-0">{{__('Statistics of transfers')}}</h3>
         </div>
         <div class="card-body">
            @if($transfers > 0)
            <div id="chart-transfers-overview"></div>
            @else 
               @include('backend.includes.empty')
            @endif
         </div>
      </div>
   </div>
</div>
@endsection