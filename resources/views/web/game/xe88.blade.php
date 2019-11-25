@extends('web.layouts.master')
@section('style')
    <style>
        .game-card img {
            width: 100%;
        }
        .game-card .title {
            text-align: center;
        }
    </style>
    @php
        config(['site.page' => 'hot_game']);
        $account = $game_account->username;
        $password = $game_account->password;
        $locale = session()->get('locale');
        if($locale == "zh_cn") { $locale = 'CN'; }else{ $locale = 'En'; }
    @endphp
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(6)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/6.png')}}" alt=""><h5 class="title">Baccarat</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(9)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/9.png')}}" alt=""><h5 class="title">Aztec</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(10)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/10.png')}}" alt=""><h5 class="title">CrystalWater</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(12)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/12.png')}}" alt=""><h5 class="title">EnhancedGarden</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(13)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/13.png')}}" alt=""><h5 class="title">GreenLight</h5></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(17)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/17.png')}}" alt=""><h5 class="title">SicBo</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(18)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/18.png')}}" alt=""><h5 class="title">Circus</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(19)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/19.png')}}" alt=""><h5 class="title">WealthTreasure</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(23)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/23.png')}}" alt=""><h5 class="title">Belangkai</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(24)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/24.png')}}" alt=""><h5 class="title">HuluCock</h5></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(25)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/25.png')}}" alt=""><h5 class="title">Roulette73</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(26)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/26.png')}}" alt=""><h5 class="title">Roulette</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(29)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/29.png')}}" alt=""><h5 class="title">DragonTiger</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(32)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/32.png')}}" alt=""><h5 class="title">KingDerby</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(35)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/35.png')}}" alt=""><h5 class="title">Victory</h5></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(36)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/36.png')}}" alt=""><h5 class="title">TallyHo</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(38)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/38.png')}}" alt=""><h5 class="title">Motobike</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(39)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/39.png')}}" alt=""><h5 class="title">OrientExpress</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(40)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/40.png')}}" alt=""><h5 class="title">Rally</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(41)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/41.png')}}" alt=""><h5 class="title">BoyKing</h5></a></div>

                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(42)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/42.png')}}" alt=""><h5 class="title">MysticDragon</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(45)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/45.png')}}" alt=""><h5 class="title">SeaCaptain</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(47)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/47.png')}}" alt=""><h5 class="title">CoyoteCash</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(49)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/49.png')}}" alt=""><h5 class="title">T-REX</h5></a></div>
                <div class="col-6 col-md-2 mt-2"><a href="javascript:void(0)" class="game-card" onclick="onClickGame(50)"><img src="{{asset('games/xe88/image/icon/'.$locale.'/50.png')}}" alt=""><h5 class="title">TripleTwister</h5></a></div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        function onClickGame(gameid) {
            var language = "{{$locale}}";
            var account = "{{$account}}";
            var pwd = "{{$password}}";//md5hash of password
            show_loading();
            window.location.href = "http://vgame.fatchoy888.com/index.html?language=" + language + "&gameid=" + gameid + "&userid=" + account + "&userpwd=" + pwd;
        }
    </script>
@endsection