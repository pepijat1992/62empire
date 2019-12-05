@extends('wap.layouts.master')
@section('content')
    <div class="features-home tabs-page segments-page">
        <div class="container-pd item-list mb-5">
            <div class="section-title mt-4">
                <h2 class="text-center">{{__('words.transaction_history')}}</h2>
            </div>
            <div class="tabs b-shadow">
                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                    <a href="{{route('wap.deposit_history')}}" class="nav-item nav-link show">{{__('words.deposit')}}</a>
                    <a href="{{route('wap.withdraw_history')}}" class="nav-item nav-link show">{{__('words.withdraw')}}</a>
                    <a href="{{route('wap.transfer_history')}}" class="nav-item nav-link show active">{{__('words.transfer')}}</a>
                </div>
            </div>
            <div class="row">
                <div class="container">               
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('words.date_time')}}</th>
                                    <th>{{__('words.amount')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)                                        
                                    <tr>
                                        <td>{{$item->created_at}}</td>
                                        <td class="amount">
                                            <span class="mr-3">{{$item->amount}}</span>
                                            @if($item->type == 'player_agent')
                                                Transfer to
                                            @elseif($item->type == 'agent_user')
                                                Transfer from
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
