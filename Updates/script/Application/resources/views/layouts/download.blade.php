<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('frontend.includes.head')
   </head>
      @include('frontend.includes.variables')
   <body class="antialiased">
      <div class="page">
         <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-swipgle-primary">
            <div class="container-fluid">
               <button class="navbar-toggler navbar-toggler-files" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
               </button>
               <div class="navbar-brand navbar-brand-autodark">
                  <a href="{{ url('/') }}">
                  <img src="{{ logofav($settings->logo) }}" width="110" height="32" alt="{{ $settings->website_name }}" class="navbar-brand-image">
                  </a>
               </div>
               <div class="navbar-nav flex-row d-lg-none">
                  @guest
                  <li class="nav-item pe-0 pe-md-2 d-none d-md-flex">
                     <a href="{{ url('/login') }}" class="btn btn-swipgle-secondary"">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                           <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                           <path d="M20 12h-13l3 -3m0 6l-3 -3"></path>
                        </svg>
                        {{__('frontend.login')}}
                     </a>
                  </li>
                  <li class="nav-item">
                     <div class="dropdown">
                        <button class="navbar-toggler"type="button" class="btn" data-bs-toggle="dropdown">
                           <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="dropdown-menu custom-dropdown-menu">
                           <a class="dropdown-item dropdown-item-custom" href="{{ url('/') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                 <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                 <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                 <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                              </svg>
                              {{__('frontend.home')}}
                           </a>
                           <a class="dropdown-item dropdown-item-custom" href="{{ url('/login') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                 <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                 <path d="M20 12h-13l3 -3m0 6l-3 -3" />
                              </svg>
                              {{__('frontend.login')}}
                           </a>
                           <a class="dropdown-item dropdown-item-custom" href="{{ url('/register') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                 <circle cx="9" cy="7" r="4" />
                                 <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                 <path d="M16 11h6m-3 -3v6" />
                              </svg>
                              {{__('frontend.create_account')}}
                           </a>
                           @foreach($pages as $page)
                           <a class="dropdown-item dropdown-item-custom" href="{{ route('view.page', $page->slug) }}">{{ $page->title }}</a>
                           @endforeach
                        </div>
                     </div>
                  </li>
                  @endguest 
                  @auth
                  <div class="nav-item dropdown ps-3">
                     <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ avatar(Auth::user()->avatar) }})"></span>
                        <div class="d-none d-xl-block ps-2">
                           <div>{{ Auth::user()->name }}</div>
                           <div class="mt-1 small text-muted">{{ permission(Auth::user()->permission) }}</div>
                        </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ url('/') }}" class="dropdown-item">{{__('frontend.home')}}</a>
                        <a href="{{ route('user.dashboard') }}" class="dropdown-item">{{__('frontend.dashboard')}}</a>
                        <a href="{{ route('payments.page') }}" class="dropdown-item">{{__('frontend.buy_space')}}</a>
                        <a href="{{ route('user.settings') }}" class="dropdown-item">{{__('frontend.settings')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form3').submit();">{{__('frontend.logout')}}</a>
                        <form id="logout-form3" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                        <div class="dropdown-divider"></div>
                        @foreach($pages as $page)
                           <a class="dropdown-item" href="{{ route('view.page', $page->slug) }}">{{ $page->title }}</a>
                        @endforeach
                     </div>
                  </div>
                  @endauth
               </div>
               <div class="collapse navbar-collapse" id="navbar-menu">
                   <div class="swipgle-download-user text-center py-3">
                    <span class="avatar avatar-xl rounded-circle" style="background-image: url({{ avatar($user->avatar) }})"></span>
                    <h2 class="pt-3">{{ $user->name }}</h2>
                    <span><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 15" /></svg> {{ $transfer->created_at->diffForHumans()  }}</span>
                   </div>
               </div>
            </div>
         </aside>
         @include('frontend.includes.header')
         <div class="content mt-0 mb-0">
            @yield('content')
         </div>
      </div>
      @include('frontend.includes.footer')
   </body>
</html>