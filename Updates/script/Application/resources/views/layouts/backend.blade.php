<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('backend.includes.head')
   </head>
   @include('frontend.includes.variables')
   <body class="antialiased">
      <div class="page">
      <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-swipgle-primary">
         <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark">
               <a href="{{ url('/') }}">
               <img src="{{ logofav($settings->logo) }}" width="110" height="32" alt="{{ $settings->website_name }}" class="navbar-brand-image">
               </a>
            </h1>
            <div class="navbar-nav flex-row d-lg-none">
               <div class="nav-item dropdown">
                  <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                     <span class="avatar avatar-sm" style="background-image: url({{ avatar(Auth::user()->avatar) }})"></span>
                     <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">{{ permission(Auth::user()->permission) }}</div>
                     </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <a href="{{ url('admin/dashboard') }}" class="dropdown-item">{{__('Dashboard')}}</a>
                     <a href="{{ url('admin/account/settings') }}" class="dropdown-item">{{__('Settings')}}</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('Logout')}}</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                  </div>
               </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
               <ul class="navbar-nav pt-lg-3">
                  <li class="nav-item">
                     <a class="nav-link @if(request()->path() == 'admin/dashboard') active @endif" href="{{ url('admin/dashboard') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <polyline points="5 12 3 12 12 3 21 12 19 12" />
                              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Dashboard')}}</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link @if(request()->path() == 'admin/users') active @endif" href="{{ url('admin/users') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <circle cx="9" cy="7" r="4" />
                              <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                              <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Manage users')}}</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link @if(request()->path() == 'admin/transfers') active @endif" href="{{ url('admin/transfers') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <line x1="10" y1="14" x2="21" y2="3" />
                              <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Manage transfers')}}</span>
                     </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if(request()->path() == 'admin/transactions') active @endif" href="{{ url('admin/transactions') }}" >
                       <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><line x1="9" y1="12" x2="9.01" y2="12" /><line x1="13" y1="12" x2="15" y2="12" /><line x1="9" y1="16" x2="9.01" y2="16" /><line x1="13" y1="16" x2="15" y2="16" /></svg>
                       </span>
                       <span class="nav-link-title">{{__('Transactions')}}</span>
                    </a>
                 </li>
                 <li class="nav-item">
                  <a class="nav-link @if(request()->path() == 'admin/prices') active @endif" href="{{ url('admin/prices') }}" >
                     <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                     </span>
                     <span class="nav-link-title">{{__('Prices')}}</span>
                  </a>
               </li>
                  <li class="nav-item">
                     <a class="nav-link @if(request()->path() == 'admin/messages') active @endif" href="{{ url('admin/messages') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <rect x="3" y="5" width="18" height="14" rx="2" />
                              <polyline points="3 7 12 13 21 7" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Messages')}}</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link @if(request()->path() == 'admin/pages') active @endif" href="{{ url('admin/pages') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                              <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                              <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Pages')}}</span>
                     </a>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle @if(request()->path() == 'admin/settings/information' || request()->path() == 'admin/settings/payments' || request()->path() == 'admin/settings/smtp' || request()->path() == 'admin/settings/captcha' || request()->path() == 'admin/settings/amazon') show @endif" @if(request()->path() != 'admin/settings/information' && request()->path() != 'admin/settings/payments' && request()->path() != 'admin/settings/smtp' && request()->path() != 'admin/settings/captcha' && request()->path() != 'admin/settings/amazon' && request()->path() != 'admin/settings/seo') href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" @endif>
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                              <circle cx="12" cy="12" r="3" />
                           </svg>
                        </span>
                        <span class="nav-link-title">{{__('Settings')}}</span>
                     </a>
                     <div class="dropdown-menu @if(request()->path() == 'admin/settings/information' || request()->path() == 'admin/settings/payments' || request()->path() == 'admin/settings/smtp' || request()->path() == 'admin/settings/captcha' || request()->path() == 'admin/settings/amazon' || request()->path() == 'admin/settings/seo')  show @endif">
                        <div class="dropdown-menu-columns">
                           <div class="dropdown-menu-column">
                              <a class="dropdown-item @if(request()->path() == 'admin/settings/information') active @endif" href="{{ url('admin/settings/information') }}">{{__('Information')}}</a>
                              <a class="dropdown-item @if(request()->path() == 'admin/settings/payments') active @endif" href="{{ url('admin/settings/payments') }}">{{__('Payments gateway')}}</a>
                              <a class="dropdown-item @if(request()->path() == 'admin/settings/seo') active @endif" href="{{ url('admin/settings/seo') }}">{{__('Website SEO')}}</a>
                              <a class="dropdown-item @if(request()->path() == 'admin/settings/smtp') active @endif" href="{{ url('admin/settings/smtp') }}">{{__('SMTP')}}</a>
                              <a class="dropdown-item @if(request()->path() == 'admin/settings/captcha') active @endif" href="{{ url('admin/settings/captcha') }}">{{__('Captcha')}}</a>
                              <a class="dropdown-item @if(request()->path() == 'admin/settings/amazon') active @endif" href="{{ url('admin/settings/amazon') }}">{{__('Amazon S3')}}</a>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </aside>
      <div class="content mt-0">
         <header class="navbar navbar-expand-md d-print-none bg-white navbar-light d-none d-md-flex">
            <div class="container-xl">
               <div class="navbar-nav flex-row order-md-last ms-auto">
                  <div class="nav-item d-none d-md-flex me-3">
                     <a href="{{ route('messages') }}" class="nav-link px-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
                        @if($messages_count > 0 )
                        <span class="badge bg-red faa-flash animated"></span>
                        @endif
                     </a>
                  </div>
                  <div class="nav-item dropdown">
                     <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ avatar(Auth::user()->avatar) }})"></span>
                        <div class="d-none d-xl-block ps-2">
                           <div>{{ Auth::user()->name }}</div>
                           <div class="mt-1 small text-muted">{{ permission(Auth::user()->permission) }}</div>
                        </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ url('admin/dashboard') }}" class="dropdown-item">{{__('Dashboard')}}</a>
                        <a href="{{ url('admin/account/settings') }}" class="dropdown-item">{{__('Settings')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">{{__('Logout')}}</a>
                        <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                     </div>
                  </div>
               </div>
         </header>
         <div class="container-xl py-3">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb breadcrumb-alternate mb-3" aria-label="breadcrumbs">
               <?php $segments = ''; ?>
               @foreach(Request::segments() as $segment)
               <?php $segments .= '/'.$segment; ?>
               <li class="breadcrumb-item">
                  <a href="{{ url($segments) }}">{{$segment}}</a>
               </li>
               @endforeach
            </ol>
            @if($errors->any())
            <div class="note note-danger">
            @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
            </div>
            @elseif(session('success'))
            <div class="note note-success">
             {{ session('success') }}
            </div>
            @endif
            @yield('content')
         </div>
         </div>
      </div>
      @include('backend.includes.footer')
   </body>
</html>