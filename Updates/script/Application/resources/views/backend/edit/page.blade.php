@extends('layouts.backend')
@section('title', 'Edit : '.$page->title)
@section('content')
<div class="swipgle-backend-pages">
   <div class="card">
      <div class="card-body">
        <form action="{{ route('edit.page.store', $page->id) }}" method="POST">
            @csrf
            <input type="hidden" name="page_id" value="{{ $page->id }}">
            <div class="form-group">
              <label for="title">{{__('Page Title :')}} <span class="point-red">*</span></label>
              <input type="text" name="title" class="form-control" placeholder="Enter page title" required value="{{ $page->title }}">
            </div>
            <div class="form-group">
                <label for="slug">{{__('Page Slug :')}} <span class="point-red">*</span></label>
                <div class="input-group">
                   <span class="input-group-text">{{ url('page/') }}/</span>
                   <input type="text" name="slug" class="remove-spaces form-control" placeholder="slug" required value="{{ $page->slug }}">
                </div>
            </div>
            <div class="form-group">
                <label for="content">{{__('Page Content :')}}</label>
                <textarea class="form-control" name="content" rows="10">{{ $page->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="palce">{{__('Show in :')}} <span class="point-red">*</span></label>
                <select name="place" class="form-select" required>
                    <option value="1" @if($page->place == 1) selected @endif>{{__('Menu')}}</option>
                    <option value="2" @if($page->place == 2) selected @endif>{{__('Footer')}}</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">{{__('Save changes')}}</button>
        </form>
      </div>
   </div>
</div>
@endsection