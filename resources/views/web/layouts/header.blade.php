
@php
    $page = config('site.page');
@endphp
<header id="header">
    <div class="main-header">
        <div class="container">
            <div class="row w-100">
                <div class="col-md-3 logo py-3">
                    <a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" width="310"></a>
                </div>
                <div class="col-md-9 pt-2 m-auto header-info d-block">
                    <div class="row">
                        <div id="wallet-applet" class="col-md-9 text-center">
                            @auth                                
                                <ul class="justify-content-around">
                                    <li class="child"><a href="{{route('web.deposit')}}">{{__('words.deposit')}}</a></li> 
                                    <li class="child"><a href="{{route('web.withdraw')}}">{{__('words.withdraw')}}</a></li>
                                    <li class="child"><a href="{{route('web.transfer')}}">{{__('words.transfer')}}</a></li> 
                                </ul> 
                                <div class="line"></div> 
                                <p class="p-3">{{__('words.balance')}}: <span>MYR</span> <span id="balance" class="d-flex-fill monetary">{{$_user->score}}</span> 
                                    {{-- <button class="refresh"><i aria-hidden="true" class="fa fa-refresh"></i></button> --}}
                                </p>
                            @endauth
                            @guest
                                <div class="float-right text-uppercase mt-2">
                                    <a href="{{route('login')}}" class="btn btn-primary mr-3 @if($page == 'sign_in') active @endif">{{__('words.sign_in')}}</a>
                                    <a href="{{route('register')}}" class="btn btn-secondary @if($page == 'sign_up') active @endif">{{__('words.sign_up')}}</a>
                                </div>
                            @endguest
                        </div> 
                        <div class="col d-none d-md-block">                            
                            <div class="dropdown dropdown-lang py-1 mt-2">
                                @php $locale = session()->get('locale'); @endphp
                                <a href="#" class="dropdown-toggle d-block pl-2" data-toggle="dropdown" aria-expanded="true">
                                    @switch($locale)
                                        @case('en')
                                            <img src="{{asset('images/lang/en.png')}}" width="28"><span>  English</span>
                                            @break
                                        @case('malaya')
                                            <img src="{{asset('images/lang/malaya.png')}}" width="28"><span>  Malaya</span>
                                            @break
                                        @case('zh_cn')
                                            <img src="{{asset('images/lang/zh_cn.png')}}" width="28"><span>  简体中文</span>
                                            @break
                                        @default
                                            <img src="{{asset('images/lang/en.png')}}" width="28"><span>  English</span>                            
                                    @endswitch
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left p-0">
                                    <li><a class="dropdown-item pt-2 pl-2" href="{{route('lang', 'en')}}"><img src="{{asset('images/lang/en.png')}}" class="rounded-circle" width="28" height="28"> English</a></li>
                                    <li><a class="dropdown-item pt-1 pl-2" href="{{route('lang', 'malaya')}}"><img src="{{asset('images/lang/malaya.png')}}" class="rounded-circle" width="28" height="28"> Malay</a></li>
                                    <li><a class="dropdown-item pt-1 pl-2" href="{{route('lang', 'zh_cn')}}"><img src="{{asset('images/lang/zh_cn.png')}}" class="rounded-circle" width="28" height="28"> 简体中文</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="main_navi">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="main_navbar navbar navbar-expand-md p-0">
                        <ul id="navbarToggle" class="menu collapse navbar-collapse justify-content-center">

                            <li class="d-inline d-md-inline-block">
                                <a href="{{route('web.index')}}" class="@if($page == 'home') active @endif">{{__('words.home')}}</a>
                            </li>

                            <li class="d-inline d-md-inline-block">
                                <a href="{{route('web.casino')}}" class="@if($page == 'casino') active @endif">{{__('words.online_casino')}}</a>
                            </li>

                            <li class="d-inline d-md-inline-block">
                                <a href="{{route('web.hot_game')}}" class="@if($page == 'hot_game') active @endif">{{__('words.hot_games')}}</a>
                            </li>

                            <li class="d-inline d-md-inline-block">
                                <a href="{{route('web.lottery')}}" class="@if($page == 'lottery') active @endif">{{__('words.lottery')}}</a>
                            </li>

                            @auth                                
                                @php
                                    $wallet_pages = ['deposit', 'withdraw', 'transfer'];
                                @endphp
                                <li class="d-inline d-md-inline-block">
                                    <a href="{{route('web.profile')}}" class="@if($page == 'profile') active @endif">{{__('words.profile')}}</a>
                                </li>
                                <li class="d-inline d-md-inline-block">
                                    <a href="{{route('web.deposit')}}" class="@if(in_array($page, $wallet_pages)) active @endif">{{__('words.wallet')}}</a>
                                </li>
                            @endauth

                            <li class="d-inline d-md-inline-block">
                                <a href="{{route('web.promotion')}}" class="@if($page == 'promotion') active @endif">{{__('words.promotions')}}</a>
                            </li>

                            @auth                                
                                <li class="d-inline d-md-inline-block">
                                    <a href="{{route('logout')}}" class="">{{__('words.sign_out')}}</a>
                                </li>
                            @endauth

                            {{-- @guest
                                                           
                                <li class="d-inline d-md-inline-block">
                                    <a href="{{route('login')}}" class="@if($page == 'sign_in') active @endif">{{__('words.sign_in')}}</a>
                                </li>

                                <li class="d-inline d-md-inline-block">
                                    <a href="{{route('register')}}" class="@if($page == 'sign_up') active @endif">{{__('words.sign_up')}}</a>
                                </li> 
                            @endguest  --}}

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>

    <div class="membertron">
        <ul class="nav text-center d-sm-none">
            <li class="nav-item flex-fill h4 m-auto pt-1">
                <a href="{{route('login')}}"><i class="fa fa-sign-in"></i><p class="h6">{{__('words.sign_in')}}</p></a>
            </li>
            <li class="nav-item flex-fill h4 m-auto pt-1">
                <a href="{{route('register')}}"><i class="fa fa-user-o"></i><p class="h6">{{__('words.sign_up')}}</p></a>
            </li>
        </ul>
    </div>
</header>