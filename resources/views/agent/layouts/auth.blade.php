<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="26WINS">
        <meta name="author" content="Yuyuan Z">
        <title>{{config('app.name')}}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
        <!--Global Styles(used by all pages)-->
        <link href="{{asset('backend/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/fontawesome/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/typicons/src/typicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/themify-icons/themify-icons.min.css')}}" rel="stylesheet">

        <!--Start Your Custom Style Now-->
        <link href="{{asset('backend/dist/css/style.css')}}" rel="stylesheet">
        <style>
            .panel {
                box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22) !important;
            }
        </style>
    </head>
    <body class="main-background">
        <div class="d-flex align-items-center justify-content-center text-center h-100vh">
            <div class="form-wrapper m-auto">
                <div class="form-container my-4">
                    <a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" width="30px" alt=""></a>
                    @yield('content')
                </div>
            </div>
        </div>
        
        <!--Global script(used by all pages)-->
        <script src="{{asset('backend/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('backend/dist/js/popper.min.js')}}"></script>
        <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('backend/plugins/metisMenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('backend/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
    </body>
</html>