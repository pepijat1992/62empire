@extends('web.layouts.master')
@section('style')
    <link rel="stylesheet" href="{{asset('web/plugins/msdropdown/css/msdropdown/dd.css')}}">
@endsection
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
                        <h5>{{__('words.deposit')}}</h5>
                        <div>
                            <form id="deposit-form" action="{{route('wap.post_online_deposit')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10 mt-4">
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-3">{{__('words.bank_account')}}</label>
                                            <div class="col-sm-9">
                                                <select name="bank_account" class="form-control" id="bank_account" required>
                                                    <option value="" hidden>{{__('words.select_bank_account')}}</option>
                                                    @foreach ($bank_accounts as $item)
                                                        <option value="{{$item->id}}" data-no="{{$item->account_no}}" data-name="{{$item->account_name}}" data-image="{{asset($item->bank->image)}}">{{$item->bank->name}}</option>
                                                    @endforeach                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-3">{{__('words.amount')}}</label>
                                            <div class="col-sm-9 input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">MYR</div>
                                                </div>
                                                <input type="text" class="form-control col-sm-3" name="amount" value="" required="required" placeholder="0.00">
                                                <!---->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-3">{{__('words.promotion')}}</label>
                                            <div class="col-sm-9 input-group">
                                                @php
                                                    $promotions = \App\Models\Promotion::all();
                                                @endphp
                                                <select name="promotion_id" id="" class="form-control">
                                                    <option value=""> --- </option>
                                                    @foreach ($promotions as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>                                                        
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-3">{{__('words.receipt_upload')}}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" name="receipt" accept="image/png, image/jpeg, image/gif" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label text-primary" for="customFile">{{__('words.choose_file')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offset-3 pl-2 mb-2">
                                            <button type="reset" class="btn btn-danger mr-3"><i class="fa fa-eraser mr-2"></i>{{__('words.reset')}}</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>{{__('words.submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                            <h5>{{__('words.deposit_history')}}</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>{{__('words.date_time')}}</th>
                                            <th>{{__('words.amount')}}</th>
                                            <th>{{__('words.status')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)                                    
                                            <tr>
                                                <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                                <td class="date">{{$item->hk_at}}</td>
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
    <script src="{{asset('web/plugins/msdropdown/js/msdropdown/jquery.dd.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#bank_account').msDropDown();
        });
    </script>
@endsection