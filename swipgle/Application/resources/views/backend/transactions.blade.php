@extends('layouts.backend')
@section('title', 'Transactions')
@section('content')
<div class="swipgle-backend-pages">
   <div class="card">
      <ul class="nav nav-tabs" data-bs-toggle="tabs">
         <li class="nav-item">
            <a href="#paid" class="nav-link active" data-bs-toggle="tab">{{__('Paid ('.$paid_transactions->count().')')}}</a>
         </li>
         <li class="nav-item">
            <a href="#unpaid" class="nav-link" data-bs-toggle="tab">{{__('Unpaid ('.$unpaid_transactions->count().')')}}</a>
         </li>
         <li class="nav-item">
            <a href="#canceled" class="nav-link" data-bs-toggle="tab">{{__('Canceled ('.$canceled_transactions->count().')')}}</a>
         </li>
      </ul>
      <div class="card-body card-table custom-table">
         <div class="tab-content">
            <div class="tab-pane active show" id="paid">
               <div class="table-responsive">
                  <table id="basic-datatables" class="datatable display table table-striped table-bordered" >
                     <thead>
                        <tr>
                           <th>{{__('#ID')}}</th>
                           <th class="text-center">{{__('User')}}</th>
                           <th class="text-center">{{__('Space')}}</th>
                           <th class="text-center">{{__('Method')}}</th>
                           <th class="text-center">{{__('Status')}}</th>
                           <th class="text-center">{{__('Date')}}</th>
                           <th class="text-center">{{__('View')}}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($paid_transactions as $paid_transaction)
                        <tr>
                           <td>{{ $paid_transaction->id }}</td>
                           <td class="text-center"><a href="{{ route('edit.user', $paid_transaction->user->id) }}">{{ $paid_transaction->user->name }}</a></td>
                           <td class="text-center text-primary"><strong>+{{ formatBytes($paid_transaction->space) }}</strong></td>
                           <td class="text-center">{{ $paid_transaction->method }}</td>
                           <td class="text-center">{!! transactionStatus($paid_transaction->payment_status) !!}</td>
                           <td class="text-center">@datetime($paid_transaction->created_at)</td>
                           <td class="text-center">
                              <a href="{{ route('view.transaction', $paid_transaction->id) }}" class="btn btn-warning btn-sm">
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
            <div class="tab-pane" id="unpaid">
               <div class="table-responsive">
                  <table id="basic-datatables2" class="display table table-striped table-bordered" >
                     <thead>
                        <tr>
                           <th>{{__('#ID')}}</th>
                           <th class="text-center">{{__('User')}}</th>
                           <th class="text-center">{{__('Space')}}</th>
                           <th class="text-center">{{__('Method')}}</th>
                           <th class="text-center">{{__('Status')}}</th>
                           <th class="text-center">{{__('Date')}}</th>
                           <th class="text-center">{{__('View')}}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($unpaid_transactions as $unpaid_transaction)
                        <tr>
                           <td>{{ $unpaid_transaction->id }}</td>
                           <td class="text-center"><a href="{{ route('edit.user', $unpaid_transaction->user->id) }}">{{ $unpaid_transaction->user->name }}</a></td>
                           <td class="text-center text-primary"><strong>+{{ formatBytes($unpaid_transaction->space) }}</strong></td>
                           <td class="text-center">{{ $unpaid_transaction->method }}</td>
                           <td class="text-center">{!! transactionStatus($unpaid_transaction->payment_status) !!}</td>
                           <td class="text-center">@datetime($unpaid_transaction->created_at)</td>
                           <td class="text-center">
                              <a href="{{ route('view.transaction', $unpaid_transaction->id) }}" class="btn btn-warning btn-sm">
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
            <div class="tab-pane" id="canceled">
               <div class="table-responsive">
                  <table id="basic-datatables3" class="display table table-striped table-bordered" >
                     <thead>
                        <tr>
                           <th>{{__('#ID')}}</th>
                           <th class="text-center">{{__('User')}}</th>
                           <th class="text-center">{{__('Space')}}</th>
                           <th class="text-center">{{__('Method')}}</th>
                           <th class="text-center">{{__('Status')}}</th>
                           <th class="text-center">{{__('Date')}}</th>
                           <th class="text-center">{{__('View')}}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($canceled_transactions as $canceled_transaction)
                        <tr>
                           <td>{{ $canceled_transaction->id }}</td>
                           <td class="text-center"><a href="{{ route('edit.user', $canceled_transaction->user->id) }}">{{ $canceled_transaction->user->name }}</a></td>
                           <td class="text-center text-primary"><strong>+{{ formatBytes($canceled_transaction->space) }}</strong></td>
                           <td class="text-center">{{ $canceled_transaction->method }}</td>
                           <td class="text-center">{!! transactionStatus($canceled_transaction->payment_status) !!}</td>
                           <td class="text-center">@datetime($canceled_transaction->created_at)</td>
                           <td class="text-center">
                              <a href="{{ route('view.transaction', $canceled_transaction->id) }}" class="btn btn-warning btn-sm">
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