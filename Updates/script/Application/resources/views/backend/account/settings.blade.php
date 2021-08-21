@extends('layouts.backend')
@section('title', 'Account settings')
@section('content')
<div class="swipgle-backend-pages">
   <div class="card">
      <div class="card-header">
         <h2 class="m-0">{{__('Account information')}} </h2>
      </div>
      <div class="card-body">
         <form action="{{ route('admin.update.info') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="rounded-circle avatar avatar-xl mb-3">
               <img class="rounded-circle" id="preview_avatar" src="{{ avatar(Auth::user()->avatar) }}" width="100" height="100">
            </div>
            <div class="form-group mb-2">
                <input id="avatar" type="file" name="avatar" hidden accept="image/png, image/jpeg, image/jpg"/>
                <button id="uploadBtn" type="button" class="btn mb-2">{{__('Upload Avatar')}}</button>
              </div>
            <div class="form-group">
               <label for="name">{{__('Name :')}} <span class="point-red">*</span></label>
               <input class="form-control"  name="name" type="text" placeholder="Enter your name" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="form-group">
               <label for="name">{{__('Email :')}} <span class="point-red">*</span></label>
               <input class="form-control" name="email" type="text" placeholder="Enter your email" value="{{ Auth::user()->email }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
         </form>
      </div>
   </div>
   <div class="card mt-4">
      <div class="card-header">
         <h2 class="m-0">{{__('Account password')}} </h2>
      </div>
      <div class="card-body">
         <form action="{{ route('admin.update.password') }}" method="POST" class="mt-2">
            @csrf
            <div class="form-group">
               <label for="new-password" class="control-label">{{__('Current Password :')}} <span class="point-red">*</span></label>
               <input type="password" class="form-control" name="current-password">
            </div>
            <div class="form-group">
               <label for="new-password" class="control-label">{{__('New Password :')}} <span class="point-red">*</span></label>
               <input type="password" class="form-control" name="new-password" required>
            </div>
            <div class="form-group">
               <label for="new-password-confirm" class="control-label">{{__('Confirm New Password :')}} <span class="point-red">*</span></label>
               <input type="password" class="form-control" name="new-password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
         </form>
      </div>
   </div>
</div>
<script>
    // Upload btn click
    document.getElementById('uploadBtn').addEventListener('click', openDialog);
     // Upload avatar
    function openDialog() {
         document.getElementById('avatar').click();
    }
 </script>
@endsection