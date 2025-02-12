@extends('admin.layouts.app')
@section('admin.contents')

@if(Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif

<div class="content-header">
    <h1>{{ __('contents.subcategories') }}</h1>
    <h3><a class="btn btn-info btn-sm" href="{{ route('admin.subcategories.create') }}">{{ __('contents.create') }}</a></h3>
    <p></p>
</div>
<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>{{ __('contents.name_ar') }}</th>
                <th>{{ __('contents.name_en') }}</th>
                <th>{{ __('contents.parent-category') }}</th>
                <th>{{ __('contents.image') }}</th>
                <th>{{ __('contents.edit') }}</th>
                <th>{{ __('contents.delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcats as $row)
            <tr>
                <td>{{ $row->name_ar }}</td>
                <td>{{ $row->name_en }}</td>
                <td>{{ session('locale') == 'ar' ? $row->category->name_ar : $row->category->name_en }}</td>
                <td>
                    <img src="{{ $row->getFirstMediaUrl() }}" width="30">
                </td>
                <!-- Edit -->
                <td>
                    <a href="{{ route( 'admin.subcategories.edit', $row->id ) }}" class="btn btn-info btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                </td>
                <!-- Delete -->
                <td>
                    <a href="{{ route('admin.subcategories.delete', $row->id) }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection