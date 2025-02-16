<nav id="my-nav" class="navbar navbar-expand-lg">
    <ul class="navbar-nav d-flex flex-row">
        <!-- dark/light mode -->
        <li class="nav-item me-2">
            <a class="nav-link rounded btns" id="toggle-mode">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sun" class="svg-inline--fa fa-sun fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                    <path fill="currentColor" d="M256 160c-52.9 0-96 43.1-96 96s43.1 96 96 96 96-43.1 96-96-43.1-96-96-96zm246.4 80.5l-94.7-47.3 33.5-100.4c4.5-13.6-8.4-26.5-21.9-21.9l-100.4 33.5-47.4-94.8c-6.4-12.8-24.6-12.8-31 0l-47.3 94.7L92.7 70.8c-13.6-4.5-26.5 8.4-21.9 21.9l33.5 100.4-94.7 47.4c-12.8 6.4-12.8 24.6 0 31l94.7 47.3-33.5 100.5c-4.5 13.6 8.4 26.5 21.9 21.9l100.4-33.5 47.3 94.7c6.4 12.8 24.6 12.8 31 0l47.3-94.7 100.4 33.5c13.6 4.5 26.5-8.4 21.9-21.9l-33.5-100.4 94.7-47.3c13-6.5 13-24.7.2-31.1zm-155.9 106c-49.9 49.9-131.1 49.9-181 0-49.9-49.9-49.9-131.1 0-181 49.9-49.9 131.1-49.9 181 0 49.9 49.9 49.9 131.1 0 181z"></path>
                </svg>
            </a>
        </li>

        <!-- locale -->
        <li class="nav-item me-2">
            <a class="nav-link rounded btns" href="{{ route('lang') }}"><i class="fa-solid fa-language"></i></a>
        </li>

        <!-- dashbaord -->
        @if(auth()->user() && auth()->user()->role == "admin")
        <li class="nav-item me-2">
            <a class="nav-link rounded btns" href="{{ route('admin.home') }}"><i class="fa-solid fa-gauge"></i></a>
        </li>
        @endif

        <!-- messages -->
        @if(auth()->user())
        <li class="nav-item me-2">
            <a class="nav-link rounded btns" href="{{ route('chat') }}"><i class="fa-solid fa-inbox"></i></a>
        </li>
        @endif

        <!-- login/logout -->
        <li class="nav-item me-2">
            @if(!auth()->user())
            <a class="nav-link rounded btns" href="{{ route('login') }}">{{ __('contents.login') }} <i class="fa-solid fa-right-to-bracket"></i></a>
            @else
            <!-- logout -->
            <form action="{{ route('logout') }}" method="post" class="nav-link rounded btns">
                @csrf
                <button class="webLogout"><span class="d-none d-sm-inline">{{ __('contents.logout') }}</span> <i class="fa-solid fa-right-from-bracket"></i></button>
            </form>
            @endif
        </li>
    </ul>

    <a class="navbar-brand ms-auto" href="/">{{ __('titles.brand') }}</a>
</nav>