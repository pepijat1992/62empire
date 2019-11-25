@php
    $page = config('site.page');
@endphp
<nav class="sidebar sidebar-bunker">
    <div class="sidebar-header">
        <a href="{{route('agent.home')}}" class="logo mx-auto"><span>{{config('app.name')}}</span></a>
    </div>
    <hr class="my-0 bg-success">
    <div class="profile-element d-flex align-items-center flex-shrink-0">
        <div class="avatar online">
            <img src="{{asset('images/avatar128.png')}}" class="img-fluid rounded-circle" alt="">
        </div>
        <div class="profile-text">
            <h6 class="m-0">{{$_agent->username}}</h6>
        </div>
    </div>
    <div class="sidebar-body">
        <nav class="sidebar-nav">
            <ul class="metismenu">
                <li class="@if($page == 'home') mm-active @endif"><a href="{{route('agent.home')}}"><i class="fas fa-tachometer-alt mr-2"></i> {{__('words.dashboard')}}</a></li>  
                <li class="@if($page == 'user') mm-active @endif"><a href="{{route('agent.user.index')}}"><i class="fas fa-user-friends mr-2"></i> {{__('words.user_management')}}</a></li>        
                
                @php
                    $sale_items = ['deposit', 'withdraw'];
                @endphp
                <li>
                    <a class="has-arrow material-ripple" href="#">
                        <i class="fas fa-money-bill-alt mr-2"></i>
                        {{__('words.financial_management')}}
                    </a>
                    <ul class="nav-second-level">
                        <li class="@if($page == 'deposit') mm-active @endif"><a href="{{route('agent.deposit.index')}}">{{__('words.top_up')}}</a></li>
                        <li class="@if($page == 'withdraw') mm-active @endif"><a href="{{route('agent.withdraw.index')}}">{{__('words.withdraw')}}</a></li>
                        <li class="@if($page == 'credit_transaction') mm-active @endif"><a href="{{route('agent.credit_transaction.index')}}">{{__('words.credit_transaction')}}</a></li>
                    </ul>
                </li>

                <li class="@if($page == 'game_account') mm-active @endif"><a href="{{route('agent.game_account.index')}}"><i class="fas fa-user-secret mr-2"></i>&nbsp;&nbsp;{{__('words.game_accounts')}}</a></li>        
                <li class="@if($page == 'game_transaction') mm-active @endif"><a href="{{route('agent.game_transaction')}}"><i class="fas fa-history mr-2"></i>&nbsp;&nbsp;{{__('words.transaction_history')}}</a></li>

            </ul>
        </nav>
    </div>
</nav>