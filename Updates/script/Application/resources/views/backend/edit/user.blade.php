@extends('layouts.backend')
@section('title', 'Edit user #'.$user->id)
@section('content')
<div class="swipgle-backend-pages row">
   <div class="col-lg-6 @if($user->id == auth()->user()->id) m-auto @endif">
      <div class="card mb-3">
         <div class="card-header bg-primary text-white">{{__('User information')}}</div>
         <div class="card-body text-center">
            <img class="rounded-circle mb-3" src="{{ avatar($user->avatar) }}" alt="{{ $user->name}}" width="100" height="100">
            <h3>{{ $user->name }}</h3>
         </div>
         <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex"><strong>{{__('User ID :')}}</strong> <span class="m-0 ms-auto">{{ $user->id }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Email :')}}</strong> <span class="m-0 ms-auto">{{ $user->email }}</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Permission :')}}</strong> <span class="m-0 ms-auto">@if($user->permission == 2) <span class="badge bg-secondary">{{__('User')}}</span> @elseif($user->permission == 1) <span class="badge bg-primary">{{__('Admin')}}</span> @endif</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Status :')}}</strong> <span class="m-0 ms-auto">@if($user->status == 1) <span class="badge bg-success">{{__('Active')}}</span> @elseif($user->status == 2) <span class="badge bg-danger">{{__('Banned')}}</span> @endif</span></li>
            <li class="list-group-item d-flex"><strong>{{__('Joined at :')}}</strong> <span class="m-0 ms-auto">@datetime($user->created_at)</span></li>
         </ul>
      </div>
   </div>
   @if($user->id != auth()->user()->id)
   <div class="col-lg-6">
      <div class="card">
         <div class="card-header bg-dark text-white">{{__('Update user information')}}</div>
         <div class="card-body">
            <form action="{{ route('edit.user.store', $user->id) }}" method="POST">
               @csrf
               <input type="hidden" name="user_id" value="{{ $user->id }}">
               <div class="form-group">
                  <label for="status">{{__('Status :')}} <span class="point-red">*</span></label>
                  <select name="status" class="form-select" required>
                  <option value="1" @if($user->status == 1) selected @endif>{{__('Active')}}</option>
                  <option value="2" @if($user->status == 2) selected @endif>{{__('Banned')}}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="space">{{__('Space :')}} <span class="point-red">*</span></label>
                  <div class="input-group">
                     <input type="number" name="space" class="form-control" placeholder="1073741824" required value="{{ $user->space }}" required>
                     <span class="input-group-text"><strong>{{__('Bytes')}}</strong></span>
                  </div>
               </div>
               <button onclick="return confirm('are you sure?')" class="btn btn-primary btn-pd w-100" type="submit">{{__('Save changes')}}</button>
            </form>
         </div>
      </div>
   </div>
   @endif
</div>
@endsection