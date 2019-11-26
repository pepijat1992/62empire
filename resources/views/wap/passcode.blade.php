@extends('wap.layouts.master')
@section('style')    
    <link rel="stylesheet" href="{{asset('web/plugins/keypad/css/jquery.keypad.css')}}">
    <style>
        body{
            border: solid 8px #007bff;
        }
        .navbar{
            border: solid 8px #007bff;
            border-bottom: none;
        }
        .footer-nav{
            border: solid 8px #007bff;
            border-top: none;
            height: 64px;
        }
    </style>
@endsection
@section('content')
    <div class="home-login">
        <div class="container">
            <div class="wrap-content">
                <form method="POST" action="{{route('post_check_passcode')}}" id="login_form">
                    @csrf
                    <div class="content b-shadow">
                        <h3 class="text-inverse text-center">{{__('words.check_passcode')}}</h3>
                        
                        <input type="passcode" class="form-control mt-3" name="passcode" id="input_passcode" maxlength="4" value="{{old('passcode')}}" placeholder="{{__('words.passcode')}}" required>                            
                        <div id="inline-keypad" style="margin:auto"></div>
                        @error('passcode')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-block my-3" id="btn-sign-in">{{__('words.sign_in')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('web/plugins/keypad/js/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('web/plugins/keypad/js/jquery.keypad.js')}}"></script>
    <script>
        $(document).ready(function(){
            // $("#input_passcode").keypad();

            $('#inline-keypad').keypad({onKeypress: appendValue, prompt: ''}); 
                    
            function appendValue(key) { 
                var field = $('#input_passcode'); 
                $.keypad.insertValue(field, key); 
                field.focus(); 
            }
        });
    </script>
@endsection
