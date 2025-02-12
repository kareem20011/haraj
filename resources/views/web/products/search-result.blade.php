<div class="row ads" id="ads">
    @forelse($products as $row)
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
                        <span class="text-secondary small">{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <h3 class="text-center">{{__('contents.no-items')}}</h3>
    @endforelse
</div>