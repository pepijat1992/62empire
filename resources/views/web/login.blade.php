@extends('web.layouts.master')
@section('style')    
    <link rel="stylesheet" href="{{asset('web/plugins/keypad/css/jquery.keypad.css')}}">
@endsection
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
                            <input type="hidden" name="type" value="password" />
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
                                                    <input type="text" class="form-control" name="phone_number" value="{{old('phone_number')}}" placeholder="{{__('words.phone_number')}}" required />
                                                </div>
                                                @error('phone_number')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-md-4 text-right mt-2">{{__('words.passcode')}}</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="passcode" id="input_passcode" placeholder="{{__('words.passcode')}}" maxlength="4" required>                            
                                                @error('passcode')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-md-4 text-right mt-2">{{__('words.password')}}</label>
                                            <div class="col-md-8">
                                                <input type="password" class="form-control" name="password" placeholder="{{__('words.password')}}" required>                            
                                                @error('password')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 text-center">{{__('words.have_not_account')}} <a href="{{route('register')}}" class="text-info">{{__('words.sign_up')}}</a></div>
                                            <div class="col-md-6 text-center"><a href="{{route('login_verification')}}" class="text-light">{{__('words.sign_in_with_verification_code')}}</a></div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary w-50 my-3 mx-auto" id="btn-sign-in">{{__('words.sign_in')}}</button>
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
    <script src="{{asset('web/plugins/keypad/js/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('web/plugins/keypad/js/jquery.keypad.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#input_passcode").keypad();
        });
    </script>
@endsection