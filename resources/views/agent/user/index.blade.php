@extends('agent.layouts.master')

@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.account_list')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-users"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.account_list')}}</h1>
                    <small>{{__('words.user_management')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="clearfix">
                        <h5 class="font-weight-bold float-left">
                            @if($agent_id)
                                <span class="text-primary">{{$agent->username}}</span> - 
                            @endif
                            {{__('words.agent_list')}}
                        </h5>
                        @if($agent)
                            <h6 class="float-left ml-4 mt-1"><a href="{{route('agent.user.index')}}?agent_id={{$agent->agent_id}}"><span class="badge badge-primary"><i class="fas fa-arrow-alt-circle-left mr-1"></i>{{__('words.back')}}</span></a></h6>
                        @endisset
                        <form action="" class="form-inline float-right" method="post">
                            @csrf
                            <input type="search" name="agent_keyword" class="form-control form-control-sm mr-2" value="{{$agent_keyword}}" placeholder="{{__('words.search')}}..." />
                            <a href="{{route('agent.report.agent', $_agent->id)}}" class="btn btn-sm btn-info float-right mt-2 mt-md-0 mr-md-2"><i class="fas fa-chart-bar mr-1"></i>{{__('words.total_report')}}</a>
                            <button type="button" class="btn btn-sm btn-primary float-right mt-2 mt-md-0" id="btn-add-agent"><i class="fas fa-user-plus mr-1"></i>{{__('words.add_new')}}</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.username')}}</th>
                                    <th>{{__('words.name')}}</th>
                                    <th>{{__('words.score')}}</th>
                                    <th>{{__('words.phone_number')}}</th>
                                    <th>{{__('words.description')}}</th>
                                    <th style="width:150px">{{__('words.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data_agent as $item)
                                    <tr>
                                        <td>{{ (($data_agent->currentPage() - 1 ) * $data_agent->perPage() ) + $loop->iteration }}</td>
                                        <td class="username" data-value="{{$item->username}}"><a href="{{route('agent.user.index')}}?agent_id={{$item->id}}">{{$item->username}}</a></td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="score">{{$item->score}}</td>
                                        <td class="phone_number">{{$item->phone_number}}</td>
                                        <td class="description">{{$item->description}}</td>
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit-agent" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('words.edit')}}"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('agent.agent.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" data-toggle="tooltip" title="{{__('words.delete')}}"><i class="fas fa-trash-alt"></i></a>
                                            <a href="{{route('agent.set_score', ['agent', $item->id])}}" class="btn btn-sm btn-info btn-icon mr-1" data-toggle="tooltip" title="{{__('words.set_score')}}"><i class="fas fa-coins"></i></a>
                                            <a href="{{route('agent.report.agent', $item->id)}}" class="btn btn-sm btn-secondary btn-icon mr-1" data-toggle="tooltip" title="{{__('words.report')}}"><i class="fas fa-chart-pie"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data_agent->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data_agent->appends(['user' => $data_user->currentPage()])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">              
                <div class="card card-body card-fill">  
                    <div class="clearfix">
                        <h5 class="font-weight-bold float-left">
                            @if($agent_id)
                                <span class="text-primary">{{$agent->username}}</span> - 
                            @endif
                            {{__('words.player_list')}}
                        </h5>
                        <form action="" class="form-inline float-right" method="post">
                            @csrf
                            <input type="search" name="user_keyword" class="form-control form-control-sm mr-2" value="{{$user_keyword}}" placeholder="{{__('words.search')}}..." />
                            <button type="button" class="btn btn-sm btn-primary float-right mt-2 mt-md-0" id="btn-add-user"><i class="fas fa-user-plus mr-1"></i>{{__('words.add_new')}}</button>
                        </form>
                    </div>                    
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.username')}}</th>
                                    <th>{{__('words.name')}}</th>
                                    <th>{{__('words.score')}}</th>
                                    <th>{{__('words.phone_number')}}</th>
                                    <th>{{__('words.description')}}</th>
                                    <th style="width:150px">{{__('words.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data_user as $item)
                                    <tr>
                                        <td>{{ (($data_user->currentPage() - 1 ) * $data_user->perPage() ) + $loop->iteration }}</td>
                                        <td class="username">{{$item->username}}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="score">{{$item->score}}</td>
                                        <td class="phone_number">{{$item->phone_number}}</td>
                                        <td class="description">{{$item->description}}</td>
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit-user" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('words.edit')}}"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('agent.user.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" data-toggle="tooltip" title="{{__('words.delete')}}"><i class="fas fa-trash-alt"></i></a>
                                            <a href="{{route('agent.set_score', ['user', $item->id])}}" class="btn btn-sm btn-info btn-icon mr-1" data-toggle="tooltip" title="{{__('words.set_score')}}"><i class="fas fa-coins"></i></a>
                                            <a href="{{route('agent.report.user', $item->id)}}" class="btn btn-sm btn-secondary btn-icon mr-1" data-toggle="tooltip" title="{{__('words.report')}}"><i class="fas fa-chart-pie"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data_user->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data_user->appends(['agent' => $data_agent->currentPage()])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="addAgentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.add_new_agent')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_agent_form" method="post">
                    @csrf
                    <input type="hidden" name="agent_id" value="{{$agent_id}}" />
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
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="{{__('words.phone_number')}}" />
                            <span class="invalid-feedback phone_number_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">{{__('words.score')}} <span class="text-danger">*</span></label>
                            <input type="number" name="score" min="0" step="0.01" max="{{$_agent->score}}" class="form-control score" placeholder="{{__('words.score')}}">
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
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAgentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.edit_agent')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_agent_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
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
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="{{__('words.phone_number')}}" />
                            <span class="invalid-feedback phone_number_error">
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
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
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
                    <input type="hidden" name="agent_id" value="{{$agent_id}}" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.username')}} <span class="text-danger">*</span></label>
                            <input class="form-control username" type="text" name="username" placeholder="{{__('words.username')}}" required />
                            <span class="invalid-feedback username_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.name')}}</label>
                            <input class="form-control name" type="text" name="name" placeholder="{{__('words.name')}}" />
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.phone_number')}} <span class="text-danger">*</span></label>
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="{{__('words.phone_number')}}" />
                            <span class="invalid-feedback phone_number_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">{{__('words.score')}} <span class="text-danger">*</span></label>
                        <input type="number" name="score" min="0" step="0.01" value="0" max="{{$_agent->score}}" class="form-control score" placeholder="{{__('words.score')}}">
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
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.edit_player')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_user_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
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
                            <input class="form-control phone_number" type="text" name="phone_number" placeholder="{{__('words.phone_number')}}" />
                            <span class="invalid-feedback phone_number_error">
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
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
    
@section('script')
    <script>
        $(document).ready(function () {
            $("#btn-add-agent").click(function(){
                $("#create_agent_form input.form-control").val('');
                $("#create_agent_form .score").val(0);
                $("#create_agent_form .invalid-feedback strong").text('');
                $("#addAgentModal").modal();
            });
    
            $("#create_agent_form .btn-submit").click(function(){    
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('agent.agent.create')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#create_agent_form').serialize(),
                    success : function(response) {
                        $(".page-loader-wrapper").fadeOut();
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
                                $('#create_agent_form .name_error strong').text(messages.name[0]);
                                $('#create_agent_form .name_error').show();
                                $('#create_agent_form .name').focus();
                            }

                            if(messages.score) {
                                $('#create_agent_form .score_error strong').text(messages.score[0]);
                                $('#create_agent_form .score_error').show();
                                $('#create_agent_form .score').focus();
                            }
                            
                            if(messages.username) {
                                $('#create_agent_form .username_error strong').text(messages.username[0]);
                                $('#create_agent_form .username_error').show();
                                $('#create_agent_form .username').focus();
                            }
    
                            if(messages.password) {
                                $('#create_agent_form .password_error strong').text(messages.password[0]);
                                $('#create_agent_form .password_error').show();
                                $('#create_agent_form .password').focus();
                            }
                        }
                    },
                    error: function(response) {  
                        $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', "error")
                        console.log(response)
                    }
                });
            });
    
            $(".btn-edit-agent").click(function(){
                let id = $(this).data("id");
                let username = $(this).parents('tr').find(".username").text().trim();
                let name = $(this).parents('tr').find(".name").text().trim();
                let phone_number = $(this).parents('tr').find(".phone_number").text().trim();
                let description = $(this).parents('tr').find(".description").text().trim();
    
                $("#edit_agent_form .id").val(id);
                $("#edit_agent_form .username").val(username);
                $("#edit_agent_form .name").val(name);
                $("#edit_agent_form .phone_number").val(phone_number);
                $("#edit_agent_form .description").val(description);
    
                $("#editAgentModal").modal();
            });
    
            $("#edit_agent_form .btn-submit").click(function(){
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('agent.agent.edit')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#edit_agent_form').serialize(),
                    success : function(response) {
                        $(".page-loader-wrapper").fadeOut();
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
                                $('#edit_agent_form .name_error strong').text(messages.name[0]);
                                $('#edit_agent_form .name_error').show();
                                $('#edit_agent_form .name').focus();
                            }
                            
                            if(messages.username) {
                                $('#edit_agent_form .username_error strong').text(messages.username[0]);
                                $('#edit_agent_form .username_error').show();
                                $('#edit_agent_form .username').focus();
                            }
    
                            if(messages.password) {
                                $('#edit_agent_form .password_error strong').text(messages.password[0]);
                                $('#edit_agent_form .password_error').show();
                                $('#edit_agent_form .password').focus();
                            }
                        }
                    },
                    error: function(response) {  
                        $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });

            
            $("#btn-add-user").click(function(){
                $("#create_user_form input.form-control").val('');
                $("#create_user_form .score").val(0);
                $("#create_user_form .invalid-feedback strong").text('');
                $("#addUserModal").modal();
            });
    
            $("#create_user_form .btn-submit").click(function(){    
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('agent.user.create')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#create_user_form').serialize(),
                    success : function(response) {
                        $(".page-loader-wrapper").fadeOut();
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
                            
                            if(messages.score) {
                                $('#create_user_form .score_error strong').text(messages.score[0]);
                                $('#create_user_form .score_error').show();
                                $('#create_user_form .score').focus();
                            }
                            
                            if(messages.phone_number) {
                                $('#create_user_form .phone_number_error strong').text(messages.phone_number[0]);
                                $('#create_user_form .phone_number_error').show();
                                $('#create_user_form .phone_number').focus();
                            }
    
                            if(messages.password) {
                                $('#create_user_form .password_error strong').text(messages.password[0]);
                                $('#create_user_form .password_error').show();
                                $('#create_user_form .password').focus();
                            }
                        }
                    },
                    error: function(response) {  
                        $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", "error")
                        console.log(response)
                    }
                });
            });
    
            $(".btn-edit-user").click(function(){
                let id = $(this).data("id");
                let username = $(this).parents('tr').find(".username").text().trim();
                let name = $(this).parents('tr').find(".name").text().trim();
                let phone_number = $(this).parents('tr').find(".phone_number").text().trim();
                let description = $(this).parents('tr').find(".description").text().trim();
    
                $("#edit_user_form .id").val(id);
                $("#edit_user_form .username").val(username);
                $("#edit_user_form .name").val(name);
                $("#edit_user_form .phone_number").val(phone_number);
                $("#edit_user_form .description").val(description);
    
                $("#editUserModal").modal();
            });
    
            $("#edit_user_form .btn-submit").click(function(){
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('agent.user.edit')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: $('#edit_user_form').serialize(),
                    success : function(response) {
                        $(".page-loader-wrapper").fadeOut();
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
                                $('#edit_user_form .name_error strong').text(messages.name[0]);
                                $('#edit_user_form .name_error').show();
                                $('#edit_user_form .name').focus();
                            }
                            
                            if(messages.username) {
                                $('#edit_user_form .username_error strong').text(messages.username[0]);
                                $('#edit_user_form .username_error').show();
                                $('#edit_user_form .username').focus();
                            }
                            
                            if(messages.phone_number) {
                                $('#edit_user_form .phone_number_error strong').text(messages.phone_number[0]);
                                $('#edit_user_form .phone_number_error').show();
                                $('#edit_user_form .phone_number').focus();
                            }
    
                            if(messages.password) {
                                $('#edit_user_form .password_error strong').text(messages.password[0]);
                                $('#edit_user_form .password_error').show();
                                $('#edit_user_form .password').focus();
                            }
                        }
                    },
                    error: function(response) {  
                        $(".page-loader-wrapper").fadeOut();
                        swal("{{__('words.something_went_wrong')}}", '', 'error')
                        console.log(response)
                    }
                });
            });

            $(".btn-credit").click(function(){
                let id = $(this).data('id');
                let role = $(this).data('role');
                $("#credit_form .id").val(id);
                $("#credit_form .role").val(role);
                $("#credit_form .amount").focus();
                $("#creditModal").modal();
            });
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
