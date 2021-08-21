@extends('layouts.frontend')
@section('title', __('auth.register'))
@section('content')
<div class="flex-fill d-flex flex-column justify-content-center py-5">
   <div class="container-tight py-6">
      <form class="card card-md" method="POST" action="{{ route('register') }}">
         @csrf
         <div class="card-body">
            <h2 class="card-title text-center mb-4">{{__('auth.create_account')}}</h2>
            <div class="mb-3">
               <label class="form-label">{{__('auth.name')}}</label>
               <input id="name" type="fullname" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('auth.enter_name')}}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
               @error('name')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-3">
               <label class="form-label">{{__('auth.email')}}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('auth.enter_email')}}" name="email" value="{{ old('email') }}" required autocomplete="email">
               @error('email')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-3">
               <label class="form-label">{{__('auth.password')}}</label>
               <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('auth.enter_password')}}" name="password" required autocomplete="new-password">
               @error('password')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="mb-3">
               <label class="form-label">{{__('auth.confirm_password')}}</label>
               <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{__('auth.confirm_password')}}" required autocomplete="new-password">
            </div>
            <div class="mb-3">
               <label class="form-check">
               <input type="checkbox" name="agree" class="form-check-input @error('agree') is-invalid @enderror" required {{ old('agree') ? 'checked' : '' }}/>
               <span class="form-check-label">{{__('auth.agree')}}</span>
               </label>
               @error('agree')
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
            <button type="submit" class="btn btn-primary w-100 btn-pd">{{__('auth.create_account')}}</button>
         </div>
         <div class="hr-text">{{__('auth.or')}}</div>
    <div class="card-body">
        <a href="{{ url('/login') }}" class="btn w-100 btn-pd">{{__('auth.login')}}</a>
    </div>
      </form>
      <div class="text-center text-muted mt-3">
         {{__('auth.have_account')}} <a href="{{ url('/login') }}" tabindex="-1">{{__('auth.login')}}</a>
      </div>
   </div>
</div>
@endsection