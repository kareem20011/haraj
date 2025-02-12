@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.home') }}
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


<div class="container my-4">
    <div class="row g-3">
        <!-- Top Create Product Button -->
        <div class="col-lg-3 col-md-4 col-12 text-center top-create-button-div">
            <a href="{{ route('categories.productCreation') }}" class="btn btn-main btn-sm w-100 d-none d-sm-block"><i class="fa-solid fa-plus"></i> {{ __('contents.add-your-post') }}</a>
        </div>

        <!-- Search Form -->
        <div class="col-lg-4 col-md-4 col-12">
            <form class="search d-flex w-100">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
                <input type="text" placeholder="{{ __('contents.search-here') }}" class="form-control form-control-sm me-2" id="searchInput">
            </form>
        </div>

        <!-- Create Product Button (For Small Screens) -->
        <div class="col-12 d-block d-sm-none mt-3 text-center create-button-div">
            <a href="{{ route('categories.productCreation') }}" class="btn btn-main btn-sm w-100"><i class="fa-solid fa-plus"></i> {{ __('contents.add-your-post') }}</a>
        </div>
    </div>
</div>


<!-- Main Content -->
<div class="container">
    <div class="row">

        <div class="col-md-9 order-md-first">
            <!-- Categories -->
            <div class="container mb-4">
                <div class="categories-wrapper d-flex">
                    @foreach($min_categories as $row)
                    <div class="card category-card border-0">
                        <div class="card-body text-center">
                            <img loading="lazy" loading="lazy" src="{{$row->getFirstMediaUrl()}}" width="30">
                            <a href="{{ route('categories.showProducts', $row->id) }}" class="d-block mt-3 text-decoration-none text-dark dark-mode-link">{{ $row->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ads Section (المحتوى) -->
            <div>
                <!-- Filter Buttons -->
                <form class="filter-form  d-block d-md-none">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" name="min_price" class="form-control form-control-sm" min="0" placeholder="{{ __('contents.min') }}" style="width: 100px;">
                            <span>-</span>
                            <input type="number" name="max_price" class="form-control form-control-sm" min="0" placeholder="{{ __('contents.max') }}" style="width: 100px;">
                        </div>
                        <select name="city" class="form-select form-select-sm" style="width: auto;">
                            <option value="all" selected>{{ __('contents.all-areas') }}</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm mb-3 w-100">{{ __('contents.search') }}</button>
                </form>

                <div class="row" id="ads">
                    <div class="col-12">
                        @forelse($products as $row)
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
        </div>



        <!-- Sidebar (الشريط الجانبي) -->
        <div class="col-md-3 order-md-last">
            <div class="sidebar rounded p-3">
                <div class="d-md-block d-none">
                    <h5 class="fw-bold mb-3">{{ __('contents.filters') }}</h5>

                    <form class="filter-form">
                        <!-- Filter by Area -->
                        <div class="mb-3">
                            <h6 class="fw-semibold">{{ __('contents.order-by') }}</h6>
                            <select name="city" class="form-select form-select-sm">
                                <option value="all">{{ __('contents.all-areas') }}</option>
                                @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter by Price Range -->
                        <div class="mb-3">
                            <h6 class="fw-semibold">{{ __('contents.price-range') }}</h6>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm" min="0" placeholder="{{ __('contents.min') }}">
                                <span>-</span>
                                <input type="number" name="max_price" class="form-control form-control-sm" min="0" placeholder="{{ __('contents.max') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm w-100">{{ __('contents.search') }}</button>
                        </div>
                    </form>

                    <hr>
                </div>

                <!-- Quick Navigate Section -->
                <h6 class="fw-bold">{{ __('contents.quick-navigate') }}</h6>
                <div>
                    @foreach($quick_navigates as $category_id => $subcategories)
                    <h6 class="mt-3">{{ $subcategories->first()->category->name }}</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($subcategories as $subcategory)
                        <a href="{{ route('subcategories.showProducts', $subcategory->id) }}"
                            class="btn btn-outline-secondary btn-sm border-0">
                            <img loading="lazy" src="{{ $subcategory->getFirstMediaUrl() }}" width="50">
                        </a>
                        @endforeach
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')


<script>
    $(document).ready(function() {

    });
</script>


<script>
    $(document).ready(function() {
        // handel search
        $('.search').on('submit', function(event) {
            event.preventDefault(); // منع السلوك الافتراضي للفورم

            const query = $('#searchInput').val(); // الحصول على قيمة البحث
            const url = "{{ route('products.search') }}"; // رابط البحث (يجب تعديله حسب المشروع)

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: query
                },
                success: function(response) {
                    $('#ads').html('');
                    $('#ads').append(response);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // cards clicks
        $(document).on('click', '.ad-card', function() {
            // Get the product ID from the data-id attribute of the clicked card
            let productId = $(this).data('id');

            let productUrl = "{{ route('products.show', ':id') }}".replace(':id', productId);

            // Redirect to the product details page using the product ID
            window.location.href = productUrl;
        });
    });


    $(document).ready(function() {
        $('.filter-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var formData = form.serialize(); // تحويل البيانات إلى صيغة URL-encoded

            $.ajax({
                url: '{{ route("products.filter") }}',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#ads').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
@endsection

@endsection