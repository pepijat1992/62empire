@extends('web.layouts.master')
@section('style')    
    {{-- <link href="{{asset('backend/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">  --}}
    <style>
        #btn-change-name {
            color: white;
            cursor: pointer;
        }
        .field {
            color: whitesmoke;
            font-size: 15px;
        }
        .value {
            font-size: 15px;
            font-weight: 600;
        }
        #memo_content {
            background: none;
            border: solid 1px white;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    @include('web.wallet.side')
                </div>
                <div id="main" class="col-md-9 col-lg-10">
                    <div class="dep_det_bx">
                        <hr style="border-top: 2px solid rgb(255, 223, 0); width: 200px;">
                        <div class="row mt-3">
                            <div class="col-12">
                                <ul role="tab" class="nav nav-tabs">
                                    <li class="nav-item"><a data-toggle="tab" href="#myprofile" role="tab" class="nav-link active" aria-selected="true"><h5>{{__('words.my_profile')}}</h5></a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#changepassword" role="tab" class="nav-link" aria-selected="false"><h5>{{__('words.change_password')}}</h5></a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#memo" role="tab" class="nav-link" aria-selected="false"><h5>{{__('words.memo')}}</h5></a></li>
                                </ul>
                                <div class="tab-content pt-5 pl-3 pr-3 pb-5">
                                    <div id="myprofile" role="tabpanel" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-2 field">{{__('words.login_id')}} : </div>
                                            <div class="col-auto value">{{$_user->username}}</div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-2 field">{{__('words.name')}} : </div>
                                            <div class="col-auto value">{{$_user->name}} <span class="ml-4" id="btn-change-name" data-toggle="modal" data-target="#changeNameModal"><i class="fa fa-edit"></i></span></div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-2 field">{{__('words.passcode')}} : </div>
                                            <div class="col-auto value">{{$_user->passcode}} <span class="ml-4" id="btn-change-passcode" data-toggle="modal" data-target="#changePassCodeModal"><i class="fa fa-edit"></i></span></div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-2 field">{{__('words.mobile')}} : </div>
                                            <div class="col-auto value">{{$_user->phone_number}}</div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-2 field">{{__('words.agent')}} : </div>
                                            <div class="col-auto value">{{$_user->agent->username ?? ''}}</div>
                                        </div>
                                    </div>
                                    <div id="changepassword" role="tabpanel" class="tab-pane fade">
                                        <form id="changepassword-form" method="POST" action="">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-3">{{__('words.new_password')}}</label>
                                                <div class="col-auto">
                                                    <input type="password" name="password" class="form-control" placeholder="{{__('words.new_password')}}" required />
                                                    <span class="invalid-feedback password_error" role="alert">
                                                        <strong></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-3">{{__('words.confirm_password')}}</label>
                                                <div class="col-auto">
                                                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{__('words.confirm_password')}}" required />
                                                </div>
                                            </div>
                                            <div class="line my-3"></div>
                                            <div class="offset-3 pl-2">
                                                <button type="reset" class="btn btn-danger mr-3"><i class="fa fa-eraser mr-2"></i>{{__('words.reset')}}</button>
                                                <button type="button" class="btn btn-primary btn-submit"><i class="fa fa-save mr-2"></i>{{__('words.save')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="memo" role="tabpanel" class="tab-pane fade">
                                        <form action="{{route('web.save_memo')}}" method="post">
                                            @csrf
                                            <textarea name="content" id="memo_content" class="form-control" rows="10">{{$_user->memo->content ?? ''}}</textarea>
                                            <button type="submit" class="btn btn-primary btn-block mt-3">{{__('words.save')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeNameModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.change_name')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="" id="change_name_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.name')}} <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" value="{{$_user->name}}" placeholder="{{__('words.name')}}" required />
                            <span class="invalid-feedback name_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit" onclick="show_loading()"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePassCodeModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.change_passcode')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="" id="change_passcode_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.passcode')}} <span class="text-danger">*</span></label>
                            <input class="form-control passcode" type="number" name="passcode" value="{{$_user->passcode}}" placeholder="{{__('words.passcode')}}" required />
                            <span class="invalid-feedback passcode_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit" onclick="show_loading()"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    {{-- <script src="{{asset('backend/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('backend/plugins/summernote/summernote-bs4.min.js')}}"></script> --}}
    <script>
        $(document).ready(function(){
            $("#changepassword-form .btn-submit").click(function () {  
                show_loading()              ;
                $.ajax({
                    url: "{{route('wap.change_password')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#changepassword-form').serialize(),
                    success : function(response) {
                        hide_loading();
                        if(response.status.msg == 'success') {
                            swal({
                                title: response.data,
                                type: "success",
                                confirmButtonColor: "#007BFF",
                                confirmButtonText: "OK",
                            },
                            function(){
                                window.location.reload();
                            });                            
                        }
                        else if(response.status.msg == 'error') {
                            let messages = response.data;
                            if(messages.old_password) {
                                $('#changepassword-form .old_password_error strong').text(messages.old_password[0]);
                                $('#changepassword-form .old_password_error').show();
                                $('#changepassword-form .old_password').focus();
                            }
    
                            if(messages.password) {
                                $('#changepassword-form .password_error strong').text(messages.password[0]);
                                $('#changepassword-form .password_error').show();
                                $('#changepassword-form .password').focus();
                            }

                            if(messages.error) {
                                swal(messages.error, '', 'error');
                            }
                        }
                    },
                    error: function(response) {
                        hide_loading();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });

            $("#change_name_form .btn-submit").click(function () {                
                $.ajax({
                    url: "{{route('wap.change_name')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#change_name_form').serialize(),
                    success : function(response) {
                        show_loading();
                        if(response.status.msg == 'success') {
                            swal({
                                title: response.data,
                                type: "success",
                                confirmButtonColor: "#007BFF",
                                confirmButtonText: "OK",
                            },
                            function(){
                                window.location.reload();
                            });                            
                        }
                        else if(response.status.msg == 'error') {
                            let messages = response.data;
                            if(messages.name) {
                                $('#change_name_form .name_error strong').text(messages.name[0]);
                                $('#change_name_form .name_error').show();
                                $('#change_name_form .name').focus();
                            }
    
                            if(messages.name) {
                                $('#change_name_form .name_error strong').text(messages.name[0]);
                                $('#change_name_form .name_error').show();
                                $('#change_name_form .name').focus();
                            }

                            if(messages.error) {
                                swal(messages.error, '', 'error');
                            }
                        }
                    },
                    error: function(response) {  
                        hide_loading();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                    }
                });
            });            
            
            $("#change_passcode_form .btn-submit").click(function () {                
                $.ajax({
                    url: "{{route('wap.change_passcode')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#change_passcode_form').serialize(),
                    success : function(response) {
                        hide_loading()
                        if(response.status.msg == 'success') {
                            swal({
                                title: response.data,
                                type: "success",
                                confirmButtonColor: "#007BFF",
                                confirmButtonText: "OK",
                            },
                            function(){
                                window.location.reload();
                            });                            
                        }
                        else if(response.status.msg == 'error') {
                            let messages = response.data;
                            if(messages.passcode) {
                                $('#change_passcode_form .passcode_error strong').text(messages.passcode[0]);
                                $('#change_passcode_form .passcode_error').show();
                                $('#change_passcode_form .passcode').focus();
                            }

                            if(messages.error) {
                                swal(messages.error, '', 'error');
                            }
                        }
                    },
                    error: function(response) {  
                        hide_loading()
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                    }
                });
            });

            // $("#memo_content").summernote();
        });
    </script>
@endsection