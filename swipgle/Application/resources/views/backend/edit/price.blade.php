@extends('layouts.backend')
@section('title', 'Edir price #'.$price->id)
@section('content')
<div class="swipgle-backend-pages">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('edit.price.store', $price->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="price_id" value="{{ $price->id }}">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">{{__('Space :')}} <span class="point-red">*</span></label>
                        <div class="col">
                            <div class="input-group">
                                <input type="number" name="space" class="form-control" placeholder="1073741824" required value="{{ $price->space }}">
                                <span class="input-group-text"><strong>{{__('Bytes')}}</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">{{__('Space price :')}} <span class="point-red">*</span></label>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" name="price" id="price" class="form-control" placeholder="0.00" required value="{{ $price->price }}">
                                <span class="input-group-text"><strong>{{ $settings->website_currency }}</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">{{__('Save changes')}}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="note note-warning">
                {{__('The script uses bytes and converts them according to the entered quantity. You can rely on the data below to find out how to convert or')}}
                <strong>{{__('you can use ')}}<a href="https://convertlive.com/u/convert/gigabytes/to/bytes" target="_blank">{{__('Convert Live')}}</a></strong>
                <ul class="mt-2">
                    <li>{{__('1 Kilobytes = 1024 Bytes')}}</li>
                    <li>{{__('1 Megabytes = 1048576 Bytes')}}</li>
                    <li>{{__('1 Gigabytes = 1073741824 Bytes')}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection