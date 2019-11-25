<nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
    <div class="sidebar-toggle-icon" id="sidebarCollapse">
        sidebar toggle<span></span>
    </div>
    <div class="d-flex flex-grow-1">
        <ul class="navbar-nav flex-row align-items-center ml-auto">
            <li class="nav-item mr-5">
                <h4 class="text-primary mt-2">{{__('words.balance')}}: <span class="badge badge-primary">{{$_agent->score}}</span></h4>
            </li>
            <li class="nav-item dropdown user-menu">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="far fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right py-2" >
                    <div class="dropdown-header d-sm-none">
                        <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <a href="{{route('agent.change_password')}}" class="dropdown-item"><i class="fas fa-lock"></i> {{__('words.change_password')}}</a>
                    <a href="{{ route('agent.logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> {{__('words.sign_out')}}</a>
                </div>
            </li>
        </ul>
    </div>
</nav>