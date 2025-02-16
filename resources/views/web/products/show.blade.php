@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.product-showing') }} - {{ $product->title }}
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


<!-- Main Content Section -->
<div dir="rtl" class="container my-3">
    <a class="h1 text-primary my-3 d-block" href="{{ route('home') }}"><i class="fa-solid fa-arrow-right"></i></a>
    <div class="row">
        <!-- Product Carousel Section -->
        <div class="col-md-8">
            <div class="ad-card card mb-3">

                <div class="card-head w-75">

                    <h3 class="text-success">{{$product->title}}</h3>

                    <div class="d-flex justify-content-between">
                        <span class="text-primary"><i class="fa-solid fa-location-dot"></i> {{$product->location}}</span>
                        <small class="text-secondary"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</small>
                    </div>

                    <br>

                    <div class="seller-profile">
                        <img loading="lazy" src="{{ $product->creator->avatar ? asset('storage/users-avatar/' . $product->creator->avatar) : asset('assets/images/avatar.png') }}"
                            alt="Seller Profile"
                            width="50"
                            class="img-thumbnail rounded-circle">
                        <span class="text-primary">{{ $product->creator->name }}</span>
                    </div>
                    <br>
                </div>

                <div class="card-body">
                    <p>{{ $product->description }}</p>

                    <!-- Product Image Carousel -->
                    @foreach ($product->getMedia() as $index => $media)
                    <div class="my-3 p-3">
                        <img loading="lazy" src="{{ $media->getUrl() }}" class="d-block w-100" alt="Product Image {{ $index + 1 }}">
                    </div>
                    @endforeach

                    <!-- contact seller -->
                    <a href="{{ route('chat.getMessages', $product->creator->id) }}" class="btn btn-primary text-white"><i class="fa-solid fa-phone-flip"></i> {{ __('contents.contact-seller') }}</a>
                </div>
            </div>
        </div>


    </div>

    <!-- Comments Section -->
    <div class="row mt-4">
        <!-- Existing Comments Section -->
        <div class="col-md-12 mt-3">
            <!-- Bootstrap Card for Existing Comments -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">{{ __('contents.existing-comments') }}</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($comments as $row)
                    <!-- Single Comment -->
                    <div class="d-flex align-items-start mb-4">
                        <!-- User Avatar -->
                        <img loading="lazy" src="{{ $product->creator->avatar ? asset('storage/users-avatar/' . $product->creator->avatar) : asset('assets/images/avatar.png') }}"
                            alt="Seller Profile"
                            width="50"
                            class="img-thumbnail rounded-circle">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1">{{ $row->user->name }}</h6>
                                <small class="text-secondary">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-dark">{{ $row->comment }}</p>
                        </div>
                    </div>
                    <hr>
                    @empty
                    <div class="text-center text-secondary">
                        <h6>{{ __('contents.no-comments') }}</h6>
                    </div>
                    @endforelse
                </div>

                <div class="card-footer bg-light">
                    <h6 class="fw-bold mb-3">{{ __('contents.leave-comment') }}</h6>
                    <form action="{{ route('comments.store', $product->id ) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="3" placeholder="{{ __('contents.leave-comment-here') }}" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm">{{ __('contents.post') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Related Products Section -->
    <div class="row mt-4">
        <h4 class="text-center">{{ __('contents.related-products') }}</h4>
        @forelse($relatedProducts as $row)
            @if($row->id != $product->id)
                <div class="col-12 mb-3">
                    <div class="ad-card d-flex shadow-sm rounded overflow-hidden">
                        <!-- Image Section -->
                        <div class="ad-image" style="flex: 0 0 150px; height: 150px;">
                            @if($row->getMedia()->isNotEmpty())
                            <img loading="lazy" src="{{ $row->getMedia()->first()->getUrl() }}" alt="Ad Image" class="img-fluid w-100 h-100 ad-image-size" style="object-fit: cover;">
                            @else
                            <img loading="lazy" src="{{ asset('assets/images/default-product.jpg') }}" alt="Ad Image" class="img-fluid w-100 h-100 ad-image-size" style="object-fit: cover;">
                            @endif
                        </div>
                        <!-- Content Section -->
                        <div class="flex-grow-1 p-3">
                            <!-- Product Details -->
                            <a href="{{ route('products.show', $row->id) }}" class="h5 text-dark d-block text-truncate mb-2 ad-title">{{ $row->title }}</a>
                            <p class="text-secondary small mb-3">{{ $row->location }} | {{ $row->subcategory_name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Creator Details -->
                                <div class="text-secondary small">
                                    <i class="fa-solid fa-user me-1"></i>{{ $row->creator->name }}
                                </div>
                                <!-- Price and Date -->
                                <div class="text-end">
                                    <span class="text-primary fw-bold small d-block mb-1">{{ $row->price }} ريال</span>
                                    <span class="text-secondary small">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
        <h3 class="text-center">{{__('contents.no-items')}}</h3>
        @endforelse
        <!-- You can add more related products in similar columns -->
    </div>
</div>


@endsection