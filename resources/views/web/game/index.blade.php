@extends('web.layouts.master')
@section('style')
    <style>
        #btn-refresh {
            color: #007bff;
            font-weight: bolder;            
        }
    </style>
    @php
        if($game->type == "online_casino"){
            config(['site.page' => 'casino']);
        } elseif ($game->type == 'hot_game'){
            config(['site.page' => 'hot_game']);
        } elseif ($game->type == 'lottery'){
            config(['site.page' => 'lottery']);
        }
    @endphp
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">
                <div id="main" class="col-md-9 col-lg-8">
                    <div class="dep_det_bx">
                        <div class="row">
                            <div class="col-md-4 d-none d-sm-flex">
                                <img src="{{asset($game->image1)}}" class="rounded-lg border border-light" alt="">
                            </div>
                            <div class="col-md-8">
                                <h4>{{$game->title}}</h4>
                                <hr class="ml-0" style="border-top: 2px solid rgb(255, 223, 0); width: 150px;">
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <label class="text-right pr-0 font-weight-bold pt-1">{{__('words.login_id')}} :</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="username" value="{{$game_account->username}}" readonly>
                                            <div class="input-group-append">
                                                <button class="input-group-text ml-0" data-clipboard-target="#username" id="btn-copy-username"><i class="fa fa-copy"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                
                                        <label class="text-right pr-0 font-weight-bold pt-1">{{__('words.password')}} :</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="password" value="{{$game_account->password}}" readonly>
                                            <div class="input-group-append">
                                                <button class="input-group-text ml-0" data-clipboard-target="#password" id="btn-copy-password"><i class="fa fa-copy"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>                        
                                @php
                                    if(mobileType() == 'android'){
                                        $download_link = $game->link_android;
                                        $btn_id = 'bt_down_apk';
                                    } else if (mobileType() == 'iphone') {
                                        $download_link = $game->link_iphone;
                                        $btn_id = 'bt_down_ios64';
                                    }else{
                                        $download_link = $game->link_android;
                                        $btn_id = 'bt_down_apk';
                                    }
                                @endphp
                                @if($game->play_type == 'web')
                                    <a href="{{route('game.play', $game->id)}}" class="btn btn-success btn-block mt-3" target="_blank">{{__('words.play')}}</a>
                                @else
                                    <a href="{{$download_link}}" class="btn btn-success btn-block mt-3" id="{{$btn_id}}">{{__('words.download')}}</a>
                                @endif
                                
                                <div class="row mt-3">
                                    <div class="col-12 clearfix">
                                        <h5 class="float-left text-info mt-2">{{__('words.balance')}} :  <span id="balance">{{$game_account->balance}}</span> <i class="fa fa-refresh" id="btn-refresh"></i></h5>
                                        <button class="btn btn-info bg-light btn-sm p-0 float-right" data-toggle="modal" data-target="#instructionModal"><img src="{{asset('images/icon_instruction.png')}}" height="28" alt=""></button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary btn-block" id="btn-deposit">{{__('words.deposit')}}</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-secondary btn-block" id="btn-withdraw">{{__('words.withdraw')}}</button>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-12">
                                        <a href="{{route('game.transaction_history', $game->id)}}" class="btn btn-info btn-block">{{__('words.view_history')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <input type="hidden" name="id" value="{{$game->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.amount')}} <span class="text-danger">*</span></label> <span class="float-right">Max: <span class="badge badge-danger ml-1">{{$_user->score}}</span></span>
                            <input class="form-control amount" type="number" min="0" max="{{$_user->score}}" name="amount" placeholder="{{__('words.amount')}}" required />
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
                    <input type="hidden" name="id" value="{{$game->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.amount')}} <span class="text-danger">*</span></label> <span class="float-right">Max: <span class="badge badge-danger ml-1" id="withdraw_max"></span></span>
                            <input class="form-control amount" type="number" min="0" name="amount" placeholder="{{__('words.amount')}}" required />
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

    <div class="modal fade" id="instructionModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.instruction')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">                    
                    <div class="p-4">
                        <p>
                            Player Id will be needed to copy and paste into the game.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            var game_balance =  parseFloat($("#game_balance").text().trim());
            var user_balance = parseFloat("{{$_user->score}}");
            
            var clipboard = new ClipboardJS('#btn-copy-username');
            var clipboard1 = new ClipboardJS('#btn-copy-password');

            $("form").submit(function(e){
                e.preventDefault();
            });

            $("#btn-deposit").click(function(){
                $("#depositModal").modal();
            });
            
            $("#btn-withdraw").click(function(){
                let withdraw_max = parseFloat($("#game_balance").text().trim());
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
                let withdraw_max = parseFloat($("#game_balance").text().trim());
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