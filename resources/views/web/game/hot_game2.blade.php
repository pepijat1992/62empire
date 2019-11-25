@extends('web.layouts.master')
@section('style')
    <style>
        #btn-refresh {
            color: #007bff;
            font-weight: bolder;            
        }
        .input-group input {
            border-top: solid 1px #ebebeb;
            border-bottom: solid 1px #ebebeb;
        }
        .input-group input:focus {
            outline: none;
        }
        .input-group-prepend span {
            font-size: 22px;
            padding-top: 3px;
            padding-left: 5px;
            color: #444;
            background-color: #ebebeb;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
    </style>
    @php
        config(['site.page' => 'hot_game']);
    @endphp
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">
                @php
					$hot_games = \App\Models\Game::where('type', 'hot_game')->get()
				@endphp
                @foreach ($hot_games as $game)                        
                    @auth
                        @php
                            $game_account = \App\Models\GameUser::where('game_id', $game->id)->where('user_id', $_user->id)->first();
                        @endphp
                        @if($game_account)
                        <div class="col-sm-6 col-md-4 mb-3">                       
                            <div class="dep_det_bx">
                                <img src="{{asset($game->image)}}" alt="">
                                <div class="mt-2">
                                    <div class="input-group game-username">
                                        <div class="input-group-prepend"><span><i class="fa fa-user-secret"></i></span></div>
                                        <input type="text" class="form-control" id="username{{$game->id}}" value="{{$game_account->username}}" readonly>
                                        <div class="input-group-append">
                                            <button class="input-group-text ml-0" data-clipboard-target="#username{{$game->id}}" id="btn-copy-username"><i class="fa fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group mt-2 game-password">
                                        <div class="input-group-prepend"><span><i class="fa fa-lock ml-1"></i></span></div>
                                        <input type="text" class="form-control" id="password{{$game->id}}" value="{{$game_account->password}}" readonly>
                                        <div class="input-group-append">
                                            <button class="input-group-text ml-0" data-clipboard-target="#password{{$game->id}}" id="btn-copy-password"><i class="fa fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group mt-2 game-password">
                                        <div class="input-group-prepend"><span><i class="fa fa-star-o"></i></span></div>
                                        <input type="text" class="form-control" id="balance{{$game->id}}" value="{{$game_account->balance}}" readonly>
                                        <div class="input-group-append">
                                            <button class="input-group-text ml-0 btn-balance-refresh">&nbsp;<i class="fa fa-refresh"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 clearfix">
                                    <div class="w-50 float-left pr-2">
                                        <button class="btn btn-block btn-primary">{{__('words.deposit')}}</button>
                                    </div>
                                    <div class="w-50 float-right pl-2">
                                        <button class="btn btn-block btn-success">{{__('words.withdraw')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endauth
                @endforeach
            </div>
        </div>
    </div>    

    <div class="modal fade" id="depositModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.deposit')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="" id="deposit_form">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.amount')}} <span class="text-danger">*</span></label> <span class="float-right">Max: <span class="badge badge-danger ml-1">{{$_user->score}}</span></span>
                            <input class="form-control amount" type="number" name="amount" placeholder="{{__('words.amount')}}" required />
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.ok')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="withdrawModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.withdraw')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="" id="withdraw_form">
                    @csrf
                    <input type="hidden" name="id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.amount')}} <span class="text-danger">*</span></label> <span class="float-right">Max: <span class="badge badge-danger ml-1" id="withdraw_max"></span></span>
                            <input class="form-control amount" type="number" name="amount" placeholder="{{__('words.amount')}}" />
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.ok')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            var game_balance =  parseFloat($("#balance").text().trim());
            var user_balance = parseFloat("{{$_user->score}}");
            
            var clipboard = new ClipboardJS('#btn-copy-username');
            var clipboard1 = new ClipboardJS('#btn-copy-password');

            $("#btn-deposit").click(function(){

                $("#depositModal").modal();
            });
            
            $("#btn-withdraw").click(function(){
                let withdraw_max = parseFloat($("#balance").text().trim());
                $("#withdraw_max").text(withdraw_max);
                $("#withdrawModal").modal();
            });

            $("#deposit_form .btn-submit").click(function(){
                let amount =  parseFloat($("#deposit_form .amount").val());
                if(amount > user_balance) {
                    swal("{{__('error.insufficient_balance')}}", '', 'error');
                    return false;
                }
                show_loading();
                $.ajax({
                    url: "{{route('game.deposit')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#deposit_form').serialize(),
                    success : function(response) {
                        if(response == 'success') {
                            swal({
                                title: "{{ __('words.successfully_set') }}",
                                type: "success",
                                confirmButtonColor: "#007BFF",
                                confirmButtonText: "OK",
                            },
                            function(){
                                window.location.reload();
                            });                            
                        } else if (response == 'insufficient_balance') {
                            hide_loading();
                            swal("{{__('error.insufficient_balance')}}", '', 'error');
                        } else {
                            hide_loading();
                            swal("{{__('error.something_went_wrong')}}", '', 'error');
                        }
                    },
                    error: function(response) {  
                        hide_loading();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });

            $("#withdraw_form .btn-submit").click(function(){  
                let amount =  parseFloat($("#withdraw_form .amount").val());
                let withdraw_max = parseFloat($("#balance").text().trim());
                if(amount > withdraw_max) {
                    swal("{{__('error.insufficient_balance')}}", '', 'error');
                    return false;
                }
                show_loading();
                $.ajax({
                    url: "{{route('game.withdraw')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#withdraw_form').serialize(),
                    success : function(response) {
                        if(response == 'success') {
                            swal({
                                title: "{{ __('words.successfully_set') }}",
                                type: "success",
                                confirmButtonColor: "#007BFF",
                                confirmButtonText: "OK",
                            },
                            function(){
                                window.location.reload();
                            });                            
                        } else if (response == 'insufficient_balance') {
                            hide_loading();
                            swal("{{__('error.insufficient_balance')}}", '', 'error');
                        } else {
                            hide_loading();
                            swal("{{__('error.something_went_wrong')}}", '', 'error');
                        }
                    },
                    error: function(response) {  
                        hide_loading();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });

            $("#btn-refresh").click(function () {
                if($(this).hasClass('rotate')) return false;
                $(this).addClass('rotate');
                var self = $(this);
                show_loading();
                $.ajax({
                    url: "{{route('game.balance_refresh')}}",
                    method: 'POST',
                    data: {id: "{{$game->id}}"},
                    dataType: 'json',
                    success: function (response) {
                        self.removeClass('rotate');
                        hide_loading();
                        if(response.status == 'success') {
                            $("#game_balance").text(response.balance);
                        } else {
                            swal("{{__('error.something_went_wrong')}}", '', 'error');
                        }
                    },
                    error: function (error) {
                        self.removeClass('rotate');
                        hide_loading();
                        swal("{{__('error.something_went_wrong')}}", '', 'error');
                    }
                })
            })
        });
    </script>
@endsection