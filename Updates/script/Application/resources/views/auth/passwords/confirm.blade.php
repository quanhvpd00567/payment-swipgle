@extends('layouts.frontend')
@section('title', __('auth.confirm_password'))
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      <form class="card card-md" method="POST" action="{{ route('password.confirm') }}">
         @csrf
         <div class="card-body">
            <h2 class="card-title text-center mb-2">{{__('auth.confirm_password')}}</h2>
            <p class="text-center mb-4">{{__('auth.confirm_message')}}</p>
            <div class="mb-2">
               <label class="form-label">
               {{__('auth.password')}}
               <span class="form-label-description">
               @if (Route::has('password.request'))
               <a href="{{ route('password.request') }}">
               {{ __('auth.forgot_password') }}
               </a>
               @endif
               </span>
               </label>
               <div class="mb-3">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('auth.enter_password')}}" name="password" required autocomplete="current-password">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="form-footer">
               <button type="submit" class="btn btn-primary w-100 btn-pd">{{__('auth.confirm_password')}}</button>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection