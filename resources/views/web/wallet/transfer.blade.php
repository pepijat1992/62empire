@extends('web.layouts.master')

@section('content')
    <div id="content" class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    @include('web.wallet.side')
                </div>
                <div id="main" class="col-md-9 col-lg-10">
                    <div class="dep_det_bx">                        
                        <hr style="border-top: 2px solid rgb(255, 223, 0); width: 200px;">
                        <h5>{{__('words.transfer')}}</h5>
                        <div>
                            <form id="withdraw-form" action="{{route('wap.transfer_credit')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10 mt-4">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-3">{{__('words.amount')}}</label>
                                            <div class="col-sm-9 input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">MYR</div>
                                                </div>
                                                <input type="number" class="form-control col-sm-3" name="amount" min="0" step="0.01" value="" placeholder="0.00" />
                                            </div>
                                        </div>
                                        <div class="offset-3 pl-2 mb-2">
                                            <button type="reset" class="btn btn-danger mr-2"><i class="fa fa-eraser mr-2"></i>{{__('words.reset')}}</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>{{__('words.submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                            <h5>{{__('words.transfer_history')}}</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>{{__('words.date_time')}}</th>
                                            <th>{{__('words.amount')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)                                    
                                            <tr>
                                                <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                                <td class="date">{{$item->created_at}}</td>
                                                <td class="amount">
                                                    <span class="mr-3">{{$item->amount}}</span>
                                                    @if($item->type == 'player_agent')
                                                        Transfer to
                                                    @elseif($item->type == 'agent_user')
                                                        Transfer from
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" align="center">{{__('words.no_data')}}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
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
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            
        });
    </script>
@endsection