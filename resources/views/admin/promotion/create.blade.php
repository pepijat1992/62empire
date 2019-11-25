@extends('admin.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}">  
    <link rel="stylesheet" href="{{asset('backend/plugins/jquery-ui-1.12.1/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/jquery-ui-1.12.1/timepicker/jquery-ui-timepicker-addon.min.css')}}"> 
    <link href="{{asset('backend/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet"> 
@endsection
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{route('promotion.index')}}">{{__('words.promotion')}}</a></li>
                <li class="breadcrumb-item active">{{__('words.create_promotion')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-gift"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.promotion')}}</h1>
                    <small>{{__('words.create_promotion')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3 p-md-5">
                    <div class="card-body p-md-5 border rounded">
                        <form action="{{route('promotion.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.title')}}</label></div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" placeholder="{{__('words.title')}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.start_date')}}</label></div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control datepicker" name="start_at" autocomplete="off" placeholder="{{__('words.start_date')}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.end_date')}}</label></div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control datepicker" name="end_at" autocomplete="off" placeholder="{{__('words.end_date')}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.rate')}}</label></div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" step="0.1" name="rate" placeholder="{{__('words.rate')}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.amount')}}</label></div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="amount" placeholder="{{__('words.amount')}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.image_for_english')}}</label></div>
                                <div class="col-md-9">
                                    <div>
                                        <input type="file" name="image_en" id="file-1" class="custom-input-file" accept="image/*" />
                                        <label for="file-1">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('words.choose_file')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.image_for_malaysia')}}</label></div>
                                <div class="col-md-9">
                                    <div>
                                        <input type="file" name="image_malaya" id="file-1" class="custom-input-file" accept="image/*" />
                                        <label for="file-1">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('words.choose_file')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.image_for_chinese')}}</label></div>
                                <div class="col-md-9">
                                    <div>
                                        <input type="file" name="image_zh_cn" id="file-1" class="custom-input-file" accept="image/*" />
                                        <label for="file-1">
                                            <i class="fa fa-upload"></i>
                                            <span>{{__('words.choose_file')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 text-right font-weight-bold pr-4 mt-2"><label for="">{{__('words.content')}}</label></div>
                                <div class="col-md-9">
                                    <textarea class="form-control summernote" name="content" rows="5" placeholder="{{__('words.content')}}"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary mr-3"><i class="fas fa-save mr-2"></i>{{__('words.save')}}</button>
                                    <a href="{{route('promotion.index')}}" class="btn btn-danger"><i class="fas fa-times mr-2"></i>{{__('words.cancel')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>

@endsection
    
@section('script')
    <script src="{{asset('backend/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jquery-ui-1.12.1/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script>
    <script src="{{asset('backend/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script>
        $(document).ready(function () {  
            $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
            $(".summernote").summernote();
        });
    </script>
@endsection
