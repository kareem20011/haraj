@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('contents.registre') }}
@endsection
@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">{{ __('contents.registre') }}</h2>
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="fullName" class="form-label">{{ __('contents.name') }}</label>
                <input name="name" type="text" class="form-control" id="fullName"
                    placeholder="{{ __('contents.name') }}" value="{{ old('name') }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('contents.email') }}</label>
                <input name="email" type="email" class="form-control" id="email"
                    placeholder="{{ __('contents.email') }}" value="{{ old('email') }}" required>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('contents.password') }}</label>
                <input name="password" type="password" class="form-control" id="password"
                    placeholder="{{ __('contents.password') }}" required>
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">{{ __('contents.password-confirmation') }}</label>
                <input name="password_confirmation" type="password" class="form-control" id="confirmPassword"
                    placeholder="{{ __('contents.password-confirmation') }}" required>
                @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" {{ old('terms') ? 'checked' : '' }}>
                <label class="form-check-label" for="terms">{{ __('contents.agree-with') }}
                    <a href="#">{{ __('contents.terms') }}</a></label>
            </div>
            <button type="submit" class="btn btn-success w-100">{{ __('contents.registre') }}</button>
        </form>

        <div class="text-center mt-3">
            <p>{{ __('contents.already-have-account') }} <a href="{{ route('login') }}">{{ __('contents.login') }}</a></p>
        </div>
    </div>
</div>

@endsection