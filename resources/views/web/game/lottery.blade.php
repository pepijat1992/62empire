@extends('web.layouts.master')
@section('style')

@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">                
                <div class="col-12 col-md-8 m-1">
                    <div>
                        <a href="javascript:;">
                            <img src="{{asset('images/coming-soon.jpg')}}" class="rounded-lg">
                        </a>
                    </div>
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