@extends('web.layouts.master')

@section('content')
    <div id="content" class="mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div id="main" class="col-md-8 col-lg-9 mx-auto">
                    @php
                        $status = session('login_status');
                        $phone_number = session('phone_number');
                        session()->forget('phone_number');
                    @endphp
                    <xx-sign-in ref="signin_form" inline-template>
                        <form action="{{route('login')}}" method="POST" id="login_form">
                            @csrf
                            <input type="hidden" name="type" value="phone_number" />
                            <div class="dep_det_bx">
                                <h4>{{__('words.sign_in')}}</h4>
                                <hr style="border-color: #ddd;" />
                                <div class="row">
                                    <div class="col-md-10 mt-4 mx-auto">
                                        <div class="form-group row">
                                            <label for="" class="col-md-4 text-right mt-2">{{__('words.phone_number')}}</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+60</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="phone_number" value="{{$phone_number}}" placeholder="{{__('words.phone_number')}}" required />
                                                </div>
                                                @error('phone_number')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-md-4 text-right mt-2">{{__('words.verification_code')}}</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code" value="{{old('code')}}" placeholder="{{__('words.verification_code')}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary @if($status == 'verify') disabled  @endif ml-0" id="btn-send-code" @if($status == 'verify') disabled @endif>{{__('words.send')}}</button>
                                                    </div>
                                                </div>                        
                                                @error('code')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 text-center">{{__('words.have_not_account')}} <a href="{{route('register')}}" class="text-info">{{__('words.sign_up')}}</a></div>
                                            <div class="col-md-6 text-center"><a href="{{route('login')}}" class="text-light">{{__('words.sign_in_with_password')}}</a></div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary w-50 my-3 @if($status != 'verify') disabled @endif" id="btn-sign-in" @if($status != 'verify') disabled @endif>{{__('words.sign_in')}}</button>
                                        </div>
                                        <div class="mt-2 text-center">
                                            <a href="{{route('agent.login')}}" class="text-primary font-weight-bold">{{__('words.agent_sign_in')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </xx-sign-in>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            $("#btn-send-code").click(function(){
                $(this).attr('disabled', true);
                $("#login_form").attr('action', "{{route('login')}}");
                $("#login_form").submit();
            });

            $("#btn-sign-in").click(function(){
                $("#login_form").attr('action', "{{route('login_verify')}}");
                $("#login_form").submit();
            });
        });
    </script>
@endsection