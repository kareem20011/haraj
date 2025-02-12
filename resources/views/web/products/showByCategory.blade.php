@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ $catName }}
@endsection
@section('content')


@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close btn btn-link p-0 border-0" data-bs-dismiss="alert" aria-label="Close">
        <i aria-hidden="true" class="fa-solid fa-xmark"></i>
    </button>
    {{ session('success') }}
</div>
@endif


<!-- Main Content -->
<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 order-md-last">
            <div class="sidebar">
                <h5>{{ __('contents.filters') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="#">جميع المناطق</a></li>
                    <li><a href="#">القريب</a></li>
                    <li><a href="#">الأحدث</a></li>
                </ul>
                <hr>
                <h6>{{ __('contents.quick-navigate') }}</h6>
                <div class="quick-filter-wrapper d-flex">
                    @forelse($quick_navigates as $row)
                    <a href="{{ route('subcategories.showProducts', $row['id']) }}" class="btn btn-outline-secondary btn-sm">{{ $row['name'] }}</a>
                    @empty
                    <a class="btn btn-outline-secondary btn-sm">{{ __('contents.no-items') }}</a>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="container mb-4">
            <div class="categories-wrapper d-flex">
                @foreach($categories as $row)
                <div class="card category-card border-0 {{ $category->id === $row->id ? 'active-category' : '' }}">
                    <div class="card-body text-center">
                        <img loading="lazy" loading="lazy" src="{{$row->getFirstMediaUrl()}}" width="30">
                        <a href="{{ route('categories.showProducts', $row->id) }}" class="d-block mt-3 text-decoration-none text-dark dark-mode-link">
                            {{ session('locale') == 'ar' ? $row->name_ar : $row->name_en }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Subcategories -->
        <div class="container mb-4">
            <div class="categories-wrapper d-flex">
                @foreach($category->subcategories as $row)
                <div class="card category-card border-0 {{ isset($subcategory) && $subcategory->id == $row->id ? 'active-category' : ''}}">
                    <div class="card-body text-center">
                        <a
                            href="{{ route('subcategories.showProducts', $row->id) }}"
                            class="d-block py-1 px-4 text-decoration-none text-dark dark-mode-link">
                            {{ session('locale') == 'ar' ? $row->name_ar : $row->name_en }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ads Section -->
        <div class="col-md-8" id="ads">

            @forelse($category->products as $row)
            <div class="ad-card overflow-hidden" style="direction: rtl;" data-id="{{ $row->id }}">
                <a href="{{ route('products.show', $row->id) }}" class="text-end ad-title">{{ $row->title }}</a>
                <div class="d-flex justify-content-between align-items-end">
                    <!-- (Comments count, Location) -->
                    <div class="d-flex flex-column justify-content-between">
                        <div class="ad-info">
                            <p class="text-secondary mb-1 ad-text">{{ $row->location }}</p>
                            <p class="text-secondary mb-0 ad-text">{{ __('contents.comments') }}: {{ count($row->comments) }}</p>
                        </div>
                    </div>

                    <!-- (Publish date, Price, Publisher) -->
                    <div class="d-flex flex-column text-end mt-2">
                        <span class="text-secondary mb-1 ad-text">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</span>
                        <span class="text-primary fw-bold d-block mb-1 ad-text">{{ $row->price }} ريال</span>
                        <div class="text-secondary ad-text">
                            <i class="fa-solid fa-user me-1"></i>{{ $row->creator->name }}
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="ad-image">
                        @if($row->getMedia()->isNotEmpty())
                        <img loading="lazy" src="{{ $row->getMedia()->first()->getUrl() }}" alt="Ad Image" class="img-fluid w-100 h-100 ad-image-size" style="object-fit: cover;">
                        @else
                        <img loading="lazy" src="{{ asset('assets/images/default-product.jpg') }}" alt="Ad Image" class="img-fluid w-100 h-100 ad-image-size" style="object-fit: cover;">
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <h3 class="text-center" style="font-size: 1.25rem;">{{__('contents.no-items')}}</h3>
            @endforelse
        </div>

    </div>
</div>

@endsection