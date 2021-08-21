@extends('layouts.frontend')
@section('title', __('auth.verify'))
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 m-auto">
            @if (session('resent'))
            <div class="note note-success" role="alert">
               {{ __('auth.message_sent') }}
            </div>
            @endif
            <div class="card">
               <div class="card-body text-center">
                  <h1 class="card-title">{{__('auth.verify')}}</h1>
                  <img class="my-4" src="{{ asset('images/sections/email.svg') }}" width="150" height="150"><br>
                  {{__('auth.befor_message')}}
                  <form method="POST" action="{{ route('verification.resend') }}">
                     @csrf
                     <button type="submit" class="btn btn-primary w-100 mt-3 btn-pd">{{ __('auth.verify_btn') }}</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection