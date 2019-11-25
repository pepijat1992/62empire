@extends('wap.layouts.master')

@section('content')
    @php
        $status = session('register_status');
        $phone_number = session('phone_number');
        $agent = session('agent');
        session()->forget('phone_number');
        session()->forget('agent');
    @endphp
    <div class="home-login">
        <div class="container">
            <div class="wrap-content">
                <form method="POST" action="" id="register_form">
                    @csrf
                    <div class="content b-shadow">
                        <h3 class="text-inverse text-center">{{__('words.sign_up')}}</h3>
                        <input type="text" class="form-control mt-3" name="agent_id" value="{{$agent}}" placeholder="{{__('words.agent_id')}}" />
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
                              <button type="button" class="btn btn-primary" id="btn-send-code">{{__('words.send')}}</button>
                            </div>
                        </div>                        
                        @error('code')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="infor mt-3">
                            <ul>
                                <li>
                                    {{__('words.already_have_account')}} <a href="{{route('login')}}">{{__('words.sign_in')}}</a>
                                </li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary btn-block my-2 @if($status != 'verify') disabled @endif" id="btn-sign-up" @if($status != 'verify') disabled @endif>{{__('words.sign_up')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- @if($status == 'verify')
        <script>
            let countDown = 60;
            $("#btn-send-code").addClass("disabled").attr('disabled', true);
            x = setInterval(function() {
                countDown -= 1;            
                document.getElementById('btn-send-code').innerText = pad2(countDown);        
                if (countDown == 0) {
                    clearInterval(x);
                    $("#btn-send-code").removeClass("disabled").attr('disabled', false).text("{{__('words.send')}}");
                }
            }, 1000);
            function pad2(number) {   
                return (number < 10 ? '0' : '') + number        
            }
        </script>
    @endif --}}
    <script>
        $(document).ready(function(){
            $("#btn-send-code").click(function(){
                $(this).attr('disabled', true);
                $("#register_form").attr('action', "{{route('register')}}");
                $("#register_form").submit();
            });

            $("#btn-sign-up").click(function(){
                $("#register_form").attr('action', "{{route('register_verify')}}");
                $("#register_form").submit();
            });

            
        });
    </script>
@endsection
