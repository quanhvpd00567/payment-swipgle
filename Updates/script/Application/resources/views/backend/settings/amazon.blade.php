@extends('layouts.backend')
@section('title', 'Amazon S3')
@section('content')
<div class="swipgle-backend-pages">
    <div class="card">
        <div class="card-header">
          <small class="text-muted">{{__('You can get your details from')}} 
          <a href="https://s3.console.aws.amazon.com" target="_blank">{{__('Amazon aws console')}}</a></small>
          <span class="col-auto ms-auto d-print-none">
          <img src="{{ asset('images/sections/awss3.png') }}" width="130">
          </span>
        </div>
          <div class="card-body">
              <form action="{{ route('amazon.store') }}" method="POST">
                  @csrf
                <div class="form-group">
                  <label for="aws_access_key_id">{{__('Aws access key ID :')}}</label>
                  <input type="text" name="aws_access_key_id" class="form-control" value="{{ $amazon->aws_access_key_id }}">
                </div>
                <div class="form-group">
                  <label for="aws_secret_access_key">{{__('Aws secret access key :')}}</label>
                  <input type="text" name="aws_secret_access_key" class="form-control" value="{{ $amazon->aws_secret_access_key }}">
                </div>
                <div class="form-group">
                  <label for="aws_default_region">{{__('Aws default region :')}}</label>
                  <input type="text" name="aws_default_region" class="form-control" placeholder="us-east-1"value="{{ $amazon->aws_default_region }}">
                </div>
                <div class="form-group">
                  <label for="aws_bucket">{{__('Aws bucket :')}}</label>
                  <input type="text" name="aws_bucket" class="form-control" value="{{ $amazon->aws_bucket }}">
                </div>
                <div class="form-group">
                  <label for="aws_url">{{__('Aws URL : ')}}</label>
                  <input type="text" name="aws_url" class="form-control" value="{{ $amazon->aws_url}}">
                </div>
                <div class="form-group">
                    <li class="text-warning">{{__('Make sure you entered all information')}}</li>
                </div>
                <button class="btn btn-primary">{{__('Save changes')}}</button>
              </form>
          </div>
      </div>
</div>
@endsection