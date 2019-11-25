@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.credit_transaction')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-coins"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.credit_transaction')}}</h1>
                    <small>{{__('words.credit_transaction')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="clearfix">
                        <form action="" class="form-inline" method="post">
                            @csrf
                            <input type="text" name="username" class="form-control form-control-sm mr-2" value="{{$username}}" id="search_username" placeholder="{{__('words.username')}}" />
                            <select name="type" id="search_type" class="form-control form-control-sm mr-2">
                                <option value="" hidden>{{__('words.type')}}</option>
                                <option value="admin_agent" @if($type == 'admin_agent') selected @endif>{{__('words.to_agent')}}</option>
                                <option value="admin_user" @if($type == 'admin_user') selected @endif>{{__('words.to_player')}}</option>
                                <option value="agent_admin" @if($type == 'agent_admin') selected @endif>{{__('words.from_agent')}}</option>
                                <option value="user_agent" @if($type == 'user_agent') selected @endif>{{__('words.from_player')}}</option>
                                <option value="player_deposit" @if($type == 'player_deposit') selected @endif>{{__('words.player_deposit')}}</option>
                                <option value="player_withdraw" @if($type == 'player_withdraw') selected @endif>{{__('words.player_withdraw')}}</option>
                                <option value="bonus" @if($type == 'bonus') selected @endif>{{__('words.bonus')}}</option>
                                <option value="withdraw_fee" @if($type == 'withdraw_fee') selected @endif>{{__('words.handling_fee')}}</option>
                            </select>
                            <input type="text" name="period" class="form-control form-control-sm mr-2" value="{{$period}}" style="min-width: 200px;" id="search_period" autocomplete="off" placeholder="{{__('words.date_time')}}" />
                            <button type="submit" class="btn btn-sm btn-primary float-right mt-2 mt-md-0 mr-2"><i class="fas fa-search mr-1"></i>{{__('words.search')}}</button>
                            <button type="button" class="btn btn-sm btn-secondary float-right mt-2 mt-md-0" id="btn-reset"><i class="fas fa-eraser mr-1"></i>{{__('words.reset')}}</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.sender')}}</th>
                                    <th>{{__('words.receiver')}}</th>
                                    <th>{{__('words.amount')}}</th>
                                    <th>{{__('words.type')}}</th>
                                    <th>{{__('words.date_time')}}</th>
                                    <th>{{__('words.description')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="sender" data-sender="{{$item->sender_id}}">
                                            {{$item->sender->username ?? ''}}
                                        </td>
                                        <td class="receiver" data-receiver="{{$item->receiver_id}}">
                                            {{$item->receiver->username ?? ''}}                                            
                                        </td>
                                        <td class="amount">{{number_format($item->amount, 2)}}</td>
                                        <td class="type">
                                            @switch($item->type)
                                                @case('admin_agent')
                                                    {{__('words.to_agent')}}
                                                    @break
                                                @case('admin_user')
                                                    {{__('words.to_player')}}
                                                    @break
                                                @case('agent_admin')
                                                    {{__('words.from_agent')}}
                                                    @break
                                                @case('user_admin')
                                                    {{__('words.from_player')}}
                                                    @break
                                                @case('player_deposit')
                                                    {{__('words.player_deposit')}}
                                                    @break
                                                @case('player_withdraw')
                                                    {{__('words.player_withdraw')}}
                                                    @break
                                                @case('bonus')
                                                    {{__('words.bonus')}}
                                                    @break
                                                @default                                                    
                                            @endswitch
                                        </td>
                                        <td class="created_at">{{$item->created_at}}</td>
                                        <td class="description">{{$item->description}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th colspan="12" class="text-center">
                                        {{__('words.total_income')}}: <span class="text-primary mr-5">+{{number_format($total_income)}}</span>
                                        {{__('words.total_expense')}}: <span class="text-danger">-{{number_format($total_expense)}}</span>
                                    </th>
                                </tr>
                            </tfoot> --}}
                        </table>                
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection
    
@section('script')
    <script src="{{asset('backend/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $("#search_period").dateRangePicker();
            
            $("#btn-reset").click(function() {
                $("#search_username").val('');
                $("#search_type").val('');
                $("#search_period").val('');
            });
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
