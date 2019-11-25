@extends('wap.layouts.master')
@section('content')
    <div class="features-home segments-page">
        <div class="container-pd item-list">
            <div class="section-title mt-4 clearfix">
                <h2 class="text-center">{{__('words.transfer_history')}}</h2>
            </div>
            <div class="card card-body" id="playerTable">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{__('words.transfer_history')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('agent.wap.set_player', $user->id)}}">{{__('words.set_history')}}</a>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('words.username')}}</th>
                                <th>{{__('words.amount')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)                            
                                <tr>
                                    <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                    <td>{{$item->sender->username ?? ''}}</td>
                                    <td>{{$item->amount}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" align="center">{{__('words.no_data')}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="clearfix mt-2">
                        <div class="text-center">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>                
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
