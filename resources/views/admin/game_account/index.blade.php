@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">    
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.game_accounts')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-user-secret"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.game_account')}}</h1>
                    <small>{{__('words.game_account_management')}}</small>
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
                            <select class="form-control form-control-sm mr-md-2" name="game_id" id="search_game">
                                <option value="" hidden>{{__('words.game')}}</option>
                                @foreach ($games as $item)
                                    <option value="{{$item->id}}" @if($game_id == $item->id) selected @endif>{{$item->title}}</option>
                                @endforeach                                
                            </select>
                            <input type="text" name="player" class="form-control form-control-sm mr-2" value="{{$player}}" id="search_player" placeholder="{{__('words.player')}}" />
                            <input type="text" name="username" class="form-control form-control-sm mr-2" value="{{$username}}" id="search_username" placeholder="{{__('words.username')}}" />
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
                                    <th>{{__('words.game')}}</th>
                                    <th>{{__('words.player')}}</th>
                                    <th>{{__('words.username')}}</th>
                                    <th>{{__('words.password')}}</th>
                                    <th>{{__('words.balance')}}</th>
                                    <th>{{__('words.created_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="game">{{$item->game->title ?? ''}}</td>
                                        <td class="user">{{$item->user->username ?? ''}}</td>
                                        <td class="username">{{$item->username}}</td>
                                        <td class="password">{{$item->password}}</td>
                                        <td class="balance">{{$item->balance}}</td>
                                        <td class="created_at">{{$item->created_at}}</td>
                                    </tr>
                                @endforeach
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
                $("#search_game").val('');
                $("#search_player").val('');
                $("#search_username").val('');
                $("#search_period").val('');
            })
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
