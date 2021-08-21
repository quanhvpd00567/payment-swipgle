@extends('layouts.backend')
@section('title', 'Website SEO')
@section('content')
<div class="swipgle-backend-pages">
    <div class="card">
        <div class="card-header"><h3 class="m-0">{{__('Website SEO')}}</h3></div>
        <div class="card-body p-4">
            <form action="{{ route('seo.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Home page tite :')}} <span class="point-red">*</span></label>
                    <div class="col">
                      <input type="text" name="seo_title" class="form-control" value="{{ $seo->seo_title }}" required>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Description :')}}</label>
                    <div class="col">
                        <textarea name="seo_description" id="seo_description" rows="6" class="form-control" placeholder="Enter description">{{ $seo->seo_description}}</textarea>
                    </div>
                </div>
                <div class="form-group mb-4 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{__('Keywords :')}}</label>
                    <div class="col">
                        <textarea name="seo_keywords" id="seo_keywords" rows="6" class="form-control" placeholder="tag, tag, tag">{{ $seo->seo_keywords}}</textarea>
                    </div>
                </div>
                <div class="text-right">
                   <button class="btn btn-primary" type="submit">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection