@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/imageviewer/css/jquery.verySimpleImageViewer.css')}}">
    <style>
        #image_preview {
            max-width: 600px;
            height: 600px;
        }
        .image_viewer_inner_container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item">{{__('words.setting')}}</li>
                <li class="breadcrumb-item active">{{__('words.bank')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-money-check-alt"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.bank')}}</h1>
                    <small>{{__('words.system_banks')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="clearfix">
                        <button type="button" class="btn btn-sm btn-primary float-right mt-2 mt-md-0" id="btn-add"><i class="fas fa-plus mr-1"></i>{{__('words.add_new')}}</button>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>{{__('words.name')}}</th>
                                    <th>{{__('words.image')}}</th>
                                    <th>{{__('words.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="image">
                                            @if (file_exists($item->image))
                                                <img class="btn-image border rounded" src="{{asset($item->image)}}" width="60" height="40" data-path="{{asset($item->image)}}" style="cursor:pointer" />
                                            @else
                                                <img src="{{asset('images/no-image.png')}}" width="60" height="40" alt="" class="btn-image">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('words.edit')}}"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('admin.bank.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" data-toggle="tooltip" title="{{__('words.delete')}}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="modal fade" id="attachModal">
        <div class="modal-dialog" style="margin-top:17vh">
            <div class="modal-content">
                <div id="image_preview"></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.add_new')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('admin.bank.create')}}" id="create_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.name')}} <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" placeholder="{{__('words.name')}}" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.image')}} <span class="text-danger">*</span></label>
                            <input class="file-input-styled" type="file" name="image" accept="image/*" />
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

    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('words.edit')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('admin.bank.edit')}}" id="edit_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" class="id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('words.name')}} <span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" placeholder="{{__('words.name')}}" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('words.image')}} <span class="text-danger">*</span></label>
                            <input class="file-input-styled" type="file" name="image" accept="image/*" />
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
    <script src="{{asset('backend/plugins/imageviewer/js/jquery.verySimpleImageViewer.min.js')}}"></script>
    <script src="{{asset('backend/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script src="{{asset('backend/plugins/styling/uniform.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('.file-input-styled').uniform({
                fileButtonClass: 'btn bg-primary text-white'
            });           
            
            $(".btn-image").click(function(e){
                let path = $(this).data('path');
                $("#image_preview").html('')
                $("#image_preview").verySimpleImageViewer({
                    imageSource: path,
                    frame: ['100%', '100%'],
                    maxZoom: '900%',
                    zoomFactor: '10%',
                    mouse: true,
                    keyboard: true,
                    toolbar: true,
                });
                $("#attachModal").modal();
            });

            $("#btn-add").click(function(){
                $("#create_form .form-control").val('');
                $("#addModal").modal();
            });

            $(".btn-edit").click(function(){
                let id = $(this).data('id');
                let name = $(this).parents('tr').find('.name').text().trim();
                $("#edit_form input.form-control").val('');
                $("#edit_form .id").val(id);
                $("#edit_form .name").val(name);
                $("#editModal").modal();
            });

            $("#btn-reset").click(function() {
                $("#search_user").val('');
                $("#search_period").val('');
            })
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
