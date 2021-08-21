<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('frontend.includes.head')
</head>
    @include('frontend.includes.variables')
<body>
    @if($__env->yieldContent('title') != "Page not found" && request()->segment(1) != 'checkout')
    @include('frontend.includes.header')
    @endif
    <div class="swipgle-app" id="app">
        <div class="container-xl">
            @yield('content')
        </div>
    </div>
    @include('frontend.includes.footer')
</body>
</html>