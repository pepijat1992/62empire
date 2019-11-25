@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">    
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.promotion')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-gift"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.promotion')}}</h1>
                    <small>{{__('words.promotion_management')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="clearfix">
                        <a href="{{route('promotion.create')}}" class="btn btn-sm btn-primary font-weight-bold float-right" id="btn-add-new"><i class="fas fa-plus mr-2"></i>{{__('words.add_new')}}</a>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.title')}}</th>
                                    <th>{{__('words.rate')}}</th>
                                    <th>{{__('words.amount')}}</th>
                                    <th>{{__('words.start')}}</th>
                                    <th>{{__('words.end')}}</th>
                                    <th>{{__('words.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="title">{{$item->title}}</td>
                                        <td class="rate">{{$item->rate}} %</td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="start_at">{{$item->start_at}}</td>
                                        <td class="end_at">{{$item->end_at}}</td>
                                        <td class="action">
                                            <a href="{{route('promotion.edit', $item->id)}}" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit-agent" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('words.edit')}}"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('promotion.destroy', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" data-toggle="tooltip" title="{{__('words.delete')}}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" align="center">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                $("#search_player").val('');
                $("#search_period").val('');
            });
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
