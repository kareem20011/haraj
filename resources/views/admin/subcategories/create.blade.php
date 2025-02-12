@extends('admin.layouts.app')
@section('admin.contents')

@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif


<div class="card">
    <form action="{{ route('admin.subcategories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h4>{{ __('contents.create') }}</h4>
        </div>
        <div class="card-body">
            <!-- image -->
            <div class="mb-3">
                <label for="formFile" class="form-label">{{ __('contents.image') }}</label>
                <input name="image" class="form-control" type="file" id="formFile" value="{{ old('image') }}">
                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- name ar -->
            <div class="mb-3">
                <label>{{ __('contents.name_ar') }}</label>
                <input name="name_ar" type="text" class="form-control" value="{{ old('name_ar') }}">
                @error('name_ar')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- name en -->
            <div class="mb-3">
                <label>{{ __('contents.name_en') }}</label>
                <input name="name_en" type="text" class="form-control" value="{{ old('name_en') }}">
                @error('name_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- categories -->
            <label for="categories">{{ __('contents.categories') }}</label>
            <select id="categories" name="category_id" class="form-select" aria-label="Default select example">
                <option selected disabled>{{ __('contents.select-category') }}</option>
                @foreach($cats as $row)
                <option value="{{ $row->id }}">{{ Session::get('locale') == 'ar' ? $row->name_ar : $row->name_en }}</option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary">{{ __('contents.create') }}</button>
        </div>
    </form>
</div>
@endsection