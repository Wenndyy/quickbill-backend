@extends('layouts.auth')

@section('title', 'Reset Password')

@push('style')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
@endpush

@section('main')
    <div class="reset-container">
        <div class="header-section">
            <div class="logo">QUICKBILL</div>
            <h2 class="reset-title">Reset your password</h2>
            <p class="reset-subtitle">Your password must be different from<br>previously used password</p>
        </div>

        <div class="reset-card">
            <div class="icon-container">
                <svg class="lock-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    <circle cx="10" cy="13" r="1" fill="white"/>
                    <path d="M10 14v2" stroke="white" stroke-width="1" stroke-linecap="round"/>
                </svg>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('forgot.password.reset') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="otp" value="{{ $otp }}">

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input id="password"
                           type="password"
                           class="form-input @error('password') is-invalid @enderror"
                           name="password"
                           required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input id="password_confirmation"
                           type="password"
                           class="form-input @error('password_confirmation') is-invalid @enderror"
                           name="password_confirmation"
                           required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="save-btn">Save</button>

                <a href="{{ route('login') }}" class="back-btn">
                    <span class="back-icon">←</span>
                    Back to login
                </a>
            </form>
        </div>
    </div>
@endsection
