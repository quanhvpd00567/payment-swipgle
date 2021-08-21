@extends('layouts.frontend')
@section('title', __('auth.login'))
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      @if(session('error'))
      <div class="note note-danger">
         {{ session('error') }}
      </div>
      @endif
      <form class="card card-md" method="POST" action="{{ route('login') }}">
         @csrf
         <div class="card-body">
            <h2 class="card-title text-center mb-4">{{__('auth.login_title')}}</h2>
            <div class="mb-3">
               <label class="form-label">{{__('auth.email')}}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="{{__('auth.enter_email')}}">
               @error('email')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-2">
               <label class="form-label">
                  {{__('auth.password')}}
               <span class="form-label-description">
               @if (Route::has('password.request'))
               <a href="{{ route('password.request') }}">
                  {{__('auth.forgot_password')}}
               </a>
               @endif
               </span>
               </label>
               <div class="mb-3">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{__('auth.enter_password')}}">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="mb-3">
               <label class="form-check">
               <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
               <span class="form-check-label">{{__('auth.remember')}}</span>
               </label>
            </div>
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
               {!! app('captcha')->display() !!}
               @if ($errors->has('g-recaptcha-response'))
                  <span class="help-block">
                     <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                  </span>
               @endif
             </div>
            <button type="submit" class="btn btn-primary w-100 btn-pd">{{__('auth.signin_btn')}}</button>
         </div>
         <div class="hr-text">{{__('auth.or')}}</div>
         <div class="card-body">
             <a href="{{ url('/register') }}" class="btn w-100 btn-pd">{{__('auth.create_account')}}</a>
         </div>
      </form>
      <div class="text-center text-muted mt-3">
         {{__('auth.no_account')}} <a href="{{ url('/register') }}" tabindex="-1">{{__('auth.register_now')}}</a>
      </div>
   </div>
</div>
@endsection