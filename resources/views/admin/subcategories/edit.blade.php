@extends('admin.layouts.app')
@section('admin.contents')

<div class="card">
    <form action="{{ route('admin.subcategories.update', $subcat->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3>{{ __('contents.edit') }}</h3>
        </div>
        <div class="card-body">
            <img src="{{ $subcat->getFirstMediaUrl() }}" class="img-fluid mb-3" width="100">

            <!-- image -->
            <div class="mb-3">
                <label for="formFile" class="form-label">{{ __('contents.image') }}</label>
                <input name="image" class="form-control" type="file" id="formFile" value="{{ $subcat->name_ar }}">
                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- name ar -->
            <div class="mb-3">
                <label>{{ __('contents.name_ar') }}</label>
                <input name="name_ar" type="text" class="form-control" value="{{ $subcat->name_ar }}">
                @error('name_ar')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- name en -->
            <div class="mb-3">
                <label>{{ __('contents.name_en') }}</label>
                <input name="name_en" type="text" class="form-control" value="{{ $subcat->name_en }}">
                @error('name_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <select id="categories" name="category_id" class="form-select" aria-label="Default select example">
                <option selected disabled>{{ __('contents.select-category') }}</option>
                @foreach($cats as $row)
                <option value="{{ $row->id }}" {{ old('category_id', $selectedCategoryId ?? '') == $row->id ? 'selected' : '' }}>
                    {{ Session::get('locale') == 'ar' ? $row->name_ar : $row->name_en }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary">{{ __('contents.update') }}</button>
        </div>
    </form>
</div>
@endsection