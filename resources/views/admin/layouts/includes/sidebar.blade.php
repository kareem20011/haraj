<div class="sidebar transition overlay-scrollbars animate__animated  animate__slideInLeft">
    <div class="sidebar-content">
        <div id="sidebar">
            <!-- Logo -->
            <div class="logo">
                <h2 class="mb-0">{{ auth()->user()->name }}</h2>
            </div>

            <ul class="side-menu">
                <!-- home -->
                <li>
                    <a href="{{ route('admin.home') }}" class="{{ Route::currentRouteName() == 'admin.home' ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge icon"></i> {{ __('titles.dashboard') }}
                    </a>
                </li>

                <!-- categories -->
                <li>
                    <a href="{{ route( 'admin.categories.index' ) }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-house icon"></i> {{ __('contents.categories') }}
                    </a>
                </li>

                <!-- subcategories -->
                <li>
                    <a href="{{ route( 'admin.subcategories.index' ) }}" class="{{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-house icon"></i> {{ __('contents.subcategories') }}
                    </a>
                </li>

                <!-- website -->
                <li>
                    <a href="/">
                        <i class="fa-solid fa-house icon"></i> {{ __('titles.brand') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>