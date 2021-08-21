@extends('layouts.backend')
@section('title', 'Captcha')
@section('content')
<div class="swipgle-backend-pages">
    <div class="card">
        <div class="card-header"><h3 class="m-0">{{__('Google captcha V2 ')}}</h3>
            <span class="col-auto ms-auto d-print-none">
                <a href="https://www.google.com/recaptcha/admin/" target="_blank">
                    <img src="{{ asset('images/sections/captcha.png') }}" width="100" alt="google captcha">
                </a>
            </span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('captcha.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Google captcha sitekey :')}}</label>
                    <div class="col">
                      <input type="text" name="google_captcha_sitekey" class="form-control" value="{{ $api->google_captcha_sitekey }}" placeholder="Enter sitekey">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Google captcha secret :')}}</label>
                    <div class="col">
                      <input type="text" name="google_captcha_secret" class="form-control" value="{{ $api->google_captcha_secret }}" placeholder="Enter secret">
                    </div>
                </div>
                <div class="text-right">
                   <button class="btn btn-primary" type="submit">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection