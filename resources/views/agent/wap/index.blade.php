@extends('wap.layouts.master')
@section('style')
    <style>
        #playerTable .player {
            text-align: center;
        }
        #playerTable .username {
            line-height: 2.5;
        }
    </style>
@endsection
@section('content')
    <div class="features-home segments-page">
        <div class="container-pd item-list">
            <div class="section-title mt-4 clearfix">
                <h2 class="float-left text-primary">{{$_agent->username}}</h2>
            <h4 class="float-right mt-2">{{__('words.balance')}} : <span class="badge badge-success">{{$_agent->score}}</span></h4>
            </div>
            <div class="row my-3">
                <div class="col-6">
                    <button class="btn btn-sm btn-primary btn-block" id="btn-add-user">{{__('words.add_player')}}</button>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-info btn-block">{{__('words.total_report')}}</button>
                </div>
            </div>
            <form action="" class="" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="search" class="form-control" name="username" value="{{$username}}" placeholder="{{__('words.search')}}">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>               
            </form>
            <div class="card">
                <div class="card-body table-responsive p-2">              
                    <table class="table" id="playerTable">
                        <thead>
                            <tr>
                                <th>{{__('words.username')}}</th>
                                <th>{{__('words.balance')}}</th>
                                <th>{{__('words.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr class="border-none">
                                    <td class="py-1 username">{{$item->username}}</td>
                                    <td class="py-1 username">{{$item->score}}</td>
                                    <td class="py-1">
                                        <a href="#" class="btn btn-sm btn-primary btn-credit" data-id="{{$item->id}}" data-score="{{$item->score}}" data-link="{{route('agent.wap.set_player', $item->id)}}">Set</a>
                                        <a href="{{route('agent.wap.player_transfer', $item->id)}}" class="btn btn-sm btn-info btn-history">Transfer</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" align="center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> 
                <div class="clearfix mt-2">
                    <div class="text-center">
                        {!! $data->appends(['username' => $username])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.add_new_player')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_user_form" method="post">
                    @csrf
                    <input type="hidden" name="agent_id" value="{{$_agent->id}}" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.username')}} <span class="text-danger">*</span></label>
                            <input class="form-control username" type="text" name="username" placeholder="{{__('words.username')}}" required />
                            <span class="invalid-feedback username_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.name')}} <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" placeholder="{{__('words.name')}}" />
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.phone_number')}}</label>
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="+60**********" />
                            <span class="invalid-feedback phone_number_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">{{__('words.score')}} <span class="text-danger">*</span></label>
                            <input type="number" name="score" min="0" max="{{$_agent->score}}" step="0.01" class="form-control score" placeholder="{{__('words.score')}}">
                            <span class="invalid-feedback score_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.password')}} <span class="text-danger">*</span></label>
                            <input class="form-control password" type="password" name="password" placeholder="{{__('words.password')}}" required />
                            <span class="invalid-feedback password_error">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">{{__('words.confirm_password')}} <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control confirm_password" placeholder="{{__('words.confirm_password')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.description')}}</label>
                            <textarea class="form-control description" name="description" placeholder="{{__('words.description')}}"></textarea>
                            <span class="invalid-feedback description_error">
                                <strong></strong>
                            </span>
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
    <div class="modal fade" id="creditModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">{{__('words.set_score')}}</h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form method="POST" action="{{route('agent.save_score')}}" id="credit_form">
                    @csrf
                    <input type="hidden" name="id" class="id" />
                    <input type="hidden" name="role" class="role" />
                    <div class="modal-body">
                        <div class="form-group">
                        <label class="control-label">{{__('words.amount')}}</label>&nbsp; <a href="" class="btn-sm btn-link ml-5" id="btn-set-history">{{__('words.history')}}</a> <h6 class="float-right">{{__('words.current_balance')}} : <span class="badge badge-success current-balance"></span></h6>
                            <input class="form-control amount" type="number" name="amount" step="0.01" max="{{floor($_agent->score)}}" placeholder="{{__('words.amount')}}" required />                           
                        </div>
                    </div>   
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.ok')}}</button>
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
            $("#btn-add-user").click(function(){
                $("#create_user_form input.form-control").val('');
                $("#create_user_form .invalid-feedback strong").text('');
                $("#addUserModal").modal();
            });
    
            $("#create_user_form .btn-submit").click(function(){    
                $("#ajax-loading").fadeIn();
                $.ajax({
                    url: "{{route('agent.user.create')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#create_user_form').serialize(),
                    success : function(response) {
                        $("#ajax-loading").fadeOut();
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
                                $('#create_user_form .name_error strong').text(messages.name[0]);
                                $('#create_user_form .name_error').show();
                                $('#create_user_form .name').focus();
                            }
                            
                            if(messages.username) {
                                $('#create_user_form .username_error strong').text(messages.username[0]);
                                $('#create_user_form .username_error').show();
                                $('#create_user_form .username').focus();
                            }
                            
                            if(messages.phone_number) {
                                $('#create_user_form .phone_number_error strong').text(messages.phone_number[0]);
                                $('#create_user_form .phone_number_error').show();
                                $('#create_user_form .phone_number').focus();
                            }
                            
                            if(messages.score) {
                                $('#create_user_form .score_error strong').text(messages.score[0]);
                                $('#create_user_form .score_error').show();
                                $('#create_user_form .score').focus();
                            }
    
                            if(messages.password) {
                                $('#create_user_form .password_error strong').text(messages.password[0]);
                                $('#create_user_form .password_error').show();
                                $('#create_user_form .password').focus();
                            }
                        }
                    },
                    error: function(response) {  
                        $("#ajax-loading").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', "error")
                        console.log(response)
                    }
                });
            });

            $(".btn-credit").click(function(){
                let id = $(this).data('id');
                let score = parseFloat($(this).data('score'));
                let history_link = $(this).data('link');
                $("#credit_form .id").val(id);
                $("#credit_form .role").val('user');
                $("#credit_form .amount").attr('min', -1*score);
                $("#credit_form .current-balance").text(score);
                $("#credit_form #btn-set-history").attr('href', history_link);
                $("#credit_form .amount").focus();
                $("#creditModal").modal();
            });
        });
    </script>
@endsection
