@extends('web.layouts.master')
@section('style')
    @php
        config(['site.page' => 'home']);       
    @endphp
@endsection
@section('content')
    <div class="container-fluid p-0 m-0">
        <div class="d-none d-md-block">
            <div id="carousel-md-1553" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-md-1553" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-md-1553" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-md-1553" data-slide-to="2" class=""></li>
                    <li data-target="#carousel-md-1553" data-slide-to="3" class=""></li>
                    <li data-target="#carousel-md-1553" data-slide-to="4" class=""></li>
                    <li data-target="#carousel-md-1553" data-slide-to="5" class=""></li>
                    <li data-target="#carousel-md-1553" data-slide-to="6" class=""></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{asset('web/images/banners/1st_signup.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="carousel-item ">
                        <img class="d-block w-100" src="{{asset('web/images/banners/20_bonustopup.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="carousel-item ">
                        <img class="d-block w-100" src="{{asset('web/images/banners/sportbook_comingsoon.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="carousel-item ">
                        <img class="d-block w-100" src="{{asset('web/images/banners/welcome_bonus_50.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="carousel-item ">
                        <img class="d-block w-100" src="{{asset('web/images/banners/100_casino.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="carousel-item ">
                        <img class="d-block w-100" src="{{asset('web/images/banners/birthdaybonus.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="carousel-item ">
                        <img class="d-block w-100" src="{{asset('web/images/banners/recommend.jpg')}}" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carousel-md-1553" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-md-1553" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="d-md-none text-center">
            <div id="carousel-1553" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-1553" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-1553" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-1553" data-slide-to="2" class=""></li>
                    <li data-target="#carousel-1553" data-slide-to="3" class=""></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('web/media/filer_public/a0/98/a09880cc-3480-4de1-b1bf-49542bea4028/20191001_2030.jpg')}}" class="img-fluid rounded-lg border" alt="">
                    </div>

                    <div class="carousel-item ">
                        <img src="{{asset('web/media/filer_public/33/ec/33ec89f0-9b14-47fa-8420-2b0d00a96475/20191002_1610.jpg')}}" class="img-fluid rounded-lg border" alt="">
                    </div>

                    <div class="carousel-item ">
                        <img src="{{asset('web/media/filer_public/2b/60/2b608103-5b41-4f96-a710-5eec2dff3c15/20191002_1800.jpg')}}" class="img-fluid rounded-lg border" alt="">
                    </div>

                    <div class="carousel-item ">
                        <img src="{{asset('web/media/filer_public/a6/aa/a6aa369c-d063-48ef-a171-3816b9f7f6a2/20191002_2000.jpg')}}" class="img-fluid rounded-lg border" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>

    <div id="content" class="mt-5 mb-5">
        <div id="main" class="home">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="border embed-responsive embed-responsive-16by9">
                                        <video controls style="max-height: 200px">
                                            <source src="{{asset('web/media/intro.mp4')}}" type="video/mp4"> Your browser doesn't support this video format.
                                        </video>
                                    </div>
                                </div>
                                <div class="col-md-4 my-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <span class="h5">{{__('words.deposit')}}</span>
                                            <br />
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 10%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="60"></div>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.7rem">Average time</span>
                                        </div>
                                        <div class="col-4 m-auto text-right">
                                            <span class="h2">1</span><span style="font-size: 0.7rem">mins</span>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-8">
                                            <span class="h5">{{__('words.withdraw')}}</span>
                                            <br />
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="60"></div>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.7rem">Average time</span>
                                        </div>
                                        <div class="col-4 m-auto text-right">
                                            <span class="h2">3</span><span style="font-size: 0.7rem">mins</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <span class="h5">{{__('words.transfer')}}</span>
                                            <br />
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="60"></div>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.7rem">Average time</span>
                                        </div>
                                        <div class="col-4 m-auto text-right">
                                            <span class="h4">INSTANT!</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none d-md-block text-center">
                                    <div class="border">

                                        <img src="{{asset('web/media/filer_public_thumbnails/filer_public/3c/8f/3c8fe952-5ca4-45ec-8d12-8dcc54b2926a/20191005_2025.jpg__400x400_q85_subsampling-2.jpg')}}" alt="">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <div class="d-none d-md-block">
                                <p class="h4 font-weight-bold">RECOMMENDED SLOTS</p>
                                <div class="line my-3"></div>
                                <div class="row">

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/a2/84/a2845dfa-9a20-41ab-9f95-e57958a80b4d/1q36p58phmt6y.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/46/28/4628eac2-c6eb-49de-a8e6-e8a49612cbb0/4d5kdkpqi6sk4.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/ab/74/ab746c2d-c8cd-4696-a17c-17e24c64d886/69xaiyrbo4dae.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/61/f6/61f649b6-0d29-45bb-b9bf-a731b8330657/8rqwot18etnuw.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/70/5f/705f0548-8127-4934-bcfd-fcc8fa293382/axt5pxf7sk35y.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/f2/8e/f28e4f4e-224f-48ad-bc07-45180ca1ac8b/ebudnqj68h6d4.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/8b/5e/8b5eef6a-d0ed-45e4-848f-91f8d8a298ae/fwria11mjbrwh.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/60/14/6014c1b0-b903-46dc-ad24-9973b50e5b7b/jbzd1cjsgh4dk.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/d4/13/d4136a72-3cac-425f-9df4-981465107a09/kf41ymtxfos1r.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/33/4a/334a1a6f-22c4-4c29-a073-e1f53b4e5888/rh8iwwntk3mie.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/ea/41/ea41274b-78b5-4967-8a5a-8ced1f35bb9d/xtpy4bx49xhx1.png')}}" alt="">
                                    </div>

                                    <div class="col-md-2">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/ed/f4/edf408c1-c435-485d-97f1-52e0a98c3b8e/bes8675wqiigs.png')}}" alt="">
                                    </div>

                                </div>
                            </div>
                            <div class="d-block d-md-none">
                                <p class="h4 font-weight-bold">RECOMMENDED SLOTS</p>
                                <div class="line my-1"></div>
                                <div class="row">

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/a2/84/a2845dfa-9a20-41ab-9f95-e57958a80b4d/1q36p58phmt6y.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/46/28/4628eac2-c6eb-49de-a8e6-e8a49612cbb0/4d5kdkpqi6sk4.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/ab/74/ab746c2d-c8cd-4696-a17c-17e24c64d886/69xaiyrbo4dae.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/61/f6/61f649b6-0d29-45bb-b9bf-a731b8330657/8rqwot18etnuw.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/70/5f/705f0548-8127-4934-bcfd-fcc8fa293382/axt5pxf7sk35y.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/f2/8e/f28e4f4e-224f-48ad-bc07-45180ca1ac8b/ebudnqj68h6d4.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/8b/5e/8b5eef6a-d0ed-45e4-848f-91f8d8a298ae/fwria11mjbrwh.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/60/14/6014c1b0-b903-46dc-ad24-9973b50e5b7b/jbzd1cjsgh4dk.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/d4/13/d4136a72-3cac-425f-9df4-981465107a09/kf41ymtxfos1r.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/33/4a/334a1a6f-22c4-4c29-a073-e1f53b4e5888/rh8iwwntk3mie.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/ea/41/ea41274b-78b5-4967-8a5a-8ced1f35bb9d/xtpy4bx49xhx1.png')}}" alt="">
                                    </div>

                                    <div class="col-4">
                                        <img class="d-block w-100" src="{{asset('web/media/filer_public/ed/f4/edf408c1-c435-485d-97f1-52e0a98c3b8e/bes8675wqiigs.png')}}" alt="">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="line my-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection