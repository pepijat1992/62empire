@extends('wap.layouts.master')
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
			margin-top: 29%;
			width: 50%;
			text-align: center;
			background: rgba(0,0,0,0.8);
			border-radius: 5px;
			font-size: 15px;
		}
	</style>
@endsection
@section('content')
    <!-- slide -->
	<div class="slide slide-shop">
		<div class="slide-show owl-carousel owl-theme">
			<div class="slide-content">
				{{-- <div class="mask"></div> --}}
				<img src="{{asset('wap/images/banner/banner1.jpg')}}" alt="">
				<div class="intro-caption">
					{{-- <h2>More Deposit</h2> --}}
					{{-- <button class="btn btn-sm btn-primary mt-3">Play Now</button> --}}
				</div>
			</div>
			{{-- <div class="slide-content">
				<div class="mask"></div>
				<img src="{{asset('wap/images/banner/banner2.jpg')}}" alt="">
				<div class="intro-caption">
					<h2>More Deposit</h2>
					<button class="button ">Play Now</button>
				</div>
			</div>
			<div class="slide-content">
				<div class="mask"></div>
				<img src="{{asset('wap/images/banner/banner3.jpg')}}" alt="">
				<div class="intro-caption">
					<h2>Partnership</h2>
					<button class="button ">Play Now</button>
				</div>
			</div> --}}
		</div>
	</div>
	<!-- end slide -->

	<div class="product product-home popular-product segments py-2">
		<div class="container-pd">
			<div class="row">
				@php
					$hot_games = \App\Models\Game::whereStatus(1)->orderBy('order')->get()
				@endphp
				@foreach ($hot_games as $item)
					<div class="col-6 px-1 mt-2">
						<a href="{{route('game.open', $item->id)}}">
							<div class="content b-shadow game-icon">
								<img src="{{asset($item->image)}}" alt="">
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

	<div style="margin-bottom:55px;"></div>
@endsection