@extends('layouts.download')
@section('title', __('frontend.download_title'))
@section('content')
<div class="swipgle-file-download">
   <div class="card">
      <div class="list-group list-group-flush">
         @foreach($files as $file)
         <a href="#" id="downloadFile" data-id="{{ $transfer->id }}" data-file="{{ $file }}" class="list-group-item list-group-item-action d-flex @if(request()->session()->has($file)) bg-swipgle-light text-dark @endif">
            <span class="me-3"><img src="{{ fileIcon($file) }}" width="30" height="24" alt="{{ $file }}"></span>
            <span class="vl-middle file-name">{{ $file }}</span>
            <span class="ms-auto download-icon">
               <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                  <polyline points="7 11 12 16 17 11" />
                  <line x1="12" y1="4" x2="12" y2="16" />
               </svg>
            </span>
         </a>
         @endforeach
      </div>
   </div>
</div>
@endsection