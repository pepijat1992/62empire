<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name', '26Wins') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
        <link href="https://fonts.googleapis.com/css?family=Cabin&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}"></link>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></link>
        <link rel="stylesheet" href="{{asset('web/css/style.css')}}"></link>

        {{-- <link href="{{asset('web/js/app.fcb567bf.js')}}" rel="preload" as="script">
        <link href="{{asset('web/js/chunk-vendors.e7e65bdb.js')}}" rel="preload" as="script"> --}}
        <link href="{{asset('web/css/components.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('backend/plugins/toastr/toastr.css')}}">
        <link rel="stylesheet" href="{{asset('backend/plugins/sweetalert/sweetalert.css')}}">

        @yield('style')

    </head>

    <body>
        @auth
            @php
                $bonus_amount = $_user->free_bonuses()->where('status', 0)->sum('amount');
            @endphp
            @if ($bonus_amount > 0)            
                <div id="bonus_splash">
                    <img src="{{asset('images/get_bonus.gif')}}" width="300px" height="300px" alt="">
                    <h3 class="text-center text-success">You got free bonus {{$bonus_amount}}.</h3>
                </div>
            @endif
        @endauth
        <div id="app">
            @include('web.layouts.header')
    
            @yield('content')
            
            @include('web.layouts.social')

            @include('web.layouts.footer')
        </div>

        <div id="overlay">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <script type="text/javascript" src="{{asset('web/js/jquery-3.4.1.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('web/js/bootstrap.bundle.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('web/js/custom.js')}}"></script>

        {{-- <script type="text/javascript" src="{{asset('web/js/chunk-vendors.e7e65bdb.js')}}"></script>
        <script type="text/javascript" src="{{asset('web/js/app.fcb567bf.js')}}"></script> --}}

        <script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
        <script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('backend/plugins/clipboard/clipboard.min.js')}}"></script>
        <script src="{{asset('backend/plugins/sweetalert/sweetalert.min.js')}}"></script>
        
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('script')

        <script>
            var notification = '{!! session()->get("success"); !!}';
            if(notification != ''){
                toastr_call("success","{{__('words.success')}}",notification);
            }
            var errors_string = '{!! json_encode($errors->all()); !!}';
            errors_string=errors_string.replace("[","").replace("]","").replace(/\"/g,"");
            var errors = errors_string.split(",");
            if (errors_string != "") {
                for (let i = 0; i < errors.length; i++) {
                    const element = errors[i];
                    toastr_call("error", "{{__('words.error')}}", element);             
                } 
            }       

            function toastr_call(type,title,msg,override){
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }  
                toastr[type](msg, title,override);
            }

            $(".btn-confirm").click(function(e){
                e.preventDefault();
                let url = $(this).attr('href');
                swal({
                    title: "{{__('words.are_you_sure')}}",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('words.yes')}}",
                    cancelButtonText: "{{__('words.cancel')}}",
                },function() {
                    location.href = url
                })
            });
            function show_loading() {
                $("#overlay").fadeIn();
            };
            
            function hide_loading() {
                $("#overlay").fadeOut();
            };
        </script>
    </body>

</html>