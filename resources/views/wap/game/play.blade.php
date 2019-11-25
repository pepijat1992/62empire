@extends('wap.layouts.game')

@section('content')
    <div class="navbar navbar-pages py-2">
        <div class="container">
            <div class="content-left">
                {{-- <a href="#menu" class="menu-link"><i class="fa fa-bars"></i></a> --}}
            </div>
            <div class="content-center">
                <a href="index.html"><h1>{{$game->title}}</h1></a>
            </div>
            <div class="content-right">
                <a href="javascript:;" class="menu-link-2" id="btn-logout"><i class="fa fa-sign-out"></i></a>
            </div>
        </div>
    </div>
    <div class="" style="padding-top: 38px;">
        <iframe src="{{$result->gameUrl}}" frameborder="0" id="game_panel" width="100%" style="height: calc(100vh - 40px);"></iframe>
    </div>
    
@endsection