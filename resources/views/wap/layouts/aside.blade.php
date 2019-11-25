<div class="side-overlay"></div>
<div id="menu" class="panel sidebar" role="navigation">
    <div class="sidebar-header">
        <img src="images/profile.png" alt="">
        <span>John Doe</span>
    </div>
    <ul>
        <li><a href="{{route('home')}}"><i class="fa fa-home"></i>{{__('words.home')}}</a></li>
        @if(Auth::guest())
            <li><a href="{{route('login')}}"><i class="fa fa-sign-in"></i>{{__('words.sign_in')}}</a></li>
            <li><a href="{{route('register')}}"><i class="fa fa-user-plus"></i>{{__('words.sign_up')}}</a></li>
        @else
            <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i>{{__('words.sign_out')}}</a></li>
        @endif        
    </ul>
</div>