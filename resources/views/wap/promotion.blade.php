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
                <h2 class="text-center">{{__('words.promotions')}}</h2>
            </div>
            <div class="row">
                @foreach ($promotions as $item)
                    @php
                        $img_path = $item->image_en;
                        if(config('app.locale') == 'malaya' && file_exists($item->image_malaya)){
                            $img_path = $item->image_malaya;
                        }else if (config('app.locale') == 'zh_cn' && file_exists($item->image_zh_cn)){
                            $img_path = $item->image_zh_cn;
                        }
                    @endphp                                           
                    <div class="col-12 mb-2">
                        <div class="content p-0">
                            <a href="javascript:;" class="promotion-card" data-title="{{$item->title}}">
                                <img src="{{asset($img_path)}}" width="100%" alt="">
                            </a>
                            <div class="d-none promotion-content">{!! $item->content !!}</div>
                        </div>                        
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="promotionModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"></h5>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(".promotion-card").click(function () {
                let title = $(this).data('title');
                let content = $(this).siblings(".promotion-content").html();
                $("#promotionModal .modal-title").text(title);
                $("#promotionModal .modal-body").html(content);
                $("#promotionModal").modal();
            })
        });
    </script>
@endsection
