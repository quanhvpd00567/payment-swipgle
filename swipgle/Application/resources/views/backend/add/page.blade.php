@extends('layouts.backend')
@section('title', 'Add page')
@section('content')
<div class="swipgle-backend-pages">
   <div class="card">
      <div class="card-body">
        <form action="{{ route('add.page.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="title">{{__('Page Title :')}} <span class="point-red">*</span></label>
              <input type="text" name="title" class="form-control" placeholder="Enter page title" required>
            </div>
            <div class="form-group">
                <label for="slug">{{__('Page Slug :')}} <span class="point-red">*</span></label>
                <div class="input-group">
                   <span class="input-group-text">{{ url('page/') }}/</span>
                   <input type="text" name="slug" class="remove-spaces form-control" placeholder="slug" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content">{{__('Page Content :')}}</label>
                <textarea class="form-control" name="content" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="palce">{{__('Show in :')}} <span class="point-red">*</span></label>
                <select name="place" class="form-select" required>
                    <option value="" selected disabled>{{__('Choose')}}</option>
                    <option value="1">{{__('Menu')}}</option>
                    <option value="2">{{__('Footer')}}</option>
                </select>
            </div>
            <button class="btn btn-primary">{{__('Add page')}}</button>
        </form>
      </div>
   </div>
</div>
@endsection