@extends('wap.layouts.master')
@section('content')
    <div class="home-login">
        <div class="container">
            <div class="wrap-content">
                <form method="POST" action="{{route('login')}}" id="login_form">
                    @csrf
                    <input type="hidden" name="type" value="password" />
                    <div class="content b-shadow">
                        <h3 class="text-inverse text-center">{{__('words.sign_in')}}</h3>
                        <div class="input-group mt-3">
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

                        <input type="password" class="form-control mt-3" name="password" value="{{old('password')}}" placeholder="{{__('words.password')}}" required>                            
                        @error('password')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="infor mt-3">
                            <a href="{{route('login_verification')}}" class="text-primary">{{__('words.sign_in_with_verification_code')}}</a>
                            <a href="{{route('register')}}" class="btn btn-lg btn-warning float-right blink">{{__('words.register')}}</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block my-3" id="btn-sign-in">{{__('words.sign_in')}}</button>
                        <div class="mt-2 text-center">
                            <a href="{{route('agent.login')}}" class="text-primary font-weight-bold">{{__('words.agent_sign_in')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
