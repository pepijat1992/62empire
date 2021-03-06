@extends('web.layouts.master')
@section('style')
	<style>
		.game-icon {
			position: relative;
		}
		.game-cover {
			position: absolute;
			top: 0;
			z-index: 1;
			width: 100%;
			height: 100%;
		}
		.game-balance {
			margin: 0 auto;
			margin-top: 100%;
			width: 50%;
			text-align: center;
			background: rgba(0,0,0,0.8);
			border-radius: 5px;
			font-size: 15px;
		}
	</style>
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">
                @php
					$online_casinos = \App\Models\Game::whereType('online_casino')->whereStatus(1)->get()
				@endphp
				@foreach ($online_casinos as $item)
                    <div class="col-4 col-sm-3 m-1">
                        <a href="{{route('game.open', $item->id)}}">
                            <div class="game-icon">
                                <img src="{{asset($item->image1)}}" class="rounded-lg">
                                @auth
									@php
										$user_game = \App\Models\GameUser::where('game_id', $item->id)->where('user_id', $_user->id)->first();
										if($user_game) {
											$game_balance = $user_game->balance;
										}else {
											$game_balance = "0.00";
										}
									@endphp
									<div class="game-cover">
										<div class="game-balance">
											{{$game_balance}}
										</div>
									</div>
								@endauth
                            </div>
                        </a>
                    </div>
				@endforeach
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