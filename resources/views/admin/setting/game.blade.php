@extends('admin.layouts.master')
@section('style')
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item">{{__('words.setting')}}</li>
                <li class="breadcrumb-item active">{{__('words.games')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-gamepad"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.games')}}</h1>
                    <small>{{__('words.games')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.name')}}</th>
                                    <th>{{__('words.title')}}</th>
                                    <th>{{__('words.domain')}}</th>
                                    <th>{{__('words.link_for_android')}}</th>
                                    <th>{{__('words.link_for_iphone')}}</th>
                                    <th>{{__('words.agent')}}</th>
                                    <th>{{__('words.api_key')}}</th>
                                    <th>{{__('words.token')}}</th>
                                    <th>{{__('words.username')}}</th>
                                    <th>{{__('words.password')}}</th>
                                    <th>{{__('words.status')}}</th>
                                    <th>{{__('words.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="title">{{$item->title}}</td>
                                        <td class="domain">{{$item->domain}}</td>
                                        <td class="link_android">{{$item->link_android}}</td>
                                        <td class="link_iphone">{{$item->link_iphone}}</td>
                                        <td class="agent">{{$item->agent}}</td>
                                        <td class="api_key">{{$item->api_key}}</td>
                                        <td class="token">{{$item->token}}</td>
                                        <td class="username">{{$item->username}}</td>
                                        <td class="password">{{$item->password}}</td>
                                        <td class="status" data-id="{{$item->status}}">
                                            @switch($item->status)
                                                @case(1)
                                                    <span class="badge badge-primary">{{__('words.hot')}}</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge badge-primary">{{__('words.maintain')}}</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge badge-primary">{{__('words.coming_soon')}}</span>
                                                    @break
                                                @default   
                                                    <span class="badge badge-primary">{{__('words.hot')}}</span>                                                 
                                            @endswitch
                                        </td>                                    
                                        <td class="py-1">
                                            <a href="javascript:;" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('words.edit')}}"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                 
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>{{__('words.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('words.items')}}</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.edit')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('admin.game.edit')}}" id="edit_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" class="id" />
                    <div class="modal-body row">
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.name')}} <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" readonly placeholder="{{__('words.name')}}" required />
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.title')}} <span class="text-danger">*</span></label>
                            <input class="form-control title" type="text" name="title" placeholder="{{__('words.title')}}" required />
                            <span class="invalid-feedback title_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.domain')}} <span class="text-danger">*</span></label>
                            <input class="form-control domain" type="text" name="domain" placeholder="{{__('words.domain')}}" required />
                            <span class="invalid-feedback domain_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.link_for_android')}}</label>
                            <input class="form-control link_android" type="text" name="link_android" placeholder="{{__('words.link_for_android')}}" />
                            <span class="invalid-feedback link_android_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.link_for_iphone')}}</label>
                            <input class="form-control link_iphone" type="text" name="link_iphone" placeholder="{{__('words.link_for_iphone')}}" />
                            <span class="invalid-feedback link_for_iphone_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.agent')}}</label>
                            <input class="form-control agent" type="text" name="agent" placeholder="{{__('words.agent')}}" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.api_key')}}</label>
                            <input class="form-control api_key" type="text" name="api_key" placeholder="{{__('words.api_key')}}" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.token')}}</label>
                            <input class="form-control token" type="text" name="token" placeholder="{{__('words.token')}}" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.username')}}</label>
                            <input class="form-control username" type="text" name="username" placeholder="{{__('words.username')}}" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.password')}}</label>
                            <input class="form-control password" type="text" name="password" placeholder="{{__('words.password')}}" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.status')}}</label>
                            <select class="form-control status" name="status" required>
                                <option value="" hidden>{{__('words.status')}}</option>
                                <option value="1">{{__('words.hot')}}</option>
                                <option value="2">{{__('words.maintain')}}</option>
                                <option value="3">{{__('words.coming_soon')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">{{__('words.image')}}</label>
                            <div>
                                <input type="file" name="image" id="file-1" class="custom-input-file" accept="image/*" />
                                <label for="file-1">
                                    <i class="fa fa-upload"></i>
                                    <span>Choose a file…</span>
                                </label>
                            </div>
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
    <script>
        $(document).ready(function () {

            $(".btn-edit").click(function(){
                let id = $(this).data('id');
                let name = $(this).parents('tr').find('.name').text().trim();
                let title = $(this).parents('tr').find('.title').text().trim();
                let domain = $(this).parents('tr').find('.domain').text().trim();
                let link_android = $(this).parents('tr').find('.link_android').text().trim();
                let link_iphone = $(this).parents('tr').find('.link_iphone').text().trim();
                let agent = $(this).parents('tr').find('.agent').text().trim();
                let api_key = $(this).parents('tr').find('.api_key').text().trim();
                let token = $(this).parents('tr').find('.token').text().trim();
                let username = $(this).parents('tr').find('.username').text().trim();
                let password = $(this).parents('tr').find('.password').text().trim();
                let status = $(this).parents('tr').find('.status').data('id');
                $("#edit_form input.form-control").val('');
                $("#edit_form .id").val(id);
                $("#edit_form .name").val(name);
                $("#edit_form .title").val(title);
                $("#edit_form .domain").val(domain);
                $("#edit_form .link_android").val(link_android);
                $("#edit_form .link_iphone").val(link_iphone);
                $("#edit_form .agent").val(agent);
                $("#edit_form .api_key").val(api_key);
                $("#edit_form .token").val(token);
                $("#edit_form .username").val(username);
                $("#edit_form .password").val(password);
                $("#edit_form .status").val(status);
                $("#editModal").modal();
            });             
        });
    </script>
@endsection
