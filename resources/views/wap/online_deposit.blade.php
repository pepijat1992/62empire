@extends('wap.layouts.master')
@section('style')
    {{-- <link rel="stylesheet" href="{{asset('backend/plugins/jquery-ui-1.12.1/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/jquery-ui-1.12.1/timepicker/jquery-ui-timepicker-addon.min.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('web/plugins/msdropdown/css/msdropdown/dd.css')}}">
@endsection
@section('content')
<div class="features-home segments-page">
    <div class="container-pd item-list">
        <div class="section-title mt-4">
            <h2 class="text-center">{{__('words.top_up')}}</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{route('wap.post_online_deposit')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-2">
                        <label for="" class="control-label">{{__("words.bank_account")}}</label>
                        <select name="bank_account" class="form-control" id="bank_account" required>
                            <option value="" hidden>{{__('words.select_bank_account')}}</option>
                            @foreach ($bank_accounts as $item)
                                <option value="{{$item->id}}" data-no="{{$item->account_no}}" data-name="{{$item->account_name}}" data-image="{{asset($item->bank->image)}}">{{$item->bank->name}}</option>
                            @endforeach                                
                        </select>
                    </div>
                    <div class="form-group row mb-2">
                        <div class="col-4 pr-0">
                            <label class="control-label">{{__('words.account_name')}}</label>
                        </div>
                        <div class="col-8 inline-value" id="account_name"></div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-4">
                            <label class="control-label">{{__('words.account_no')}}</label>
                        </div>
                        <div class="col-8 inline-value" id="account_no"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-4 control-label">{{__("words.amount")}}</label>
                        <div class="col-8">
                            <input type="number" class="form-control amount" name="amount" min="0" step="0.01" placeholder="{{__("words.amount")}}" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">{{__('words.promotion')}}</label>
                        <div class="col-8 input-group">
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
                    <div class="form-group mb-2">
                        <label class="custom-uploader pt-2 pb-1" style="width:90px;margin:auto;" for="input-custom-uploader">                                                       
                            <span style="line-height:10px;">
                                <svg style="width:25px;height:20px;" aria-hidden="true" focusable="false" data-prefix="far" data-icon="upload" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-upload fa-w-18 fa-3x"><path fill="currentColor" d="M528 288H384v-32h64c42.6 0 64.2-51.7 33.9-81.9l-160-160c-18.8-18.8-49.1-18.7-67.9 0l-160 160c-30.1 30.1-8.7 81.9 34 81.9h64v32H48c-26.5 0-48 21.5-48 48v128c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48zm-400-80L288 48l160 160H336v160h-96V208H128zm400 256H48V336h144v32c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48v-32h144v128zm-40-64c0 13.3-10.7 24-24 24s-24-10.7-24-24 10.7-24 24-24 24 10.7 24 24z" class=""></path></svg>
                            </span>
                            <span class="text-color-green" style="line-height:20px;"><b>Max: 2MB</b></span>
                            <input class="tg-fileinput d-none" type="file" id="input-custom-uploader" name="receipt" accept="image/*">
                        </label>
                        <h6 class="mt-2 text-center">{{__('words.receipt_upload')}}</h6>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3" onclick="show_loading()">{{__('words.submit')}}</button>
                </form>
            </div>
            <div class="col-12 text-center mt-3">
                <a href="{{route('wap.deposit_history')}}"><h4>Deposit History</h4></a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {{-- <script src="{{asset('backend/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jquery-ui-1.12.1/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script> --}}
    <script src="{{asset('web/plugins/msdropdown/js/msdropdown/jquery.dd.js')}}"></script>
    <script>
        $(document).ready(function(){
            // $(".datetimepicker").datetimepicker({
            //     dateFormat: 'yy-mm-dd',
            //     timeFormat: 'hh:mm:ss',
            //     showSecond: true,
            // });
            $("#bank_account").change(function(){
                let account_name = $(this). children("option:selected").data('name');
                let account_no = $(this). children("option:selected").data('no');
                $("#account_name").text(account_name);
                $("#account_no").text(account_no);
                $(".amount").focus();
            });
            $('#bank_account').msDropDown();
        });
    </script>
@endsection
