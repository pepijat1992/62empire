@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">    
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.free_bonus')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-gift"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.free_bonus')}}</h1>
                    <small>{{__('words.free_bonus_history')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            @php
                $bonus_msg = session()->get("bonus");
            @endphp
            @if($bonus_msg != '')
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{$bonus_msg}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="clearfix">
                        <form action="" class="form-inline float-left" method="post" id="searchForm">
                            @csrf
                            <input type="text" name="player" class="form-control form-control-sm mr-2" value="{{$player}}" id="search_player" placeholder="{{__('words.player')}}" />                            
                            <input type="text" name="period" class="form-control form-control-sm mr-2" value="{{$period}}" style="min-width: 200px;" id="search_period" autocomplete="off" placeholder="{{__('words.created_at')}}" />
                            <button type="submit" class="btn btn-sm btn-primary float-right mt-2 mt-md-0 mr-2"><i class="fas fa-search mr-1"></i>{{__('words.search')}}</button>
                            <button type="button" class="btn btn-sm btn-secondary float-right mt-2 mt-md-0" id="btn-reset"><i class="fas fa-eraser mr-1"></i>{{__('words.reset')}}</button>
                        </form>
                        <button type="button" class="btn btn-lg btn-warning font-weight-bold float-right" id="give_bonus"><i class="fas fa-gift mr-2"></i>{{__('words.give_bonus')}}</button>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.player')}}</th>
                                    <th>{{__('words.amount')}}</th>
                                    <th>{{__('words.date_time')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="type">{{$item->user->username ?? ''}}</td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="created_at">{{$item->created_at}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" align="center">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends(['player' => $player, 'period' => $period])->links() !!}
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="modal fade" id="bonusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.give_bonus')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('admin.set_bonus')}}" id="bonus_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.amount')}} <span class="text-danger">*</span></label>
                            <input class="form-control amount" id="form_amount" type="number" name="amount" min="0" placeholder="{{__('words.amount')}}" required />
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
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

            $("#give_bonus").click(function () {
                $("#form_amount").focus();
                $("#bonusModal").modal();
            })
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
