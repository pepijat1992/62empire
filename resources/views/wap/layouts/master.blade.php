<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="images/favicon.ico">
	<title>{{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('wap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/lightbox.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/line-awesome.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/line-awesome-font-awesome.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/animsition.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/switcher.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/sweetalert/sweetalert.css')}}">
	
	
	<!-- default style -->
	<link rel="stylesheet" type="text/css" href="{{asset('wap/css/style.css')}}" title="default" />
    <link rel="stylesheet" type="text/css" href="{{asset('wap/css/custom.css')}}" title="default" />
    
    @yield('style')

</head>
<body class="animsition">
    <div id="ajax-loading" class="text-center">
        <img class="mx-auto" src="{{asset('images/loader.gif')}}" width="70" alt="" style="margin:45vh auto;">
    </div>    
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
	@include('wap.layouts.header')
	    
    @yield('content')
    
    @include('wap.layouts.footer')	
    
	<script src="{{asset('wap/js/jquery.min.js')}}"></script>
	<script src="{{asset('wap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('wap/js/lightbox.js')}}"></script>
	<script src="{{asset('wap/js/animsition.min.js')}}"></script>
	<script src="{{asset('wap/js/animsition-custom.js')}}"></script>
	<script src="{{asset('wap/js/jquery.big-slide.js')}}"></script>
	<script src="{{asset('wap/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('wap/js/styleswitcher.js')}}"></script>
	<script src="{{asset('wap/js/waves.js')}}"></script>
    <script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('backend/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{asset('backend/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('wap/js/main.js')}}"></script>
    
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
            $("#ajax-loading").fadeIn();
        };
        
        function hide_loading() {
            $("#ajax-loading").fadeOut();
        };
    </script>
</body>
</html>