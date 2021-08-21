@extends('layouts.frontend')
@section('title', __('auth.reset'))
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      @if (session('status'))
      <div class="note note-success" role="alert">
         {{ session('status') }}
      </div>
      @endif
      <form class="card card-md" method="POST" action="{{ route('password.email') }}">
         @csrf
         <div class="card-body">
            <h2 class="card-title text-center mb-4">{{__('auth.forgot_password')}}</h2>
            <p class="text-muted mb-4">{{__('auth.forgot_message')}}</p>
            <div class="mb-3">
               <label class="form-label">{{__('auth.email')}}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
               @error('email')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
               {!! app('captcha')->display() !!}
               @if ($errors->has('g-recaptcha-response'))
                  <span class="help-block">
                     <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                  </span>
               @endif
             </div>
            <div class="form-footer mt-3">
               <button type="submit" class="btn btn-primary w-100 btn-pd">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <rect x="3" y="5" width="18" height="14" rx="2" />
                     <polyline points="3 7 12 13 21 7" />
                  </svg>
                  {{__('auth.forgot_btn')}}
               </button>
            </div>
         </div>
         <div class="hr-text">{{__('auth.or')}}</div>
       <div class="card-body">
        <a href="{{ url('/login') }}" class="btn w-100 btn-pd">{{__('auth.backto_login')}}</a>
       </div>
      </form>
   </div>
</div>
@endsection