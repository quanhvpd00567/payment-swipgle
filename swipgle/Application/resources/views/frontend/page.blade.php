@extends('layouts.frontend')
@section('title', $page->title)
@section('content')
<div class="swipgle-pages">
    @if($page->slug != "contact")
    <div class="card card-md">
       <div class="card-body">
          <h3 class="card-title">{{ $page->title }}</h3>
          <div class="markdown">
             {!! $page->content !!}
          </div>
       </div>
    </div>
    @else 
    @if($errors->any())
    <div class="note note-danger">
       @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
       @endforeach
    </div>
    @endif
    @if(session('success'))
    <div class="note note-success">
       {{ session('success') }}
    </div>
    @endif
    <div class="card card-md">
       <div class="card-body">
          <h3 class="card-title">{{__('frontend.contact')}}</h3>
          <form action="{{ route('send.message') }}" method="POST">
             @csrf
             <div class="row">
                <div class="col-lg-6">
                   <div class="form-group">
                      <input type="text" id="name" name="name" class="form-control"  placeholder="{{__('frontend.contact_name') }}" required="required" value="{{ Auth::user()->name ?? "" }}">
                   </div>
                </div>
                <div class="col-lg-6">
                   <div class="form-group">
                      <input type="email" id="email" name="email" class="form-control" placeholder="{{__('frontend.contact_email') }}" required="required" value="{{ Auth::user()->email ?? "" }}">
                   </div>
                </div>
             </div>
             <div class="form-group">
                <input type="text" id="subject" name="subject" class="form-control" placeholder="{{__('frontend.contact_subject') }}" required="required">
             </div>
             <div class="form-group">
                <textarea class="form-control" id="message" name="message" placeholder="{{__('frontend.contact_message') }}" required="required" rows="8"></textarea>
             </div>
             <div class="form-group">
                {!! app('captcha')->display() !!}
             </div>
             <div>
                <button type="submit" class="btn btn-primary btn-pd">{{__('frontend.send_message_btn')}}</button>
             </div>
          </form>
       </div>
    </div>
    @endif
</div>
@endsection