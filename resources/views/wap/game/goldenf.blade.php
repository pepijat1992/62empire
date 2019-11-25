@extends('wap.layouts.master')
@section('style')
    <style>
        .game-card{
            width: 100%;
            border-radius: 5px;
        }
        .game-card .title {
            text-align: center;
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    @php
        $locale = session()->get('locale');
        if($locale == "zh_cn") { $locale = 'zh-CN'; } else { $locale = 'en-US'; }
    @endphp
    <div class="features-home segments-page">
        <div class="container-pd item-list" id="game_list">
            <div class="section-title mt-3">
                <h2 class="text-center">AG Casino Game List</h2>
            </div>
            
            <div class="row px-2 mb-2">
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_3" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_3.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_5" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_5.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_21" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_21.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_22" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_22.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_23" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_23.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_25" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_25.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_27" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_27.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_32" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_32.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_34" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_34.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_36" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_36.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_37" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_37.png')}}" class="game-card" alt=""></a></div>
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="ag_38" data-wallet="gf_main_balance" data-vendor="AG"><img src="{{asset('games/goldenf/image/icon/casino/'.$locale.'/ag_38.png')}}" class="game-card" alt=""></a></div>
            </div>

            {{-- AG SLOT --}}
            <div class="row px-2">                
                @for ($i = 156; $i <= 804; $i++)
                    @if(file_exists('games/goldenf/image/icon/slot/'.$locale.'/agslot_'.$i.'.gif'))
                        <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="agslot_{{$i}}" data-wallet="gf_main_balance" data-vendor="agslot"><img src="{{asset('games/goldenf/image/icon/slot/'.$locale.'/agslot_'.$i.'.gif')}}" class="game-card" alt=""></a></div>
                    @endif                    
                @endfor
                <div class="col-4 col-md-3 mt-2 px-1"><a href="javascript:void(0)" class="icon-game" data-code="agslot_SB56" data-wallet="gf_main_balance" data-vendor="agslot"><img src="{{asset('games/goldenf/image/icon/slot/'.$locale.'/agslot_SB56.gif')}}" class="game-card" alt=""></a></div>
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
                }, 200);
            });
        });
    </script>
@endsection
