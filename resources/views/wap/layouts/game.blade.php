<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" href="images/favicon.png">
	<title>{{config('app.name')}}</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('wap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/lightbox.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/line-awesome.css')}}">
	<link rel="stylesheet" href="{{asset('wap/css/line-awesome-font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/sweetalert/sweetalert.css')}}">
	
	<!-- material color style light -->
	<link rel="alternate stylesheet" type="text/css" href="{{asset('wap/colors/material-color/style-blue.css')}}" title="material-style-blue" />
	
	<!-- default style -->
	<link rel="stylesheet" type="text/css" href="{{asset('wap/css/style.css')}}" title="default" />
    <link rel="stylesheet" type="text/css" href="{{asset('wap/css/custom.css')}}" title="default" />
    
    @yield('style')

</head>
<body class="animsition">
    <div id="ajax-loading" class="text-center">
        <img class="mx-auto" src="{{asset('images/loader.gif')}}" width="70" alt="" style="margin:45vh auto;">
    </div>
	    
    @yield('content')    
    
	<script src="{{asset('wap/js/jquery.min.js')}}"></script>
	<script src="{{asset('wap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('wap/js/lightbox.js')}}"></script>
	<script src="{{asset('wap/js/waves.js')}}"></script>
    <script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('backend/plugins/sweetalert/sweetalert.min.js')}}"></script>

    @yield('script')

    <script>

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