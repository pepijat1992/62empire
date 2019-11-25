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
                            <input type="text" name="player" class="form-control form-control-sm mr-2" value="{{$player}}" id="search_player" placeholder="{{__('words.player')}}" />
                            <input type="text" name="account" class="form-control form-control-sm mr-2" value="{{$account}}" id="search_username" placeholder="{{__('words.username')}}" />
                            {{-- <input type="text" name="period" class="form-control form-control-sm mr-2" value="{{$period}}" style="min-width: 200px;" id="search_period" autocomplete="off" placeholder="{{__('words.created_at')}}" /> --}}
                            <button type="submit" class="btn btn-sm btn-primary float-right mt-2 mt-md-0 mr-2"><i class="fas fa-search mr-1"></i>{{__('words.search')}}</button>
                            <button type="button" class="btn btn-sm btn-secondary float-right mt-2 mt-md-0" id="btn-reset"><i class="fas fa-eraser mr-1"></i>{{__('words.reset')}}</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-2">
                        <div class="card card-body shadow-none py-1 border-top border-bottom rounded-0">
                            <div class="row text-dark font-weight-bold">
                                <div class="col-3 p-2">{{__('words.player_id')}}</div>
                                <div class="col-3 p-2">{{__('words.username')}}</div>
                                <div class="col-3 p-2">{{__('words.password')}}</div>
                                <div class="col-3 p-2">{{__('words.balance')}}</div>
                            </div>
                        </div>
                        <div id="accordion" class="mt-2">
                            @foreach ($data as $item)
                                <div class="card border shadow-none mt-1">
                                    <div class="card-header py-2">
                                        <a class="card-link font-weight-bold" data-toggle="collapse" href="#user_account{{$item->id}}">{{$item->username}}</a>
                                    </div>
                                    <div id="user_account{{$item->id}}" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            @php
                                                $user_games = $item->games()->orderBy('game_id')->get();

                                            @endphp
                                            @foreach ($user_games as $item1)
                                                <div class="row mb-2">
                                                    <div class="col-3 pl-4">{{$item1->game->title ?? ''}}</div>
                                                    <div class="col-3">{{$item1->username}}</div>
                                                    <div class="col-3">{{$item1->password}}</div>
                                                    <div class="col-3">{{$item1->balance}}</div>
                                                </div>                                                
                                            @endforeach
                                        </div>
                                    </div>                                    
                                </div>
                            @endforeach
                        </div>                                        
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends(['player' => $player, 'account' => $account])->links() !!}
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

            // $("#search_period").dateRangePicker();

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
