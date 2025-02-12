@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.product-creation') }}
@endsection
@section('content')
<div class="mx-5 my-3 h2">
    <a href="{{ route('categories.productCreation') }}" class="text-decoration-none fa-solid fa-circle-arrow-left"></a>
</div>
<h1 class="text-center">Subcategories</h1>
<div class="container text-center py-5">
    <div class="row gap-4 justify-content-center">


        @forelse($data as $row)
        <div class="col-auto" style="width: 300px;">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <a href="{{ route('products.create', $row->id) }}"><i class="fa-solid fa-arrow-right"></i></a>
                    <h5 class="card-title mb-0">{{ $row->name }}</h5>
                </div>
            </div>
        </div>
        @empty
        <div class="col-auto" style="width: 300px;">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title mb-0">{{ __('contents.no-items') }}</h5>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection