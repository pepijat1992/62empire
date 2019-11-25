@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.set_score')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-coins"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.set_score')}}</h1>
                    <small>{{__('words.credit_transaction')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header clearfix">
                        <h5 class="mb-0 float-left mr-5">{{__('words.set_score')}}</h5>
                        {{__('words.current_balance')}} : <span class="badge badge-success">{{$user->score}}</span>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.save_score')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}" />
                            <input type="hidden" name="role" value="{{$user->role}}" />
                            <div class="form-group">
                                <label for="" class="control-label">{{__('words.amount')}}</label>
                                <input type="number" class="form-control" name="amount" placeholder="{{__('words.amount')}}" />
                            </div>
                            <button type="submit" class="btn btn-primary mr-3"><i class="fas fa-save mr-2"></i>{{__('words.save')}}</button>
                            <button type="button" class="btn btn-danger" onclick="history.go(-1)"><i class="fas fa-times mr-2"></i>{{__('words.cancel')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card card-fill">
                    <div class="card-header">
                        <h5 class="mb-0">{{__('words.transaction_history')}}</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.sender')}}</th>
                                    <th>{{__('words.receiver')}}</th>
                                    <th>{{__('words.amount')}}</th>
                                    <th>{{__('words.before_score')}}</th>
                                    <th>{{__('words.after_score')}}</th>
                                    <th>{{__('words.ip_address')}}</th>
                                    <th>{{__('words.date_time')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="sender" data-sender="{{$item->sender_id}}">
                                            {{$item->sender->username ?? ''}}
                                        </td>
                                        <td class="receiver" data-receiver="{{$item->receiver_id}}">
                                            {{$item->receiver->username ?? ''}}                                            
                                        </td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="before_score">{{$item->before_score}}</td>
                                        <td class="after_score">{{$item->after_score}}</td>
                                        <td class="ip_address">{{$item->ip}}</td>
                                        <td class="created_at">{{$item->created_at}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="text-center">{{__('words.no_data')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th>{{number_format($total_amount, 2)}}</th>
                                    <th colspan="10"></th>
                                </tr>
                            </tfoot>
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
