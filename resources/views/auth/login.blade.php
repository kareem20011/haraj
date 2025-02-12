@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('contents.login') }}
@endsection
@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">{{ __('contents.login') }}</h2>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('contents.email') }}</label>
                <input name="email" type="email" class="form-control" id="email"
                    placeholder="{{ __('contents.email') }}" value="{{ old('email') }}" required>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                @if(session()->has('error'))
                <small class="text-danger">{{ session()->get('error') }}</small>
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
            <button type="submit" class="btn btn-success w-100">{{ __('contents.login') }}</button>
        </form>

        <div class="text-center mt-3">
            <a href="#" class="text-muted">{{ __('contents.forget-password') }}</a>
        </div>
        <div class="text-center mt-2">
            <p>{{ __('contents.dont-have-account') }} <a href="{{ route( 'register' ) }}">{{ __('contents.registre') }}</a></p>
        </div>
    </div>
</div>

@endsection