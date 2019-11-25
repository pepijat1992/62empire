@extends('wap.layouts.master')
@section('style')
    <style>
        #btn-refresh {
            color: #007bff;
            font-weight: bolder;            
        }
    </style>
@endsection
@section('content')
    <div class="features-home segments-page">
        <div class="container-pd item-list">
            <div class="section-title my-2">
                <h2 class="text-center">{{$game->title}}</h2>
            </div>
            <div class="row">
                <div class="container wrap-card">
                    <div class="b-shadow">
                        <div class="p-3">
                            <img src="{{asset($game->image)}}" class="rounded" width="100%" alt="">
                        </div>                    
                        <div class="card-body px-3 pt-0">
                            <div class="row mb-2">
                                <label class="col-3 text-right pr-0 font-weight-bold pt-1">Game Id :</label>
                                <div class="col-9 input-group">
                                    <input type="text" class="form-control" id="username" value="{{$game_account->username}}" readonly>
                                    <div class="input-group-append">
                                        <button class="input-group-text" data-clipboard-target="#username" id="btn-copy-username"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label class="col-3 text-right pr-0 font-weight-bold pt-1">Pass :</label>
                                <div class="col-9 input-group">
                                    <input type="text" class="form-control" id="password" value="{{$game_account->password}}" readonly>
                                    <div class="input-group-append">
                                        <button class="input-group-text" data-clipboard-target="#password" id="btn-copy-password"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            @php
                                if(mobileType() == 'android'){
                                    $download_link = $game->link_android;
                                    $run_url = $game->android_run;
                                    $btn_id = 'bt_down_apk';
                                } else if (mobileType() == 'iphone') {
                                    $download_link = $game->link_iphone;
                                    $run_url = $game->iphone_run;
                                    $btn_id = 'bt_down_ios64';
                                }else{
                                    $download_link = $game->link_android;
                                    $run_url = $game->android_run;
                                    $btn_id = 'bt_down_apk';
                                }
                            @endphp
                            @if($game->play_type == 'web')
                                <a href="{{route('game.play', $game->id)}}" class="btn btn-success btn-block mt-3" target="_blank">{{__('words.play')}}</a>
                            @else
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <a href="{{$download_link}}" class="btn btn-success btn-block" id="{{$btn_id}}">{{__('words.download')}}</a>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-secondary btn-block" onclick="appStart()" id="btn_play" data-link="{{$download_link}}" data-android="{{$game->android_run}}" data-iphone="{{$game->iphone_run}}">{{__('words.play')}}</button>
                                    </div>
                                </div>
                            @endif
                            <div class="row mt-3">
                                <div class="col-12 clearfix">
                                    <h4 class="float-left text-info mt-2">{{__('words.balance')}} :  <span id="balance">{{$game_account->balance}}</span> <i class="fa fa-refresh" id="btn-refresh"></i></h4>
                                    <button class="btn btn-info bg-light btn-sm p-0 float-right" data-toggle="modal" data-target="#instructionModal"><img src="{{asset('images/icon_instruction.png')}}" height="28" alt=""></button>
                                </div>
                            </div>
                            <div class="row mt-3 mb-1">
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary btn-block" id="btn-deposit">{{__('words.deposit')}}</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-secondary btn-block" id="btn-withdraw">{{__('words.withdraw')}}</button>
                                </div>
                            </div>
                            <div class="row mt-3">
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
            var game_balance =  parseFloat($("#balance").text().trim());
            var user_balance = parseFloat("{{$_user->score}}");
            
            var clipboard = new ClipboardJS('#btn-copy-username');
            var clipboard1 = new ClipboardJS('#btn-copy-password');

            $("#btn-copy-username").trigger('click');

            $("form").submit(function(e){
                e.preventDefault();
            });

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
                            $("#balance").text(response.balance);
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

    @if($game->play_type != 'web')
        <script>

            function appStart(){                
                var android_link = $("#btn_play").data('link');
                var iphone_link = $("#btn_play").data('link');
                var android_run = $("#btn_play").data('android');
                var iphone_run = $("#btn_play").data('iphone');

                var uAgent = navigator.userAgent.toLocaleLowerCase();

                if (uAgent.indexOf("android") != -1)
                    OSName = "android";
                else if (uAgent.indexOf("iphone") != -1 || uAgent.indexOf("ipad") != -1 || uAgent.indexOf("ipod") != -1)
                    OSName = "ios";
                else
                    OSName = "is not mobile";

                if ("ios" == OSName) {
                    location.href = iphone_run;          
                } else if("android" == OSName) {
                    location.href = android_run;
                }
            }
        </script>
    @endif

    {{-- @if($game->name == 'scr2')
        <script type="text/javascript">
            var _apkURL='', _iosURL_64='itms-services://?action=download-manifest&url=', _iosURL_32='itms-services://?action=download-manifest&url=';
        
            $(function() {
                $.ajax({
                    url: "https://m.918kiss.agency/getApp.htm?v=5",
                    type: "GET",
                    dataType: "json",
                    crossDomain: true,
                    xhrFields: {
                        withCredentials: true
                    },
                    headers: {
                        "Accept": "*/*",
                        "Access-Control-Allow-Origin":"*"
                    },
                    success: function(result) {
                        if (result.success) {
                            _apkURL = result.apkURL;
                            _iosURL_32 += result.ios32URL;
                            _iosURL_64 += result.ios64URL;
                            
                            $("#bt_down_apk").click(function() {
                                self.location = _apkURL;
                            });
        
                            $("#bt_down_ios64").click(function() {
                                self.location = _iosURL_64;
                            });
                            
                            $("#bt_down_ios32").click(function() {
                                self.location = _iosURL_32;
                            });	
                        }
                    }
                });                        
            });       
                
        </script>
    @endif --}}
@endsection
