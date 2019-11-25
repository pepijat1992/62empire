@extends('web.layouts.master')
@section('style')

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