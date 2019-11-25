@extends('web.layouts.master')
@section('style')
    @php
        if($game->type == "online_casino"){
            config(['site.page' => 'casino']);
        } elseif ($game->type == 'hot_game'){
            config(['site.page' => 'hot_game']);
        } elseif ($game->type == 'lottery'){
            config(['site.page' => 'lottery']);
        }
    @endphp
@endsection
@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row mb-3 justify-content-center">                
                <div id="main" class="col-md-10 col-lg-8">
                    <div class="dep_det_bx">
                        <h5 class="text-center mb-3">{{__('words.game_transaction_history')}}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('words.type')}}</th>
                                        <th>{{__('words.amount')}}</th>
                                        <th>{{__('words.date_time')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)                                        
                                        <tr>
                                            <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                            <td class="type">
                                                @if($item->type == 'deposit')
                                                    <span class="badge badge-primary">{{__('words.deposit')}}</span>
                                                @elseif($item->type == 'withdraw')
                                                    <span class="badge badge-danger">{{__('words.withdraw')}}</span>
                                                @endif
                                            </td>
                                            <td class="amount">{{$item->amount}}</td>
                                            <td>{{$item->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="10" class="text-center">
                                            {{__('words.total_deposit')}}: {{$total_deposit}}&nbsp;&nbsp;&nbsp;
                                            <span class="text-danger">{{__('words.total_withdraw')}}:  {{$total_withdraw}}</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>                            
                            <div class="clearfix mt-2">
                                <div class="float-left" style="margin: 0;">
                                    <p>{{__('words.total')}} <strong style="color: red">{{ $data->total() }}</strong> {{__('words.items')}}</p>
                                </div>
                                <div class="float-right" style="margin: 0;">
                                    {!! $data->appends([])->links() !!}
                                </div>
                            </div>
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