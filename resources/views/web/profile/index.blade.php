@extends('layouts.layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>{{ __('contents.profile') }}</h4>
                </div>
                <div class="card-body text-center">
                    <!-- صورة المستخدم -->
                     @if($user->avatar)
                    <img loading="lazy" src="{{ asset('storage/users-avatar/' . ($user->avatar)) }}" alt="User Avatar" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                    <img loading="lazy" src="{{ asset('assets/images/avatar.png') }}" alt="User Avatar" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @endif

                    <!-- اسم المستخدم -->
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>

                    <!-- التفاصيل الإضافية -->
                    <hr>
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('contents.phone') }}</dt>
                        <dd class="col-sm-8">{{ $user->phone ?? __('contents.not-provided') }}</dd>

                        <dt class="col-sm-4">{{ __('contents.address') }}</dt>
                        <dd class="col-sm-8">{{ $user->address ?? __('contents.not-provided') }}</dd>

                        <dt class="col-sm-4">{{ __('contents.joined-on') }}</dt>
                        <dd class="col-sm-8">{{ $user->created_at->format('d M Y') }}</dd>
                    </dl>

                    <!-- زر تعديل الملف الشخصي -->
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm text-white mt-3">
                        {{ __('contents.edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- عرض المنتجات الخاصة بالمستخدم -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="text-center mb-4">{{ __('contents.my-products') }}</h4>
        </div>

        <div class="col-12 mb-3">
            @forelse($user->products as $row)
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