@extends('layouts.backend')
@section('title', 'Payments gateway')
@section('content')
<div class="swipgle-backend-pages">
    <div class="card mb-3">
        <div class="card-header"><h3 class="m-0">{{__('Paypal API ')}}</h3>
            <span class="col-auto ms-auto d-print-none">
                <a href="https://developer.paypal.com/" target="_blank">
                    <img src="{{ asset('images/payments/paypal.png') }}" width="110" alt="Paypal">
                </a>
            </span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('paypal.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Paypal status :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <select name="status" class="form-select" required>
                            <option value="1" @if($paypal->status == "1") selected @endif>{{__('Active')}}</option>
                            <option value="2" @if($paypal->status == "2") selected @endif>{{__('Deactivate')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Paypal test mode :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <select name="paypal_test_mode" class="form-select" required>
                            <option value="1" @if($paypal->paypal_test_mode == "1") selected @endif>{{__('Enabled')}}</option>
                            <option value="2" @if($paypal->paypal_test_mode == "2") selected @endif>{{__('Disabled')}}</option>
                        </select>
                        <small class="text-muted">{{__('Disable test mode when you want go to live mode')}}</small>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Paypal client ID :')}}</label>
                    <div class="col">
                      <input type="text" name="paypal_client_id" class="form-control" value="{{ $paypal->paypal_client_id }}">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Paypal client secret :')}} </label>
                    <div class="col">
                      <input type="text" name="paypal_client_secret" class="form-control"  value="{{ $paypal->paypal_client_secret }}">
                    </div>
                </div>
                <div class="text-right">
                   <button class="btn btn-primary" type="submit">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h3 class="m-0">{{__('Stripe API ')}}</h3>
            <span class="col-auto ms-auto d-print-none">
                <a href="https://dashboard.stripe.com/" target="_blank">
                    <img src="{{ asset('images/payments/stripe.png') }}" width="100" alt="Stripe">
                </a>
            </span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('stripe.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Stripe status :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <select name="status" class="form-select" required>
                            <option value="1" @if($stripe->status == "1") selected @endif>{{__('Active')}}</option>
                            <option value="2" @if($stripe->status == "2") selected @endif>{{__('Deactivate')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Stripe publishable key :')}}</label>
                    <div class="col">
                      <input type="text" name="stripe_publishable_key" class="form-control" value="{{ $stripe->stripe_publishable_key }}">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Stripe secret key :')}} </label>
                    <div class="col">
                      <input type="text" name="stripe_secret_key" class="form-control"  value="{{ $stripe->stripe_secret_key }}">
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