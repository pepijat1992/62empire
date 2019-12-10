@extends('wap.layouts.master')

@section('content')
    @php
        $status = session('login_status');
        $phone_number = session('phone_number');
        session()->forget('phone_number');
    @endphp
    <div class="home-login">
        <div class="container">
            <div class="wrap-content">
                <form method="POST" action="" id="login_form">
                    @csrf
                    <input type="hidden" name="type" value="phone_number" />
                    <div class="content b-shadow">
                        <h3 class="text-inverse text-center">{{__('words.sign_in')}}</h3>
                        <div class="input-group mt-3">
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

                        <div class="input-group mt-3">
                            <input type="text" class="form-control" name="code" value="{{old('code')}}" placeholder="{{__('words.verification_code')}}">
                            <div class="input-group-append">
                              <button type="button" class="btn btn-primary @if($status == 'verify') disabled @endif" id="btn-send-code" @if($status == 'verify') disabled @endif>{{__('words.send')}}</button>
                            </div>
                        </div>                        
                        @error('code')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="infor mt-3">
                            <a href="{{route('login')}}" class="text-primary">{{__('words.sign_in_with_password')}}</a> 
                            <a href="{{route('register')}}" class="btn btn-lg btn-warning float-right blink">{{__('words.register')}}</a></li>                               
                        </div>
                        <button type="button" class="btn btn-danger btn-block my-3 @if($status != 'verify') disabled @endif" id="btn-sign-in" @if($status != 'verify') disabled @endif>{{__('words.sign_in')}}</button>
                        <div class="mt-2 text-center">
                            <a href="{{route('agent.login')}}" class="text-primary font-weight-bold">{{__('words.agent_sign_in')}}</a>
                        </div>
                    </div>
                </form>
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
