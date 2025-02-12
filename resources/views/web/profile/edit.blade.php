@extends('layouts.layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>{{ __('contents.profile') }}</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- الاسم -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('contents.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- البريد الإلكتروني -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('contents.email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- الهاتف -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('contents.phone') }}</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- العنوان -->
                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('contents.address') }}</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
                            @error('address')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- الصورة الشخصية -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">{{ __('contents.profile-picture') }}</label>
                            <input type="file" name="avatar" id="avatar" class="form-control">
                            @error('avatar')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if($user->avatar)
                            <img
                                loading="lazy"
                                src="{{ asset('storage/users-avatar/' . $user->avatar) }}"
                                alt="User Avatar"
                                class="rounded-circle mt-3"
                                style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>

                        <!-- زر الحفظ -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-sm">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection