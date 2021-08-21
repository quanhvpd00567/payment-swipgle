@extends('layouts.frontend')
@section('title', __('errors.page_title'))
@section('content')
<div class="error_pages">
    <div class="empty">
        <img src="{{ asset('images/sections/error.svg') }}" width="250" height="250" alt="error">
        <div class="empty-header">{{__('401')}}</div>
        <p class="empty-title">{{__('errors.error_title')}}</p>
        <p class="empty-subtitle text-muted">
          {{__('errors.error_description')}}
        </p>
        <div class="empty-action">
          <a href="{{ url('/') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="5" y1="12" x2="19" y2="12"></line><line x1="5" y1="12" x2="11" y2="18"></line><line x1="5" y1="12" x2="11" y2="6"></line></svg>
            {{__('errors.error_btn')}}
          </a>
        </div>
    </div>
</div>
@endsection