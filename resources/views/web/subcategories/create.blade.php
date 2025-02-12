@extends('layouts.layout')

@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.subcategory-creation') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- الفورم الأول - الفئات الفرعية -->
        <div class="col-md-12">
            <h3 class="text-center">إضافة فئة فرعية</h3>
            <form action="{{ route('subcategories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name_ar" class="form-label">الاسم بالعربية</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name_ar"
                        name="name_ar"
                        value="{{ old('name_ar') }}"
                        required>
                    @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name_en" class="form-label">الاسم بالإنجليزية</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name_en"
                        name="name_en"
                        value="{{ old('name_en') }}"
                        required>
                    @error('name_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">الفئة الرئيسية</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>اختر الفئة الرئيسية</option>
                        @foreach($mainCategories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_ar }} - {{ $category->name_en }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success w-100">إضافة</button>
            </form>


            <hr>

            <h4 class="mt-5 bm-4 text-center">الفئات الفرعية</h4>
            <div class="table-responsive">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>الاسم بالعربية</th>
                            <th>الاسم بالإنجليزية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subCategories as $subCategory)
                        <tr>
                            <td>{{ $subCategory->name_ar }}</td>
                            <td>{{ $subCategory->name_en }}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">تعديل</a>
                                <a href="#" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</div>
@endsection