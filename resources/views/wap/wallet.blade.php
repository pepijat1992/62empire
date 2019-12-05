@extends('wap.layouts.master')

@section('content')
<div class="features-home segments-page">
    <div class="container-pd item-list">
        <div class="section-title mt-2 text-center">
            <img src="{{asset('wap/images/icons/dollar.gif')}}" width="100" alt="" class="mx-auto">
            <h2 class="text-center mt-3">{{__('words.my_balance')}}</h2>
        </div>
        <div class="px-5 my-balance">
            <div class="balance clearfix"><div class="float-left w-50">MYR</div> <div class="value border-bottom font-weight-bold w-50 float-right text-info text-center">{{$_user->score}}</div></div>
        </div>
        <div class="row mt-3">
            <div class="col-12 px-2">
                <div class="content b-shadow p-4">
                    <a href="{{route('wap.online_deposit')}}" class="btn btn-primary btn-block mt-3">{{__('words.top_up')}}</a>
                    <a href="{{route('wap.online_withdraw')}}" class="btn btn-primary btn-block mt-3">{{__('words.withdraw')}}</a>
                    <a href="javascript:;" class="btn btn-primary btn-block mt-3" id="btn-transfer">{{__('words.transfer')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="transferModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">{{__('words.transfer')}}</h5>
                <button class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form method="POST" action="{{route('wap.transfer_credit')}}" id="transfer_form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">{{__('words.amount')}} <span class="text-danger">*</span></label>
                        <input class="form-control amount" type="number" min="0" max="{{$_user->score}}" name="amount" placeholder="{{__('words.amount')}}" required />
                    </div>
                </div>   
                <div class="modal-footer">
                    <a href="{{route('wap.transfer_history')}}" class="btn btn-info float-left">{{__('words.history')}}</a>
                    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check mr-1"></i>&nbsp;{{__('words.save')}}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;{{__('words.close')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#btn-transfer").click(function () {
                $("#transferModal").modal();
            })
        });
    </script>
@endsection
