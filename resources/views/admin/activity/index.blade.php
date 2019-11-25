@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">    
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.admin_activity')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-hourglass-half"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.admin_activity')}}</h1>
                    <small>{{__('words.admin_activity_history')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="clearfix">
                        <form action="" class="form-inline float-left" method="post" id="searchForm">
                            @csrf
                            @php
                                $type_array = ['sign_in', 'sign_out', 'create_player', 'create_agent', 'confirm_deposit', 'confirm_withdraw', 'reject_deposit', 'reject_withdraw', 'set_score'];
                            @endphp
                            <select class="form-control form-control-sm mr-md-2" name="type" id="search_type">
                                <option value="" hidden>{{__('words.type')}}</option>
                                @foreach ($type_array as $item)
                                    <option value="{{$item}}" @if($type == $item) selected @endif>{{__('words.'.$item)}}</option>
                                @endforeach                                
                            </select>
                            <input type="text" name="keyword" class="form-control form-control-sm mr-2" value="{{$keyword}}" id="search_keyword" placeholder="{{__('words.keyword')}}" />                            
                            <input type="text" name="period" class="form-control form-control-sm mr-2" value="{{$period}}" style="min-width: 200px;" id="search_period" autocomplete="off" placeholder="{{__('words.created_at')}}" />
                            <button type="submit" class="btn btn-sm btn-primary float-right mt-2 mt-md-0 mr-2"><i class="fas fa-search mr-1"></i>{{__('words.search')}}</button>
                            <button type="button" class="btn btn-sm btn-secondary float-right mt-2 mt-md-0" id="btn-reset"><i class="fas fa-eraser mr-1"></i>{{__('words.reset')}}</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.type')}}</th>
                                    <th>{{__('words.ip_address')}}</th>
                                    <th>{{__('words.date_time')}}</th>
                                    <th>{{__('words.description')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="type">{{__('words.'.$item->type)}}</td>
                                        <td class="ip">{{$item->ip_address}}</td>
                                        <td class="created_at">{{$item->created_at}}</td>
                                        <td class="description">{{$item->description}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends(['type' => $type, 'keyword' => $keyword, 'period' => $period])->links() !!}
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
                $("#search_keyword").val('');
                $("#search_type").val('');
                $("#search_period").val('');
            })
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
