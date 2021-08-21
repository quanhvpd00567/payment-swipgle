<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(request()->segment(1) != "download") 
    <meta name="description" content="{{ $seo->seo_description }}">
    <meta name="keywords" content="{{ $seo->seo_keywords }}">
    <meta property="og:title" content="{{ $settings->website_name }} - {{ $seo->seo_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $settings->website_name }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ logofav($settings->logo) }}" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="{{ $seo->seo_description }}">
    <meta name="twitter:title" content="{{ $seo->seo_title }}">
    <meta name="twitter:site" content="{{ url('/') }}">
    @endif
    <title>{{ $settings->website_name }} — @yield('title')</title>
    <link href="{{ logofav($settings->favicon) }}" rel="shortcut icon">
    <link rel="stylesheet" href="{{ asset('ui/css/app.css') }}">
    @if(request()->segment(1) == 'checkout')
    <link rel="stylesheet" href="{{ asset('ui/css/checkout.css') }}">
    @endif
