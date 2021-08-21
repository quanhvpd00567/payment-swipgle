<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->website_name }} — {{__('Admin')}} - @yield('title')</title>
    <link href="{{ logofav($settings->favicon) }}" rel="shortcut icon">
    <link rel="stylesheet" href="{{ asset('ui/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ui/css/backend/app.css') }}">
