<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="config('app.name')">
        <meta name="author" content="phyzerbert">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
        <!--Global Styles(used by all pages)-->
        <link href="{{asset('backend/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/fontawesome/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/typicons/src/typicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/themify-icons/themify-icons.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/toastr/toastr.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/daterangepicker/daterangepicker.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
        <!--Start Your Custom Style Now-->
        <link href="{{asset('backend/dist/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('backend/dist/css/custom.css')}}" rel="stylesheet">
        @yield('style')
    </head>
    <body class="fixed">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <div class="wrapper">            
            @include('admin.layouts.aside')
            <div class="content-wrapper">
                <div class="main-content">
                    @include('admin.layouts.header')
                    @yield('content')
                <div class="overlay"></div>
            </div>
        </div>
        <script src="{{asset('backend/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('backend/dist/js/popper.min.js')}}"></script>
        <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('backend/plugins/metisMenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('backend/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
        <script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('backend/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
        <script src="{{asset('backend/plugins/sweetalert/sweetalert.min.js')}}"></script>

        <!--Page Scripts(used by all page)-->
        <script src="{{asset('backend/dist/js/sidebar.js')}}"></script>
        <script>
            $('[data-toggle="tooltip"]').tooltip();
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
                toastr_call("success","Success",notification);
            }
            var errors_string = '{!! json_encode($errors->all()); !!}';
            errors_string=errors_string.replace("[","").replace("]","").replace(/\"/g,"");
            var errors = errors_string.split(",");
            if (errors_string != "") {
                for (let i = 0; i < errors.length; i++) {
                    const element = errors[i];
                    toastr_call("error","Error",element);             
                } 
            }       

            function toastr_call(type,title,msg,override){
                toastr[type](msg, title,override);
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
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
            })
        </script>
    </body>
</html>