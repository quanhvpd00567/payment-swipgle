@extends('layouts.frontend')
@section('title', __('frontend.settings'))
@section('content')
<div class="swipgle-pages">
    <div class="page-header d-print-none">
       <div class="row align-items-center">
          <div class="col">
            <div class="page-pretitle">{{__('frontend.account')}}</div>
            <h2 class="page-title">{{__('frontend.settings')}}</h2>
          </div>
          <div class="col-auto ms-auto">
             <div class="btn-list">
                <a href="{{ route('user.dashboard') }}" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="9" y2="16" /><line x1="5" y1="12" x2="9" y2="8" /></svg>
                   {{__('frontend.back_to_dashboard')}}
                </a>
             </div>
          </div>
       </div>
    </div>
    <div class="row">
      <div class="col-lg-5">
         <div class="sec__title">
            <h1>{{__('frontend.profile_information')}}</h1>
            <p>{{__('frontend.profile_information_description')}}</p>
         </div>
      </div>
      <div class="col-lg-7">
         <div class="note note-danger print-error-msg" style="display:none"><span></span></div>
         <div class="card">
            <form id="informationForm" method="POST" enctype="multipart/form-data">
               <div class="card-body">
                  <div class="rounded-circle avatar avatar-xl mb-3">
                     <img class="rounded-circle" id="preview_avatar" src="{{ avatar(auth()->user()->avatar) }}" width="100" height="100">
                  </div>
                  <div class="form-group mb-2">
                     <input id="avatar" type="file" name="avatar" hidden accept="image/png, image/jpeg, image/jpg"/>
                     <button id="uploadBtn" type="button" class="btn mb-2">{{__('frontend.upload_avatar_btn')}}</button>
                   </div>
                  <div class="form-group">
                     <label for="name">{{__('frontend.name')}}</label>
                     <input class="form-control" id="name" name="name" type="text" placeholder="{{__('frontend.enter_name') }}" value="{{ auth()->user()->name }}" required>
                  </div>
                  <div class="form-group">
                     <label for="name">{{__('frontend.email')}}</label>
                     <input class="form-control" id="email" name="email" type="text" placeholder="{{__('frontend.enter_email') }}" value="{{ auth()->user()->email }}" required>
                  </div>
               </div>
               <div class="card-footer text-right">
                  <button type="submit" id="saveInfoBtn" class="btninfo btn btn-primary">
                  <span class="spinner-border-info spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                  {{__('frontend.save_btn')}}
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="row py-5">
      <div class="col-lg-5">
         <div class="sec__title">
            <h1>{{__('frontend.security_information')}}</h1>
            <p>{{__('frontend.security_information_description')}}</p>
         </div>
      </div>
      <div class="col-lg-7">
         <div class="note note-danger print-error-msg-sec" style="display:none"><span></span></div>
         <div class="card">
            <form id="passwordForm" method="POST" class="mt-2">
               <div class="card-body">
                  <div class="form-group">
                     <label for="new-password" class="control-label">{{__('frontend.current_password')}}</label>
                     <input id="currentpassword" type="password" class="form-control" name="current-password">
                  </div>
                  <div class="form-group">
                     <label for="new-password" class="control-label">{{__('frontend.new_password')}}</label>
                     <input id="newpassword" type="password" class="form-control" name="new-password" required>
                  </div>
                  <div class="form-group">
                     <label for="new-password-confirm" class="control-label">{{__('frontend.confirm_new_password')}}</label>
                     <input id="newpasswordconfirm" type="password" class="form-control" name="new-password_confirmation" required>
                  </div>
               </div>
               <div class="card-footer text-right">
                  <button id="savePassBtn" type="submit" class="btnpass btn btn-primary">
                  <span class="spinner-border-pass spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>{{__('frontend.save_btn')}}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="row py-5">
      <div class="col-lg-5">
         <div class="sec__title">
            <h1>{{__('frontend.account_cache')}}</h1>
            <p>{{__('frontend.account_cache_description')}}</p>
         </div>
      </div>
      <div class="col-lg-7">
         <div class="card">
            <div class="card-body">
               <p>{{__('frontend.cache_guide')}}</p>
               <form class="mb-1" id="cacheForm" action="{{ route('delete.cache') }}" method="POST" class="mt-2">
                  @csrf
                  <button id="deleteCacheBtn" type="submit" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>{{__('frontend.delete_cache')}}{{ ' ('.formatBytes($cache).')' }}</button>
               </form>
               <div class="text-right">
                  <i class="text-muted"><small>{{__('frontend.cache_minutes')}}</small></i>
               </div>
            </div>
         </div>
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