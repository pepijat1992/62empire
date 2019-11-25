@extends('wap.layouts.master')
@section('content')
<div class="features-home segments-page">
    <div class="container-pd item-list">
        <div class="section-title mt-4">
            <h2 class="text-center">{{__('words.member_center')}}</h2>
        </div>
        <div class="row">
            <div class="col-12 px-2">
                <div class="content b-shadow">
                    <h5><a href="{{route('wap.wallet')}}" class="d-block"><img src="{{asset('wap/images/icons/aside_2.png')}}" alt="">&nbsp;&nbsp;{{__('words.wallet')}}</a></h5>
                </div>
            </div>
            <div class="col-12 px-2 mt-2">
                <div class="content b-shadow">
                    <h5><a href="{{route('wap.bank_account.index')}}" class="d-block"><img src="{{asset('wap/images/icons/aside_11.png')}}" alt="">&nbsp;&nbsp;{{__('words.bank_account')}}</a></h5>
                </div>
            </div>
            {{-- <div class="col-12 px-2 mt-2">
                <div class="content b-shadow">
                    <h5><a href=""><img src="{{asset('wap/images/icons/aside_5.png')}}" alt="">&nbsp;&nbsp;{{__('words.deposit_history')}}</a></h5>
                </div>
            </div>
            <div class="col-12 px-2 mt-2">
                <div class="content b-shadow">
                    <h5><a href=""><img src="{{asset('wap/images/icons/aside_6.png')}}" alt="">&nbsp;&nbsp;{{__('words.withdraw_history')}}</a></h5>
                </div>
            </div> --}}
            {{-- <div class="col-12 px-2 mt-2">
                <div class="content b-shadow">
                    <h5><a href="" class="d-block"><img src="{{asset('wap/images/icons/aside_6.png')}}" alt="">&nbsp;&nbsp;{{__('words.game_records')}}</a></h5>
                </div>
            </div> --}}
            <div class="col-12 px-2 mt-2">
                <div class="content b-shadow">
                    <h5><a href="http://bit.ly/2XdrVz4" target="_blank" class="d-block"><img src="{{asset('wap/images/icons/aside_10.png')}}" alt="">&nbsp;&nbsp;{{__('words.customer_service')}}</a></h5>
                </div>
            </div>
            <div class="col-12 px-2 mt-2">
                <div class="content b-shadow">
                    <h5><a href="{{route('wap.setting')}}" class="d-block"><img src="{{asset('wap/images/icons/aside_6.png')}}" alt="">&nbsp;&nbsp;{{__('words.setting')}}</a></h5>
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
