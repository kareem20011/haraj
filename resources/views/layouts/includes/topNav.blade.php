@php
$lang = Session::get('locale', app()->getLocale());
$categories = \App\Models\Category::select('id', "name_{$lang} as name")->limit(5)->get();
@endphp
<nav class="top-nav navbar">
    <ul class="w-100 top-nav-ul d-flex justify-content-between categories-wrapper">
        <li class="nav-item"><span><a href="{{ route( 'favorites.index' ) }}" class="nav-link">{{ __('contents.favorites') }}</a></span></li>
        @foreach($categories as $cat)
        <li class="nav-item">
            <span>
                <a class="nav-link" href="{{ route('categories.showProducts', $cat->id) }}">{{ $cat->name }} <img loading="lazy" src="{{ $cat->getFirstMediaUrl() }}" width="15"></a>
            </span>
        </li>
        @endforeach
        <li class="nav-item">
            <a class="nav-link" href="/">{{ __('contents.home') }}</a>
        </li>
    </ul>
</nav>