@extends('web.layouts.master')
@section('style')    
    <link rel="stylesheet" href="{{asset('web/plugins/keypad/css/jquery.keypad.css')}}">
@endsection
@section('content')
    <div id="content" class="mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div id="main" class="col-md-8 col-lg-9 mx-auto">
                    <xx-sign-in ref="signin_form" inline-template>
                        <form action="{{route('post_check_passcode')}}" method="POST" id="passcode_form">
                            @csrf
                            <div class="dep_det_bx">
                                <h4 class="text-center">{{__('words.check_passcode')}}</h4>
                                <hr style="border-color: #ddd;" />
                                <div class="row">
                                    <div class="col-md-10 mt-4 mx-auto">
                                        <div class="form-group text-center">
                                            <input type="text" class="form-control mx-auto" name="passcode" style="width:178px;" id="input_passcode" placeholder="{{__('words.passcode')}}" maxlength="4" required>                            
                                            <div id="inline-keypad" class="mt-2 mx-auto" style="width:178px;"></div>
                                            @error('passcode')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary mx-auto" style="width:178px;" id="btn-sign-in">{{__('words.submit')}}</button>
                                        </div>
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
            $('#inline-keypad').keypad({onKeypress: appendValue, prompt: ''}); 
                    
            function appendValue(key) { 
                var field = $('#input_passcode'); 
                $.keypad.insertValue(field, key); 
                field.focus(); 
            }
        });
    </script>
@endsection