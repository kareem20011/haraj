@extends('layouts.layout')

@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.category-creation') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- الفورم الأول - الفئات الرئيسية -->
        <div class="col-md-12">
            <h3 class="text-center">إضافة فئة رئيسية</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name_ar" class="form-label">name_ar</label>
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
                    <label for="name_en" class="form-label">name_en</label>
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
                <button type="submit" class="btn btn-success w-100">إضافة</button>
            </form>


            <hr>

            <h4 class="mt-5 bm-4 text-center">الفئات الرئيسية</h4>
            <div class="table-responsive">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>name_ar</th>
                            <th>name_en</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mainCategories as $mainCategory)
                        <tr>
                            <td>{{ $mainCategory->name_ar }}</td>
                            <td>{{ $mainCategory->name_en }}</td>
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