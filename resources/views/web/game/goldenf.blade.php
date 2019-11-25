@extends('web.layouts.master')
@section('style')
    <style>
        .game-card {
            width: 100%;
            border-radius: 5px;
        }
        .game-card .title {
            margin-top: 5px;
            text-align: center;
        }
    </style>
    @php
        config(['site.page' => 'casino']);
        $locale = session()->get('locale');
        if($locale == "zh_cn") { $locale = 'zh-CN'; }else{ $locale = 'en-US'; }
    @endphp
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <h3 class="mt-4 text-center">Game List (AG Casino)</h3>
            <div class="row px-2 mb-3 justify-content-center">
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_3" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_3.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_5" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_5.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_21" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_21.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_22" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_22.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_23" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_23.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_25" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_25.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_27" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_27.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_32" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_32.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_34" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_34.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_36" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_36.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_37" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_37.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_38" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_38.png')}}" class="game-card" alt=""></a></div>                
            </div>

            {{-- AG SLOT --}}
            
            <div class="row px-2 justify-content-center">                
                @for ($i = 156; $i <= 804; $i++)
                    @if(file_exists('games/goldenf/image/icon/slot/'.$locale.'/agslot_'.$i.'.gif'))
                        <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="agslot_{{$i}}" data-wallet="gf_main_balance" data-vendor="agslot"><img src="{{asset('games/goldenf/image/icon/slot/'.$locale.'/agslot_'.$i.'.gif')}}" class="game-card" alt=""></a></div>
                    @endif                    
                @endfor
                <div class="col-4 col-md-2 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="agslot_SB56" data-wallet="gf_main_balance" data-vendor="agslot"><img src="{{asset('games/goldenf/image/icon/slot/'.$locale.'/agslot_SB56.gif')}}" class="game-card" alt=""></a></div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            var id = "{{$game->id}}";
            var user_balance = "{{$_user->id}}";
            var game_balance = "{{$game->id}}";

            $.ajax({
                url : "{{route('game.total_withdraw')}}",
                data : { id : "{{$game->id}}" },
                method : "POST",
                dataType : "json",
                success : function(response) {
                    if(response == 'success') {
                        console.log("success");
                    }
                }
            });

            $(".icon-game").click(function(){                
                let code = $(this).data('code');
                let wallet = $(this).data('wallet');
                let vendor = $(this).data('vendor');
                let url = "{{route('game.goldenf.play')}}" + "?code=" + code + "&wallet=" + wallet + "&vendor=" + vendor;
 
                var game_window = window.open(url,'','width=1024,height=768');
                var timer = setInterval(function() { 
                    if(game_window.closed) {
                        clearInterval(timer);
                        // alert('closed');
                        $.ajax({
                            url : "{{route('game.total_withdraw')}}",
                            data : { id : "{{$game->id}}" },
                            method : "POST",
                            dataType : "json",
                            success : function(response) {
                                if(response == 'success') {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }, 300);
            });
        });
    </script>
@endsection