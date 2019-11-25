@extends('wap.layouts.master')
@section('content')
    <div class="features-home segments-page">
        <div class="container-pd item-list mb-5">
            <div class="section-title mt-4">
                <h2 class="text-center">{{__('words.game_transaction_history')}}</h2>
            </div>
            <div class="row">
                <div class="container">               
                    <div class="table-responsive mt-3">
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
                        <div class="clearfix mt-2 text-center">
                            <div style="margin: 0;">
                                {!! $data->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection
