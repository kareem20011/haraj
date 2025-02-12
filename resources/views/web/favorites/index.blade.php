@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('contents.favorites') }}
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
        <!-- Ads Section -->
        <div class="col-md-12">
            <div class="row" id="ads">
                @forelse($userWithFavProducts->favorites as $row)
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
                            <img loading="lazy" src="https://via.placeholder.com/150x150" alt="Ad Image" class="img-fluid w-100 h-100 ad-image-size" style="object-fit: cover;">
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
</div>

@endsection