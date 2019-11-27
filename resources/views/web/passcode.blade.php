@extends('web.layouts.master')
@section('style')    
    <link rel="stylesheet" href="{{asset('web/plugins/keypad/css/jquery.keypad.css')}}">
    <style>
        body{
            background: #010101;
            height: 100vh;
        }
        #app {
            height: unset;
            background: #010101;
        }
        .keypad-inline {
            border: none;
            margin-top: 45%;
        }
        header, footer, .sidebar_social{
            display: none;
        }
        .input-result {
            background: none;
            color: white;
            border: none;
            font-size: 42px !important;
            padding-top: 0;
            padding-bottom: 0;
            line-height: 1;
            text-align: right;
        }
        .input-result:focus{
            border: none;
            outline: none;
        }
        .btn-submit {
            background-color: #e74c3c !important;
            border-color: #e74c3c !important;
        }
    </style>
@endsection
@section('content')
    <div id="content" class="mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <form method="POST" action="{{route('post_check_passcode')}}" id="login_form">
                        @csrf
                        <div id="inline-keypad" class="mt-3 mx-auto is-keypad" style="width:300px;">
                            <div class="keypad-inline">
                                <div class="keypad-row">
                                    <input type="text" class="input-result w-100 px-3" name="passcode" id="input_passcode" autocomplete="off" maxlength="4" autofocus required>
                                </div>
                                <div class="keypad-row">                                    
                                    <button type="button" class="keypad-special keypad-clear" title="Erase all the text">C</button>
                                    <button type="button" class="keypad-special keypad-back" title="Close the keypad">&lt;</button>
                                    <button type="button" class="keypad-special keypad-percent" title="Close the keypad">%</button>
                                    <button type="button" class="keypad-special keypad-operator" title="Close the keypad">÷</button>
                                </div>
                                <div class="keypad-row">
                                    <button type="button" class="keypad-key">1</button>
                                    <button type="button" class="keypad-key">2</button>
                                    <button type="button" class="keypad-key">3</button>
                                    <button type="button" class="keypad-special keypad-operator" title="Close the keypad">×</button>
                                </div>
                                <div class="keypad-row">
                                    <button type="button" class="keypad-key">4</button>
                                    <button type="button" class="keypad-key">5</button>
                                    <button type="button" class="keypad-key">6</button>
                                    <button type="button" class="keypad-special keypad-operator" title="Erase all the text">-</button>
                                </div>
                                <div class="keypad-row">
                                    <button type="button" class="keypad-key">7</button>
                                    <button type="button" class="keypad-key">8</button>
                                    <button type="button" class="keypad-key">9</button>
                                    <button type="button" class="keypad-special keypad-operator" title="Erase the previous character">+</button>
                                </div>
                                <div class="keypad-row">
                                    <button type="button" class="keypad-key" style="width:130px">0</button>
                                    <button type="submit" class="keypad-special btn-submit" style="width:130px;font-size:25px !important;">{{__('words.submit')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('web/js/calculator.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(".input-result").focus();
        });
    </script>
@endsection