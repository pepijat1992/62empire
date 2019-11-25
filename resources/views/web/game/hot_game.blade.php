@extends('web.layouts.master')
@section('style')
@php
    config(['site.page' => 'hot_game']);
@endphp
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">
                @php
					$hot_games = \App\Models\Game::whereType('hot_game')->whereStatus(1)->orderBy('order')->get()
				@endphp
				@foreach ($hot_games as $item)
                    <div class="col-4 col-sm-3 mb-3">
                        <div>
                            <a href="{{route('game.open', $item->id)}}">
                                <img src="{{asset($item->image1)}}" class="rounded-lg">
                            </a>
                        </div>
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