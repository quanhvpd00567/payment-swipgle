@extends('layouts.download')
@section('title', __('frontend.download_title'))
@section('content')
<div class="container py-4">
   <div class="row">
      <div class="col-lg-4 m-auto">
         <div class="card-top text-center">
            <img src="{{ asset('images/sections/password.svg') }}" class="w-100 mb-3">
            <h1>{{__('frontend.enter_password')}}</h1>
         </div>
         <div class="password-box mt-3">
            <div class="box-password-body p-3">
                @if($errors->any())
                <div class="note note-danger">{{$errors->first()}}</div>
                @endif
               <form action="{{ route('store.password', $transfer->transfer_id) }}" method="POST">
                  @csrf
                  <input type="hidden" name="transfer_id" value="{{ $transfer->transfer_id }}">
                  <div class="form-group">
                     <input type="password" name="password" id="password" placeholder="{{__('frontend.enter_password')}}" class="form-control  @error('password') is-invalid @enderror" required>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <button type="submit" class="btn btn-primary btn-pd w-100">{{__('frontend.submit_btn')}}</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection