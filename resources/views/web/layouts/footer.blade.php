<footer>
    <div class="container">
        {{-- <div class="row text-white p-3 m-3 bg-dark">
            <h6>RESPONSIBLE GAMBLING</h6>
            <p>
                We care about our players and want to ensure that any time spent with us stays fun. Betting should always be within your means and not negatively impacting you either financially or socially. Borrowing money to play, spending above your budget or using money allocated for other purposes is not only unwise but can lead to significant problems for you and others around you. We want you to enjoy playing on 26Wins, so bet responsibly and have fun!
            </p>
        </div> --}}
        <div class="line"></div>
        <div class="row">
            <div id="footer-bank" class="col-md-12 text-center">
                <i class="bank-myr bank-maybank"></i>
                <i class="bank-myr bank-cimb"></i>
                <i class="bank-myr bank-rhb"></i>
                <i class="bank-myr bank-public"></i>
                <i class="bank-myr bank-bsn"></i>
                <i class="bank-myr bank-ambank"></i>
                <i class="bank-myr bank-hongleong"></i>
            </div>
        </div>
        <div class="line"></div>
        <div class="row mt-2">
            <div class="col-md-12">

                <nav>
                    <ul class="nav footer_nav">

                        <li><a href="{{route('web.index')}}">{{__('words.home')}}</a></li>

                        <li><a href="{{route('web.casino')}}">{{__('words.online_casino')}}</a></li>

                        <li><a href="{{route('web.hot_game')}}">{{__('words.hot_games')}}</a></li>

                        <li><a href="{{route('web.lottery')}}">{{__('words.lottery')}}</a></li>

                        @guest

                            <li><a href="{{route('login')}}">{{__('words.sign_in')}}</a></li>

                            <li><a href="{{route('register')}}">{{__('words.sign_up')}}</a></li>
                            
                        @endguest

                        @auth

                            <li><a href="{{route('logout')}}">{{__('words.sign_out')}}</a></li>

                        @endauth                        

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="foo_copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    Copyright &copy; 2019 26Wins. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<ul class="nav fixed-bottom text-center d-sm-none">
    <li class="nav-item flex-fill h4 m-auto">
        <a href="{{route('wap.index')}}">
            <i class="fa fa-home"></i>
            <p class="h6">{{__('words.home')}}</p>
        </a>
    </li>
    <li class="nav-item flex-fill h4 m-auto">
        <a href="{{route('wap.online_deposit')}}">
            <i class="fa fa-arrow-circle-o-down"></i>
            <p class="h6">{{__('words.deposit')}}</p>
        </a>
    </li>
    <li class="nav-item flex-fill rounded-circle h2 active nav-item-wallet">
        <a href="{{route('wap.wallet')}}">
            <i class="fa fa-dollar"></i>
            <p class="h5">{{__('words.wallet')}}</p>
        </a>
    </li>
    <li class="nav-item flex-fill h4 m-auto">
        <a href="{{route('wap.online_withdraw')}}">
            <i class="fa fa-arrow-circle-o-up"></i>
            <p class="h6">{{__('words.withdraw')}}</p>
        </a>
    </li>
    <li class="nav-item flex-fill h4 m-auto">
        <a href="{{route('web.promotion')}}">
            <i class="fa fa-gift"></i>
            <p class="h6">{{__('words.promotion')}}</p>
        </a>
    </li>
</ul>