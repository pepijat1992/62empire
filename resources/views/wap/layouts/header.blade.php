<div class="navbar">
    <div class="container">
        <div class="content-left">
            <a href="{{route('wap.index')}}"><h3 class="text-light">{{config('app.name')}}</h3></a>
        </div>
        <div class="content-center">
            @auth
                <h5 class="text-light mt-2"><span class="">{{__('words.balance')}} : </span>{{$_user->score}}</h5>
            @endauth
        </div>
        <div class="content-right">
            <div class="dropdown dropdown-lang">
                @php $locale = session()->get('locale'); @endphp
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    @switch($locale)
                        @case('en')
                            <img src="{{asset('images/lang/en.png')}}" width="28"></span>
                            @break
                        @case('malaya')
                            <img src="{{asset('images/lang/malaya.png')}}" width="28"></span>
                            @break
                        @case('zh_cn')
                            <img src="{{asset('images/lang/zh_cn.png')}}" width="28"></span>
                            @break
                        @default
                            <img src="{{asset('images/lang/en.png')}}" width="28"></span>                            
                    @endswitch
                </a>
                <ul class="dropdown-menu dropdown-menu-right p-0">
                    <li><a class="dropdown-item pt-2 pl-2" href="{{route('lang', 'en')}}"><img src="{{asset('images/lang/en.png')}}" class="rounded-circle" width="28" height="28"> English</a></li>
                    <li><a class="dropdown-item pt-1 pl-2" href="{{route('lang', 'malaya')}}"><img src="{{asset('images/lang/malaya.png')}}" class="rounded-circle" width="28" height="28"> Malay</a></li>
                    <li><a class="dropdown-item pt-1 pl-2" href="{{route('lang', 'zh_cn')}}"><img src="{{asset('images/lang/zh_cn.png')}}" class="rounded-circle" width="28" height="28"> 简体中文</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>