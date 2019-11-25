@php
    $page = config('site.wap_footer');
@endphp
<div class="footer-nav">
    <div class="container">        
        <ul>
            <li>
                @auth('agent')
                    <a href="{{route('agent.logout')}}" class="waves-effect waves-light">
                        <i class="footer-icon fa fa-sign-out"></i>
                        <p class="footer-link-text">{{__('words.sign_out')}}</p>
                    </a>
                @endauth
                @auth
                    <a href="{{route('logout')}}" class="waves-effect waves-light">
                        <i class="footer-icon fa fa-sign-out"></i>
                        <p class="footer-link-text">{{__('words.sign_out')}}</p>
                    </a>
                @endauth
                @guest
                    <a href="{{route('login')}}" class="waves-effect waves-light @if($page == 'sign_in') active @endif">
                        <i class="footer-icon fa fa-sign-in"></i>
                        <p class="footer-link-text">{{__('words.sign_in')}}</p>
                    </a>
                @endguest
            </li>
            <li>
                <a href="http://bit.ly/2XdrVz4" target="_blank">
                    <i class="footer-icon fa fa-whatsapp"></i>
                    <p class="footer-link-text">{{__('words.contacts')}}</p>
                </a>
            </li>
            <li>
                <a href="{{route('wap.index')}}" class="waves-effect waves-light @if($page == 'game') active @endif">
                    <i class="footer-icon fa fa-gamepad"></i>
                    <p class="footer-link-text">{{__('words.games')}}</p>
                </a>
            </li>
            <li>
                @auth('agent')
                    <a href="{{route('agent.wap.index')}}" class="@if($page == 'me') active @endif">
                        <i class="footer-icon fa fa-user"></i>
                        <p class="footer-link-text">{{__('words.me')}}</p>
                    </a>
                @endauth
                @auth
                    <a href="{{route('wap.home')}}" class="waves-effect waves-light @if($page == 'me') active @endif">
                        <i class="footer-icon fa fa-user"></i>
                        <p class="footer-link-text">{{__('words.me')}}</p>
                    </a>
                @endauth 
                @guest
                    <a href="{{route('wap.home')}}" class="waves-effect waves-light @if($page == 'me') active @endif">
                        <i class="footer-icon fa fa-user"></i>
                        <p class="footer-link-text">{{__('words.me')}}</p>
                    </a>
                @endguest
            </li>
        </ul>
    </div>
</div>