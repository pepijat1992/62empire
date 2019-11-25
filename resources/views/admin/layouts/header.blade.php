<nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
    <div class="sidebar-toggle-icon" id="sidebarCollapse">
        sidebar toggle<span></span>
    </div>
    <div class="d-flex flex-grow-1">
        <ul class="navbar-nav flex-row align-items-center ml-auto">            
            <li class="nav-item dropdown dropdown-lang mr-3">
                @php $locale = session()->get('locale'); @endphp
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    @switch($locale)
                        @case('en')
                            <img src="{{asset('images/lang/en.png')}}" width="28"><span> English</span>
                            @break
                        @case('malaya')
                            <img src="{{asset('images/lang/malaya.png')}}" width="28"><span> Malay</span>
                            @break
                        @case('zh_cn')
                            <img src="{{asset('images/lang/zh_cn.png')}}" width="28"><span> 简体中文</span>
                            @break
                        @default
                            <img src="{{asset('images/lang/en.png')}}" width="28"><span> English</span>                            
                    @endswitch
                </a>
                <ul class="dropdown-menu dropdown-menu-right p-2" style="min-width: 8rem; top:45px;">
                    <li><a class="dropdown-item pt-2 pl-2" href="{{route('lang', 'en')}}"><img src="{{asset('images/lang/en.png')}}" class="rounded-circle" width="28" height="28"> English</a></li>
                    <li><a class="dropdown-item pt-1 pl-2" href="{{route('lang', 'malaya')}}"><img src="{{asset('images/lang/malaya.png')}}" class="rounded-circle" width="28" height="28"> Malay</a></li>
                    <li><a class="dropdown-item pt-1 pl-2" href="{{route('lang', 'zh_cn')}}"><img src="{{asset('images/lang/zh_cn.png')}}" class="rounded-circle" width="28" height="28"> 简体中文</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown user-menu">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="far fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right py-2" >
                    <div class="dropdown-header d-sm-none">
                        <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <a href="{{route('admin.change_password')}}" class="dropdown-item"><i class="fas fa-lock"></i> {{__('words.change_password')}}</a>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> {{__('words.sign_out')}}</a>
                </div>
            </li>
        </ul>
    </div>
</nav>