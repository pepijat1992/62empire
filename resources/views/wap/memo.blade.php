@extends('wap.layouts.master')
@section('style')
    <style>
        .promotion-card {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="features-home segments-page">
        <div class="container-pd mb-5">
            <div class="section-title mt-4">
                <h2 class="text-center"><i class="fa fa-edit mr-2"></i>{{__('words.memo')}}</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{route('web.save_memo')}}" method="post">
                        @csrf
                        <textarea name="content" id="memo_content" class="form-control" rows="20">{{$_user->memo->content ?? ''}}</textarea>
                        <button type="submit" class="btn btn-primary btn-block mt-3">{{__('words.save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            
        });
    </script>
@endsection
