@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.product-creation') }}
@endsection
@section('content')


 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
            </div>
        </div>


        <div class="col-md-9">

            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">
                        <div class="form-group mb-3">
                            <label for="images" class="form-label">{{ __('contents.upload-images') }}</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                            @error('images.*')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('contents.title') }}</label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="{{ __('contents.title') }}" value="{{ old('title') }}">
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('contents.description') }}</label>
                            <input name="description" type="text" class="form-control" id="description" placeholder="{{ __('contents.description') }}" value="{{ old('description') }}">
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('contents.price') }}</label>
                            <input name="price" type="text" class="form-control" id="price" placeholder="{{ __('contents.price') }}" value="{{ old('price') }}">
                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">{{ __('contents.location') }}</label>
                            <input name="location" type="text" class="form-control" id="location" placeholder="{{ __('contents.location') }}" value="{{ old('location') }}">
                            @error('location')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('contents.create') }}</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection