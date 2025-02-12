<div class="topbar transition">
    <div class="bars">
        <button type="button" class="btn transition" id="sidebar-toggle">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="menu">
        <ul>
            <li class="nav-item">
                <a class="nav-link rounded btns" href="{{ route('lang') }}"><i class="fa-solid fa-language"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/users-avatar/' . (auth()->user()->avatar)) }}">
                    @else
                    <img src="{{ asset('assets/images/avatar.png') }}">
                    @endif
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route( 'profile.index' ) }}"><i class="fa fa-user size-icon-1"></i> <span>My
                            {{ __('contents.profile') }}</span>
                    </a>

                    <a class="dropdown-item" href="settings.html"><i class="fa fa-cog size-icon-1"></i>
                        <span>Settings</span>
                    </a>

                    <hr class="dropdown-divider">

                    <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt  size-icon-1"></i>
                        <span>{{ __('contents.logout') }}</span>
                    </a>

                    <form action="{{ route('logout') }}" method="post" style="display: none;" id="logout-form">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </div>
</div>