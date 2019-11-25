@extends('web.layouts.master')
@section('style')

@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">               
                <div id="accordion_promotion" class="col-md-10"> 
                    @foreach ($promotions as $item)
                        @php
                            $img_path = $item->image_en;
                            if(config('app.locale') == 'malaya' && file_exists($item->image_malaya)){
                                $img_path = $item->image_malaya;
                            }else if (config('app.locale') == 'zh_cn' && file_exists($item->image_zh_cn)){
                                $img_path = $item->image_zh_cn;
                            }
                        @endphp                                           
                        <div class="card mb-2">
                            <div class="card-header p-0">
                                <a class="card-link" data-toggle="collapse" href="#promotion_content{{$item->id}}">
                                    <img src="{{asset($img_path)}}" alt="">
                                </a>
                            </div>
                            <div id="promotion_content{{$item->id}}" class="collapse" data-parent="#accordion_promotion">
                                <div class="card-body">
                                    <div class="promotion-text">
                                        {!! $item->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

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