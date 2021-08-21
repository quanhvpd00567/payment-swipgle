@extends('layouts.backend')
@section('title', 'SMTP')
@section('content')
<div class="swipgle-backend-pages">
    <div class="card">
        <div class="card-header"><h3 class="m-0">{{__('SMTP Information ')}}</h3></div>
        <div class="card-body p-4">
            <form action="{{ route('smtp.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Mail mailer :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <select name="mail_mailer" class="form-select" required>
                            <option value="smtp" @if($smtp->mail_mailer == "smtp") selected @endif>{{__('SMTP')}}</option>
                            <option value="sendmail" @if($smtp->mail_mailer == "sendmail") selected @endif>{{__('SENDMAIL')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Mail Host :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="mail_host" class="form-control" value="{{ $smtp->mail_host }}" placeholder="Enter mail host" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Mail Port :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="mail_port" class="form-control" value="{{ $smtp->mail_port }}" placeholder="Enter mail port" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Mail username :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="mail_username" class="form-control" value="{{ $smtp->mail_username }}" placeholder="Enter username" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Mail password :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="password" name="mail_password" class="form-control" value="{{ $smtp->mail_password }}" placeholder="Enter password" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Mail encryption :')}} <span class="point-red">*</span></label>
                    <div class="col">
                        <select name="mail_encryption" class="form-select" required>
                            <option value="tls" @if($smtp->mail_encryption == "tls") selected @endif>{{__('TLS')}}</option>
                            <option value="ssl" @if($smtp->mail_encryption == "ssl") selected @endif>{{__('SSL')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('From email :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="mail_form_email" class="form-control" value="{{ $smtp->mail_form_email }}" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('From name :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="mail_from_name" class="remove-spaces form-control" value="{{ $smtp->mail_from_name }}" required>
                      <small class="text-muted">{{__('Enter name without any spaces')}}</small>
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