@extends('wap.layouts.master')
@section('style')
    <style>
        .field {
            font-size: 14px;
        }
        .value {
            font-weight: 600;
        }
    </style>
@endsection
@section('content')
<div class="features-home segments-page setting-page">
    <div class="container-pd item-list">
        <div class="section-title mt-4">
            <h2 class="text-center">{{__('words.setting')}}</h2>
        </div>
        <div class="row">
            <div class="col-12 px-2">
                
                <div class="content b-shadow">
                    <div class="row">
                        <div class="col-4 text-right field">{{__('words.login_id')}} : </div>
                        <div class="col-8 value">{{$_user->username}}</div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4 text-right field">{{__('words.name')}} : </div>
                        <div class="col-8 value">{{$_user->name}}</div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4 text-right field">{{__('words.mobile')}} : </div>
                        <div class="col-8 value">{{$_user->phone_number}}</div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4 text-right field">{{__('words.agent')}} : </div>
                        <div class="col-8 value">{{$_user->agent->username ?? ''}}</div>
                    </div>
                </div>
                <div class="content b-shadow mt-4">
                    <h5><a href="javascript:;" class="d-block" id="btn-change-password" data-toggle="modal" data-target="#changePasswordModal"><span class="content-icon"><i class="fa fa-cog"></i></span>&nbsp;&nbsp;{{__('words.change_password')}}</a></h5>
                </div>
                <div class="content b-shadow mt-2">
                    <h5><a href="javascript:;" class="d-block" id="btn-change-name" data-toggle="modal" data-target="#changeNameModal"><span class="content-icon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;{{__('words.change_name')}}</a></h5>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="changePasswordModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">{{__('words.change_password')}}</h5>
                <button class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form method="POST" action="" id="change_password_form">
                @csrf
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label class="control-label">{{__('words.old_password')}} <span class="text-danger">*</span></label>
                        <input class="form-control old_password" type="password" name="old_password" placeholder="{{__('words.old_password')}}" required />                        
                        <span class="invalid-feedback old_password_error" role="alert">
                            <strong></strong>
                        </span>
                    </div> --}}
                    <div class="form-group">
                        <label class="control-label">{{__('words.new_password')}} <span class="text-danger">*</span></label>
                        <input class="form-control password" type="password" name="password" placeholder="{{__('words.new_password')}}" required />
                        <span class="invalid-feedback password_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{__('words.confirm_password')}} <span class="text-danger">*</span></label>
                        <input class="form-control password_confirmation" type="password" name="password_confirmation" placeholder="{{__('words.confirm_password')}}" required />
                    </div>
                </div>   
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-submit"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                </div>
            </form>
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
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#change_password_form .btn-submit").click(function () {                
                $.ajax({
                    url: "{{route('wap.change_password')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#change_password_form').serialize(),
                    success : function(response) {
                        // $(".page-loader-wrapper").fadeOut();
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
                                $('#change_password_form .old_password_error strong').text(messages.old_password[0]);
                                $('#change_password_form .old_password_error').show();
                                $('#change_password_form .old_password').focus();
                            }
    
                            if(messages.password) {
                                $('#change_password_form .password_error strong').text(messages.password[0]);
                                $('#change_password_form .password_error').show();
                                $('#change_password_form .password').focus();
                            }

                            if(messages.error) {
                                swal(messages.error, '', 'error');
                            }
                        }
                    },
                    error: function(response) {  
                        // $(".page-loader-wrapper").fadeOut();
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
                        // $(".page-loader-wrapper").fadeOut();
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
                        // $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });
        });
    </script>
@endsection
