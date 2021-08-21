@if(request()->path() == '/' && $settings->home_message  != null)
<div class="swipgle-top-bar">
   <p>{{ $settings->home_message }}</p>
</div>
@endif
<header class="navbar navbar-expand-md d-print-none @if(request()->segment(1) != 'download') navbar-dark bg-swipgle-primary @else sticky-top navbar-light bg-white box-shadow-bottom d-none d-md-flex @endif">
   <div class="@if(request()->segment(1) != 'download') container-xl @else container-fluid @endif">
   @if(request()->segment(1) != 'download')
   <div class="navbar-brand">
      <a href="{{ url('/') }}">
      <img src="{{ logofav($settings->logo) }}" width="110" height="32" alt="{{ $settings->website_name }}" class="navbar-brand-image">
      </a>
   </div>
   @endif
   <div class="navbar-nav flex-row order-md-last @if(request()->segment(1) == 'download') ms-auto @endif">
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
      @endguest 
      @if(request()->path() != 'email/verify')
      <li class="nav-item">
         <div class="dropdown">
            <button type="button" class="btn dropdown-toggle d-none d-md-flex" data-bs-toggle="dropdown">
               <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <line x1="4" y1="6" x2="20" y2="6" />
                  <line x1="4" y1="12" x2="20" y2="12" />
                  <line x1="4" y1="18" x2="20" y2="18" />
               </svg>
               {{__('frontend.menu')}}
            </button>
            <button class="navbar-toggler d-flex d-md-none"type="button" class="btn" data-bs-toggle="dropdown">
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
               @guest
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
               @endguest
               @if(request()->segment(1) != 'download')
               @foreach($menu_pages as $menu_page)
               <a class="dropdown-item dropdown-item-custom" href="{{ route('view.page', $menu_page->slug) }}">{{ $menu_page->title }}</a>
               @endforeach
               @else 
               @foreach($pages as $page)
               <a class="dropdown-item dropdown-item-custom" href="{{ route('view.page', $page->slug) }}">{{ $page->title }}</a>
               @endforeach
               @endif
            </div>
         </div>
      </li>
      @endif
      @auth
      <div class="nav-item dropdown ps-3">
         <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm" style="background-image: url({{ avatar(auth()->user()->avatar) }})"></span>
            <div class="d-none d-xl-block ps-2">
               <div>{{ auth()->user()->name }}</div>
               <div class="mt-1 small text-muted">{{ permission(auth()->user()->permission) }}</div>
            </div>
         </a>
         <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            @if(request()->path() != 'email/verify')
            <a href="{{ route('user.dashboard') }}" class="dropdown-item">{{__('frontend.dashboard')}}</a>
            <a href="{{ route('payments.page') }}" class="dropdown-item">{{__('frontend.buy_space')}}</a>
            <a href="{{ route('user.settings') }}" class="dropdown-item">{{__('frontend.settings')}}</a>
            <div class="dropdown-divider"></div>
            @endif
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('frontend.logout')}}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
            </form>
         </div>
      </div>
      @endauth
   </div>
</header>