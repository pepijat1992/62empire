@extends('agent.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/imageviewer/css/jquery.verySimpleImageViewer.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">
    <style>
        #image_preview {
            max-width: 600px;
            height: 600px;
        }
        .image_viewer_inner_container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item">{{__('words.financial_management')}}</li>
                <li class="breadcrumb-item active">{{__('words.top_up')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-money-check-alt"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.top_up')}}</h1>
                    <small>{{__('words.top_up_management')}}</small>
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
                            <input type="text" name="user" class="form-control form-control-sm mr-2" value="{{$user}}" id="search_user" placeholder="{{__('words.username')}}" />
                            <input type="text" name="period" class="form-control form-control-sm mr-2" value="{{$period}}" style="min-width: 200px;" id="search_period" autocomplete="off" placeholder="{{__('words.remittance_time')}}" />
                            <button type="submit" class="btn btn-sm btn-primary float-right mt-2 mt-md-0 mr-2"><i class="fas fa-search mr-1"></i>{{__('words.search')}}</button>
                            <button type="button" class="btn btn-sm btn-secondary float-right mt-2 mt-md-0" id="btn-reset"><i class="fas fa-eraser mr-1"></i>{{__('words.reset')}}</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.username')}}</th>
                                    <th>{{__('words.amount')}}</th>
                                    <th>{{__('words.bonus')}}</th>
                                    <th>{{__('words.bank_account')}}</th>
                                    <th>{{__('words.remittance_time')}}</th>
                                    <th>{{__('words.status')}}</th>
                                    <th>{{__('words.image')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="username" data-id="{{$item->user_id}}">{{$item->user->username}}</td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="bonus">{{$item->bonus}}</td>
                                        <td class="bank_account"></td>
                                        <td class="hk_at">{{$item->hk_at}}</td>
                                        <td class="status">
                                            @if($item->status == 1)
                                                <span class="badge badge-primary">{{__('words.pending')}}</span>
                                            @elseif($item->status == 2)
                                                <span class="badge badge-success">{{__('words.approved')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{__('words.fail')}}</span>
                                            @endif
                                        </td>
                                        <td class="image">
                                            @if (file_exists($item->image))
                                                <span class="badge badge-info btn-image" data-path="{{asset($item->image)}}" style="cursor:pointer">{{__('words.click_here')}}</span>
                                            @else
                                                <span class="text-muted">{{__('words.no_image')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2"></th>
                                    <th>{{number_format($total_amount, 2)}}</th>
                                    <th>{{number_format($total_bonus, 2)}}</th>
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

    <div class="modal fade" id="attachModal">
        <div class="modal-dialog" style="margin-top:17vh">
            <div class="modal-content">
                <div id="image_preview"></div>
            </div>
        </div>
    </div>

@endsection
    
@section('script')
    <script src="{{asset('backend/plugins/imageviewer/js/jquery.verySimpleImageViewer.min.js')}}"></script>
    <script src="{{asset('backend/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $("#search_period").dateRangePicker();
            
            $(".btn-image").click(function(e){
                let path = $(this).data('path');
                $("#image_preview").html('')
                $("#image_preview").verySimpleImageViewer({
                    imageSource: path,
                    frame: ['100%', '100%'],
                    maxZoom: '900%',
                    zoomFactor: '10%',
                    mouse: true,
                    keyboard: true,
                    toolbar: true,
                });
                $("#attachModal").modal();
            });

            $("#btn-reset").click(function() {
                $("#search_user").val('');
                $("#search_period").val('');
            })
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
