@extends('admin.layouts.master')
@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{__('words.setting')}}</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-cogs"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">{{__('words.setting')}}</h1>
                    <small>{{__('words.setting')}}</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="table-responsive mt-2">
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">First PassCode</label>
                                <input type="text" class="form-control" name="passcode" value="{{$setting->first_passcode}}" />
                            </div>
                            <button type="submit" class="btn btn-primary mt-2"><i class="far fa-save mr-2"></i>{{__('words.save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>   

@endsection
    
@section('script')

@endsection
