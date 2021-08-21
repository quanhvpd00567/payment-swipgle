@extends('layouts.backend')
@section('title', 'Information settings')
@section('content')
<div class="swipgle-backend-pages">
    <div class="card">
        <div class="card-header"><h3 class="m-0">{{__('Edit website information')}}</h3></div>
        <div class="card-body p-4">
            <form action="{{ route('information.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Website name :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="website_name" class="form-control" value="{{ $settings->website_name }}" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Google analytics (optional) :')}} </label>
                    <div class="col">
                      <input type="text" name="google_analytics" class="form-control" placeholder="Enter google analytics code" value="{{ $settings->google_analytics }}">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Website storage :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <select name="website_storage" class="form-select" required>
                          <option value="1" @if($settings->website_storage == 1) selected @endif>{{__('Local server')}}</option>
                          <option value="2" @if($settings->website_storage == 2) selected @endif>{{__('Amazon S3')}}</option>
                      </select>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Website currency :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <select name="website_currency" class="form-select" required>
                            <option value="USD" @if($settings->website_currency == "USD") selected @endif>{{__('USD')}}</option>
                            <option value="EUR" @if($settings->website_currency == "EUR") selected @endif>{{__('EUR')}}</option>
                            <option value="CAD" @if($settings->website_currency == "CAD") selected @endif>{{__('CAD')}}</option>
                            <option value="GBP" @if($settings->website_currency == "GBP") selected @endif>{{__('GBP')}}</option>
                            <option value="CZK" @if($settings->website_currency == "CZK") selected @endif>{{__('CZK')}}</option>
                            <option value="AUD" @if($settings->website_currency == "AUD") selected @endif>{{__('AUD')}}</option>
                        </select>
                        <small class="text-muted">{{__('The currency does not convert automatically, the price will remain the same in the currency in which it was changed.')}}</small>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                  <label class="form-label col-12 col-lg-3 col-form-label">{{__('Email verification :')}} <span class="point-red">*</span></label>
                  <div class="col">
                    <select name="email_verification" class="form-select" required>
                        <option value="1" @if($settings->email_verification == 1) selected @endif>{{__('Enable')}}</option>
                        <option value="2" @if($settings->email_verification == 2) selected @endif>{{__('Disable')}}</option>
                    </select>
                  </div>
              </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Max files in one time :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="number" name="max_files" class="form-control" value="{{ $settings->max_files }}" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                  <label class="form-label col-12 col-lg-3 col-form-label">{{__('Max file size :')}} <span class="point-red">*</span></label>
                  <div class="col">
                    <div class="input-group">
                      <input type="number" name="max_upload_size" class="form-control" value="{{ $settings->max_upload_size }}">
                      <span class="input-group-text">{{__('MB')}}</span>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('New users space :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <div class="input-group">
                        <input type="number" name="free_storage" class="form-control" value="{{ $settings->free_storage }}">
                        <span class="input-group-text">{{__('Bytes')}}</span>
                      </div>
                      <small class="text-muted">{{__('1 Megabytes = 1048576 Bytes')}}</small>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Home page heading :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="home_heading" class="form-control" value="{{ $settings->home_heading }}" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Home page descritption :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <textarea name="home_description" class="form-control" rows="4" required>{{ $settings->home_description }}</textarea>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Home top bar message (optional) :')}} </label>
                    <div class="col">
                      <textarea name="home_message" class="form-control" rows="4" placeholder="Enter message">{{ $settings->home_message }}</textarea>
                      <small class="text-muted">{{__('Leave empty if you dont want show it')}}</small>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Website primary color :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <input type="color" name="website_main_color" class="form-control form-control-color" value="{{ $settings->website_main_color }}" title="Choose your color">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Website secondary color :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <input type="color" name="website_sec_color" class="form-control form-control-color" value="{{ $settings->website_sec_color }}" title="Choose your color">
                    </div>
                </div>
                <div class="text-right">
                   <button class="btn btn-primary" type="submit">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header"><h3 class="m-0">{{__('Logo & Favicon')}}</h3></div>
        <div class="card-body">
            <form action="{{ route('identity.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Logo :')}}</label>
                    <div class="col">
                      <div class="bg-swipgle-primary p-2 mb-2 text-center">
                        <img id="preview_logo" src="{{ logofav($settings->logo) }}" alt="{{ $settings->website_name }}" width="120" height="80">
                      </div>
                      <input type="file" id="logo" name="logo" class="form-control form-small">
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Favicon :')}}</label>
                    <div class="col">
                      <div class="bg-swipgle-primary p-2 mb-2 text-center">
                        <img id="preview_favicon" src="{{ logofav($settings->favicon) }}" alt="{{ $settings->website_name }}" width="60" height="60">
                      </div>
                      <input type="file" id="favicon" name="favicon" class="form-control form-small">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection