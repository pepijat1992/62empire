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
                    <a href="{{route('wap.withdraw_history')}}" class="nav-item nav-link show active">{{__('words.withdraw')}}</a>
                    <a href="{{route('wap.transfer_history')}}" class="nav-item nav-link show">{{__('words.transfer')}}</a>
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
                                    <th>{{__('words.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)                                        
                                    <tr>
                                        <td>{{$item->created_at}}</td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="status">
                                            @if($item->status == 1)
                                                <span class="badge badge-primary">{{__('words.pending')}}</span>
                                            @elseif($item->status == 2)
                                                <span class="badge badge-success">{{__('words.approved')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{__('words.fail')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="10" class="text-center">
                                        {{__('words.total')}}: {{$total_withdraw}}
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
