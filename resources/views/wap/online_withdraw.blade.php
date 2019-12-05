@extends('wap.layouts.master')
@section('content')
<div class="features-home segments-page">
    <div class="container-pd item-list mb-5">
        <div class="section-title mt-4">
            <h2 class="text-center">{{__('words.withdraw')}}</h2>
        </div>
        <div class="row">
            <div class="container">               
                <div class="content b-shadow p-3 pb-5">                    
                    <form method="POST" action="{{route('wap.post_online_withdraw')}}">
                        @csrf
                        <div class="form-group">
                            <label for="" class="control-label">{{__("words.bank_name")}}</label>
                            <select name="bank" class="form-control" id="bank" required>
                                <option value="" hidden>{{__('words.select_bank')}}</option>
                                @foreach ($banks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">{{__("words.account_name")}}</label>
                            <input type="text" class="form-control account_name" name="account_name" placeholder="{{__('words.account_holder_name')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">{{__("words.account_no")}}</label>
                            <input type="text" class="form-control" name="account_no" placeholder="{{__('words.bank_account_number')}}" required />
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">{{__("words.amount")}}</label>
                            <input type="number" class="form-control amount" name="amount" min="0" step="0.01" placeholder="{{__('words.amount')}}" required />
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4" onclick="show_loading()">{{__('words.submit')}}</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{route('wap.withdraw_history')}}"><h4>Withdraw History</h4></a>
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
            $("#bank_account").change(function(){
                let account_name = $(this). children("option:selected").data('name');
                let account_no = $(this). children("option:selected").data('no');
                $("#account_name").text(account_name);
                $("#account_no").text(account_no);
                $(".account_name").focus();
            });
        });
    </script>
@endsection
