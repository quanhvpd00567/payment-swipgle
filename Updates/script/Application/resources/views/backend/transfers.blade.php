@extends('layouts.backend')
@section('title', 'Transfers')
@section('content')
<div class="swipgle-backend-pages">
   <div class="card">
      <ul class="nav nav-tabs" data-bs-toggle="tabs">
         <li class="nav-item">
            <a href="#mail" class="nav-link active" data-bs-toggle="tab"><i class="fa fa-envelope me-2"></i>{{__('Transfered by email ('.$mail_transfers->count().')')}}</a>
         </li>
         <li class="nav-item">
            <a href="#link" class="nav-link" data-bs-toggle="tab"><i class="fa fa-link me-2"></i>{{__('Transfered by link ('.$link_transfers->count().')')}}</a>
         </li>
      </ul>
      <div class="card-body card-table custom-table">
         <div class="tab-content">
            <div class="tab-pane active show" id="mail">
               <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-bordered" >
                    <thead>
                       <tr>
                          <th>{{__('ID')}}</th>
                          <th>{{__('Transfer #ID')}}</th>
                          <th class="text-center">{{__('User')}}</th>
                          <th class="text-center">{{__('Spend space')}}</th>
                          <th class="text-center">{{__('Total files')}}</th>
                          <th class="text-center">{{__('Status')}}</th>
                          <th class="text-center">{{__('Date')}}</th>
                          <th class="text-center">{{__('View')}}</th>
                       </tr>
                    </thead>
                    <tbody>
                       @foreach ($mail_transfers as $mail_transfer)
                       <tr>
                          <td>{{ $mail_transfer->id }}</td>
                          <td>{{ '#'.strtoupper($mail_transfer->transfer_id) }}</td>
                          <td class="text-center"><a href="{{ route('edit.user', $mail_transfer->user->id) }}">{{ $mail_transfer->user->name }}</a></td>
                          <td class="text-center text-danger"><strong>-{{ formatBytes($mail_transfer->spend_space) }}</strong></td>
                          <td class="text-center">{{ $mail_transfer->total_files }}</td>
                          <td class="text-center">{!! transfer_status($mail_transfer->tranfer_status, $mail_transfer->create_method) !!}</td>
                          <td class="text-center">@datetime($mail_transfer->created_at)</td>
                          <td class="text-center">
                             <a href="{{ route('admin.view.transfer', $mail_transfer->transfer_id) }}" class="btn btn-blue btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                   <circle cx="12" cy="12" r="2" />
                                   <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                </svg>
                             </a>
                          </td>
                       </tr>
                       @endforeach
                    </tbody>
                </table>
               </div>
            </div>
            <div class="tab-pane" id="link">
               <div class="table-responsive">
                <table id="basic-datatables2" class="display table table-striped table-bordered" >
                    <thead>
                       <tr>
                        <th>{{__('ID')}}</th>
                          <th>{{__('Transfer #ID')}}</th>
                          <th class="text-center">{{__('User')}}</th>
                          <th class="text-center">{{__('Spend space')}}</th>
                          <th class="text-center">{{__('Total files')}}</th>
                          <th class="text-center">{{__('Status')}}</th>
                          <th class="text-center">{{__('Date')}}</th>
                          <th class="text-center">{{__('View')}}</th>
                       </tr>
                    </thead>
                    <tbody>
                       @foreach ($link_transfers as $link_transfer)
                       <tr>
                        <td>{{ $link_transfer->id }}</td>
                          <td>{{ '#'.strtoupper($link_transfer->transfer_id) }}</td>
                          <td class="text-center"><a href="{{ route('edit.user', $link_transfer->user->id) }}">{{ $link_transfer->user->name }}</a></td>
                          <td class="text-center text-danger"><strong>-{{ formatBytes($link_transfer->spend_space) }}</strong></td>
                          <td class="text-center">{{ $link_transfer->total_files }}</td>
                          <td class="text-center">{!! transfer_status($link_transfer->tranfer_status, $link_transfer->create_method) !!}</td>
                          <td class="text-center">@datetime($link_transfer->created_at)</td>
                          <td class="text-center">
                             <a href="{{ route('admin.view.transfer', $link_transfer->transfer_id) }}" class="btn btn-blue btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                   <circle cx="12" cy="12" r="2" />
                                   <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                </svg>
                             </a>
                          </td>
                       </tr>
                       @endforeach
                    </tbody>
                </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection