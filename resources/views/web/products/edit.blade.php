@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.product-edit') }} - {{ $product->title }}
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>{{ __('contents.product-edit') }}</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <!-- Product images -->
                        <div class="col-md-12">
                            <div class="ad-card mb-3">
                                <!-- Product Image Carousel -->
                                <div id="productImages" class="carousel slide" data-bs-ride="carousel">
                                    <!-- Carousel Indicators -->
                                    <div class="carousel-indicators">
                                        @foreach ($product->getMedia() as $index => $media)
                                        <button type="button" data-bs-target="#productImages" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>

                                    <!-- Carousel Inner (Slides) -->
                                    <div class="carousel-inner">
                                        @foreach ($product->getMedia() as $index => $media)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img loading="lazy" src="{{ $media->getUrl() }}" class="d-block w-100" alt="Product Image {{ $index + 1 }}">
                                        </div>
                                        @endforeach

                                        <!-- Fallback image if no media is available -->
                                        @if ($product->getMedia()->isEmpty())
                                        <div class="carousel-item active">
                                            <img loading="lazy" src="https://via.placeholder.com/300x300" class="d-block w-100" alt="Fallback Image">
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Carousel Navigation (Prev & Next) -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#productImages" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#productImages" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <!-- Image Upload -->
                            <input type="file" name="images[]" class="form-control" multiple>
                        </div>

                        <!-- title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('contents.title') }}</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $product->title) }}" required>
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('contents.description') }}</label>
                            <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $product->description) }}" required>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('contents.price') }}</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- location -->
                        <div class="mb-3">
                            <label for="location" class="form-label">{{ __('contents.location') }}</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $product->location) }}">
                            @error('location')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- save  -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-sm">
                                {{ __('contents.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection