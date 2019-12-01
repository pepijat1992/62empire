@extends('agent.layouts.master')

@section('content')
<div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.memo')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-file"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.memo')}}</h1>
                    <small></small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)--> 
    <div class="body-content">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <form action="{{route('agent.save_memo')}}" method="post">
                    @csrf
                    <textarea name="content" id="memo_content" class="form-control" rows="20">{{$_agent->memo->content ?? ''}}</textarea>
                    <button type="submit" class="btn btn-primary btn-block mt-3">{{__('words.save')}}</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection
