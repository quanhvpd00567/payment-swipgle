@extends('layouts.backend')
@section('title', 'Users')
@section('content')
<div class="card">
    <div class="card-header">
       <h2 class="m-0">{{__('All users')}}</h2>
       <span class="col-auto ms-auto d-print-none">
          <button data-bs-toggle="modal" data-bs-target="#modal-simple" class="btn btn-primary">
             <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11h6m-3 -3v6" /></svg>
             {{__('Add Admin')}}
          </button>
       </span>
       <div class="modal modal-blur fade" id="modal-simple" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title">{{__('Add new admin')}}</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form action="{{ route('add.user.store') }}" method="POST">
                      @csrf
                      <div class="form-group">
                         <label for="name">{{__('Name :')}}</label>
                         <input type="name" class="form-control fm40" placeholder="Admin name" name="name" required>
                      </div>
                      <div class="form-group">
                         <label for="email">{{__('Email :')}}</label>
                         <input type="email" class="form-control fm40" placeholder="Admin email" name="email" required>
                      </div>
                      <div class="form-group">
                         <label for="password">{{__('Password :')}}</label>
                         <input type="password" class="form-control fm40" placeholder="Admin password" name="password" required>
                      </div>
                      <div class="form-group">
                         <label for="confirm-password">{{__('Confirm password :')}}</label>
                         <input type="password" class="form-control fm40" placeholder="Confirm password" name="password_confirmation" required>
                      </div>
                   </div>
                   <div class="modal-footer">
                      <button id="addAdmin" type="type" class="btnadd btn btn-primary">{{__('Add')}}</button>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
    <div class="card-body card-table custom-table">
       <div class="table-responsive">
          <table id="basic-datatables" class="display table table-striped table-bordered" >
             <thead>
                <tr>
                   <th class="text-center">{{__('#ID')}}</th>
                   <th class="text-center">{{__('Avatar')}}</th>
                   <th class="text-center">{{__('Name')}}</th>
                   <th class="text-center">{{__('Email')}}</th>
                   <th class="text-center">{{__('Joined at')}}</th>
                   <th class="text-center">{{__('Permission')}}</th>
                   <th class="text-center">{{__('Status')}}</th>
                   <th class="text-center">{{__('Action')}}</th>
                </tr>
             </thead>
             <tbody>
                @foreach($users as $user)
                <tr>
                   <td class="text-center">{{ $user->id }}</td>
                   <td class="text-center"><img  class="rounded-circle" src="{{ avatar($user->avatar) }}" alt="{{ $user->name}}" width="40" height="40"></td>
                   <td class="text-center">{{ $user->name }}</td>
                   <td class="text-center">{{ $user->email }}</td>
                   <td class="text-center">@datetime($user->created_at)</td>
                   <td class="text-center">
                      @if($user->permission == 2)
                      <span class="badge bg-secondary">{{__('User')}}</span>
                      @elseif($user->permission == 1)
                      <span class="badge bg-primary">{{__('Admin')}}</span>
                      @endif
                   </td>
                   <td class="text-center">
                      @if($user->status == 1)
                      <span class="badge bg-success">{{__('Active')}}</span>
                      @elseif($user->status == 2) 
                      <span class="badge bg-danger">{{__('Banned')}}</span>
                      @endif
                   </td>
                   <td class="text-center">
                      <a href="{{ route('edit.user', $user->id) }}" class="btn btn-dark btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                         {{__('Edit')}}
                      </a>
                   </td>
                </tr>
                @endforeach
             </tbody>
          </table>
       </div>
    </div>
 </div>
@endsection