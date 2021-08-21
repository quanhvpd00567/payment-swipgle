@extends('layouts.frontend')
@section('title', $seo->seo_title)
@section('content')
<div class="swipgle-home-transfer" id="swipgle-uploader-block">
   <div class="swipgle-start-transfer-section py-5">
      <div class="row justify-content-center">
         <div class="col-10">
            <div class="swipgle-home-text text-center">
               <div class="start-uploading swipgle-choose" id="swipgle-upload-clickable">
                  <svg xmlns="http://www.w3.org/2000/svg" class="faa-float animated icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <line x1="10" y1="14" x2="21" y2="3" />
                     <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                  </svg>
               </div>
               <h2 class="swipgle-big-title">{{ $settings->home_heading }}</h2>
               <p class="swipgle-description">{{ $settings->home_description }}</p>
               <button class="start-uploading swipgle-strat-uploading btn btn-swipgle-secondary">{{__('frontend.home_btn')}}</button>
            </div>
         </div>
      </div>
   </div>
   <div class="animate__animated animate__backInLeft swipgle-transfer-section py-4">
      @guest
      <div class="note note-warning mb-4">
         {{__('frontend.login_notice')}}
         <div class="note-btn">
            <a href="{{ url('/login') }}" class="btn">{{__('frontend.login_btn')}}</a>
            <a href="{{ url('/register') }}" class="btn btn-primary">{{__('frontend.join_btn')}}</a>
         </div>
      </div>
      @else 
      @if(auth()->user()->space == 0)
      <div class="note note-primary mb-4">
         {{__('frontend.no_space_notice')}}
         <div class="note-btn">
            <a href="{{ route('payments.page') }}" class="btn">{{__('frontend.buy_space_btn')}}</a>
         </div>
      </div>
      @endif
      @if($cache > 0)
      <div class="note note-danger mb-4">
         {{__('frontend.cache_files_notice')}}
         <div class="note-btn">
            <a href="{{ route('user.settings') }}" class="btn btn-danger">{{__('frontend.go_to_settings')}}</a>
         </div>
      </div>
      @endif
      @endguest
      <div class="row">
         <div class="col-lg-6">
            <div class="card-tabs swipgle-tabs">
               <ul class="nav nav-tabs">
                  <li class="nav-item">
                     <a href="#send" class="nav-link active" data-bs-toggle="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                           <rect x="3" y="5" width="18" height="14" rx="2" />
                           <polyline points="3 7 12 13 21 7" />
                        </svg>
                        {{__('frontend.send_file_tab')}}
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="#link" class="nav-link" data-bs-toggle="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                           <path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5" />
                           <path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5" />
                        </svg>
                        {{__('frontend.generate_link_tab')}}
                     </a>
                  </li>
               </ul>
               <div class="tab-content">
                  <div class="swipgle-tabs-top">
                     <div class="row align-items-center">
                        <div class="swipgle-choose col-auto" id="swipgle-upload-clickable">
                           <span class="bg-swipgle-secondary text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                 <line x1="12" y1="5" x2="12" y2="19" />
                                 <line x1="5" y1="12" x2="19" y2="12" />
                              </svg>
                           </span>
                        </div>
                        <div class="swipgle-choose col remaining_space" id="swipgle-upload-clickable">
                           <div class="font-weight-medium">{{__('frontend.add_files')}}</div>
                           <div class="text-muted">@auth{{ formatBytes(auth()->user()->space).' ' }}{{__('frontend.remaining')}}@endauth </div>
                        </div>
                        <div class="swipgle-choose col-auto">
                           <a href="{{ route('payments.page') }}">
                              <span class="bg-swipgle-secondary text-white avatar">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="3" y="4" width="18" height="8" rx="3" />
                                    <rect x="3" y="12" width="18" height="8" rx="3" />
                                    <line x1="7" y1="8" x2="7" y2="8.01" />
                                    <line x1="7" y1="16" x2="7" y2="16.01" />
                                 </svg>
                              </span>
                           </a>
                        </div>
                        <div class="swipgle-choose col">
                           <a href="{{ route('payments.page') }}">
                              <div class="font-weight-medium">{{__('frontend.buy_space')}}</div>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div id="send" class="card-information card tab-pane show active">
                     <div class="card-body swipgle-form-send">
                        <div class="swipgle-transfer-box">
                           <div class="note note-danger print-error-msg-send" style="display:none"><span></span></div>
                           <form class="swipgle-form-files" action="{{ route('transfer.files') }}" id="sendFilesMethod" method="POST">
                              @csrf
                              <div class="form-group input-group send_emails">
                                 <input type="text" id="email_to" name="email_to[]" class="form-control" placeholder="{{__('frontend.email_to')}}">
                                 <button class="btn btn-swipgle-primary" type="button" id="addNewEmail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                       <line x1="12" y1="5" x2="12" y2="19" />
                                       <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                 </button>
                              </div>
                              <div id="dynamic_field" class="form-group"></div>
                              <div class="form-group">
                                 <input class="form-control" id="from_email" type="email" name="from_email" placeholder="{{__('frontend.email_from')}}" required value="{{ auth()->user()->email ?? "" }}">
                              </div>
                              <div class="form-group">
                                 <input class="form-control" id="subject" type="subject" name="subject" placeholder="{{__('frontend.subject') }}">
                              </div>
                              <div class="form-group">
                                 <textarea name="message" id="message" rows="3" class="form-control" placeholder="{{__('frontend.message') }}"></textarea>
                              </div>
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" name="addingPassword" value="1" id="addingPassword">
                                       <span class="form-check-label">{{__('frontend.protect_password')}}</label>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" name="addingDate" value="1" id="addingDate">
                                       <span class="form-check-label">{{__('frontend.expiry_time')}}</label>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group password_input d-none">
                                 <input class="form-control" id="password" type="password" name="password" placeholder="{{__('frontend.password') }}">
                                 <small class="text-muted">{{__('frontend.leave_empty')}}</small>
                              </div>
                              <div class="form-group date_input d-none">
                                 <small class="text-warning">{{__('frontend.expiry_default')}}</small>
                                 <select class="form-control form-select mt-2" id="expiry_time" name="expiry_time">
                                    <option value="" selected disabled>{{__('frontend.choose_expiry_time')}}</option>
                                    <option value="1">{{__('frontend.one_hour')}}</option>
                                    <option value="2">{{__('frontend.one_day')}}</option>
                                    <option value="3">{{__('frontend.one_week')}}</option>
                                    <option value="4">{{__('frontend.one_month')}}</option>
                                 </select>
                              </div>
                              <button class="sendFilesBtn btn btn-swipgle-secondary w-100" id="sendFilesBtn">{{__('frontend.send_btn')}}</button>
                           </form>
                        </div>
                        <div class="swipgle-transfer-success d-none text-center">
                           <div class="fade-in">
                              <img src="{{ asset('images/sections/success.svg') }}" width="100" height="100" alt="success"> 
                              <h2>{{__('frontend.transfer_success')}}</h2>
                              <h3 class="transfered_success_mesage"></h3>
                              <button id="transfer_more_files" class="btn btn-primary w-100">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="10" y1="14" x2="21" y2="3" />
                                    <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                                 </svg>
                                 {{__('frontend.transfer_more_btn')}}
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="link" class="card-information card tab-pane">
                     <div class="card-body swipgle-form-send">
                        <div class="swipgle-form-box">
                           <div class="note note-danger print-error-msg" style="display:none"><span></span></div>
                           <form class="swipgle-form-files" action="{{ route('generate.link') }}" id="filesLinkMethod" method="POST">
                              @csrf
                              <div class="form-group">
                                 <input class="form-control" id="link_from_email" type="email" name="link_from_email" placeholder="{{__('frontend.email_from') }}" value="{{ auth()->user()->email ?? "" }}">
                              </div>
                              <div class="form-group">
                                 <input class="form-control" id="link_subject" type="link_subject" name="link_subject" placeholder="{{__('frontend.subject') }}">
                              </div>
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" name="linkaddingPassword" value="1" id="linkaddingPassword">
                                       <span class="form-check-label">{{__('frontend.protect_password')}}</label>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" name="linkaddingDate" value="1" id="linkaddingDate">
                                       <span class="form-check-label">{{__('frontend.expiry_time')}}</label>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group link_password_input d-none">
                                 <input class="form-control" id="link_password" type="password" name="link_password" placeholder="{{__('frontend.password') }}">
                                 <small class="text-muted">{{__('frontend.leave_empty')}}</small>
                              </div>
                              <div class="form-group link_date_input d-none">
                                 <samll class="text-warning">{{__('frontend.expiry_default')}}</samll>
                                 <select class="form-control form-select mt-2" id="link_expiry_time" name="link_expiry_time">
                                    <option value="" selected disabled>{{__('frontend.choose_expiry_time')}}</option>
                                    <option value="1">{{__('frontend.one_hour')}}</option>
                                    <option value="2">{{__('frontend.one_day')}}</option>
                                    <option value="3">{{__('frontend.one_week')}}</option>
                                    <option value="4">{{__('frontend.one_month')}}</option>
                                 </select>
                              </div>
                              <button class="linkMethodBtn btn btn-swipgle-secondary w-100" id="linkMethodBtn">{{__('frontend.generate_btn')}}</button>
                           </form>
                        </div>
                        <div class="swipgle-success-generate d-none text-center">
                           <div class="fade-in">
                              <img src="{{ asset('images/sections/success.svg') }}" width="100" height="100" alt="success"> 
                              <h2>{{__('frontend.link_generated')}}</h2>
                              <h4 class="generated_success_mesage"></h4>
                              <div class="input-group"> 
                                 <input type="text" class="form-control" name="generated_link" id="generated_link" value="" readonly> 
                                 <button id="copy" class="btn btn-swipgle-primary">{{__('frontend.copy_btn')}}</button> 
                              </div>
                              <button id="generate_new_link" class="btn btn-primary btn-sm w-100 mt-3">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                 </svg>
                                 {{__('frontend.generate_new_btn')}}
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="card card-upload" id="swipgle_upload_box">
               <div class="card-header">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                     <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                     <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                     <line x1="12" y1="11" x2="12" y2="17" />
                     <polyline points="9 14 12 11 15 14" />
                  </svg>
                  {{__('frontend.upload_files')}}
               </div>
               <div class="card-body p-0">
                  <div class="swipgle-top-progress">
                     <div class="row align-items-center">
                        <div class="col">
                           <div class="progress progress-sm">
                              <div class="progress-bar bg-upload total-upload-progress" style="width: 0%" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                           </div>
                        </div>
                        <div class="col-auto">
                           <h3>
                              <span class="zero-total-upload">0%</span>
                              <span class="total-upload-percentage"></span>
                           </h3>
                        </div>
                     </div>
                  </div>
                  <div class="swipgle-main-uploader">
                     <div id="swipgle-upload-process">
                        <div class="swipgle-upload-block">
                           <div id="swipgle-upload-clickable" class="swipgle-uploader-section">
                              <div class="swipgle-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                              <h3>{{__('frontend.click_or_drag')}}</h3>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="swipgle-upload-previews-area overflow-auto">
                     <div id="swipgle-upload-previews"></div>
                     <div>
                        <div id="swipgle-drop-template" class="swipgle-uploader-bottom d-none">
                           <div class="swipgle-uploader-bottomFlex">
                              <div class="swipgle-file-information">
                                 <div class="row align-items-center">
                                    <div class="col">
                                       <span class="swipgle-file-uploded fade-in d-none"><i class="far fa-check-circle"></i></span>
                                       <span class="swipgle-file-not-uploded text-danger fade-in d-none"><i class="fas fa-ban"></i></span>
                                       <span class="swipgle-uploader-name swipgle-short-name dz-remove" data-dz-name></span>
                                    </div>
                                    <div class="col-auto">
                                       <span class="float-right swipgle-remove-file">
                                       <span class="swipgle-file-percentage" id="swipgle-file-percentage">
                                       <span class="swipgle-file-size fade-in"></span>
                                       <span class="swipgle-percent-text the-progress-text"></span>
                                       </span>
                                       <i data-dz-remove class="remove-file fas"></i>
                                       </span>
                                    </div>
                                 </div>
                                 <span class="swipgle-errors text-danger"></span>
                              </div>
                              <div class="swipgle-uploader-progress">
                                 <div class="progress swipgle-upload-progress">
                                    <div data-dz-uploadprogress class="progress-bar bg-upload" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection