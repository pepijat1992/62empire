@extends('wap.layouts.master')
@section('style')
    <style>
        .game-card img {
            width: 100%;
        }
        .game-card .title {
            text-align: center;
        }
    </style>
@endsection
@section('content')
@php
    $account = $game_account->username;
    $password = $game_account->password;
    $locale = session()->get('locale');
    if($locale == "zh_cn") { $locale = 'CN'; }else{ $locale = 'En'; }
@endphp
    <div class="features-home segments-page">
        <div class="container item-list" id="game_list">
            <div class="section-title mt-3">
                <h2 class="text-center">XE88 Game List</h2>
            </div>
            <div class="row">
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(6)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/6.png')}}" alt=""><h5 class="title">Baccarat</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(9)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/9.png')}}" alt=""><h5 class="title">Aztec</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(10)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/10.png')}}" alt=""><h5 class="title">CrystalWater</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(12)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/12.png')}}" alt=""><h5 class="title">EnhancedGarden</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(13)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/13.png')}}" alt=""><h5 class="title">GreenLight</h5></div></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(17)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/17.png')}}" alt=""><h5 class="title">SicBo</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(18)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/18.png')}}" alt=""><h5 class="title">Circus</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(19)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/19.png')}}" alt=""><h5 class="title">WealthTreasure</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(23)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/23.png')}}" alt=""><h5 class="title">Belangkai</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(24)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/24.png')}}" alt=""><h5 class="title">HuluCock</h5></div></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(25)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/25.png')}}" alt=""><h5 class="title">Roulette73</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(26)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/26.png')}}" alt=""><h5 class="title">Roulette</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(29)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/29.png')}}" alt=""><h5 class="title">DragonTiger</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(32)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/32.png')}}" alt=""><h5 class="title">KingDerby</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(35)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/35.png')}}" alt=""><h5 class="title">Victory</h5></div></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(36)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/36.png')}}" alt=""><h5 class="title">TallyHo</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(38)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/38.png')}}" alt=""><h5 class="title">Motobike</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(39)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/39.png')}}" alt=""><h5 class="title">OrientExpress</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(40)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/40.png')}}" alt=""><h5 class="title">Rally</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(41)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/41.png')}}" alt=""><h5 class="title">BoyKing</h5></div></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(42)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/42.png')}}" alt=""><h5 class="title">MysticDragon</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(45)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/45.png')}}" alt=""><h5 class="title">SeaCaptain</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(47)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/47.png')}}" alt=""><h5 class="title">CoyoteCash</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(49)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/49.png')}}" alt=""><h5 class="title">T-REX</h5></div></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" onclick="onClickGame(50)"><div class="game-card"><img src="{{asset('games/xe88/image/icon/'.$locale.'/50.png')}}" alt=""><h5 class="title">TripleTwister</h5></div></a></div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function onClickGame(gameid)
        {
            var language = "{{$locale}}";
            var account = "{{$account}}";
            var pwd = "{{$password}}";//md5hash of password
            show_loading();
            window.location.href = "http://vgame.fatchoy888.com/index.html?language=" + language + "&gameid=" + gameid + "&userid=" + account + "&userpwd=" + pwd;
        }
    </script>
@endsection
