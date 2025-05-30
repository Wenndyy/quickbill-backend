@extends('layouts.auth')

@section('title', 'Lupa Password - Kirim OTP')

@push('style')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
@endpush

@section('main')
    <div class="forgot-container">
        <div class="header-section">
            <div class="logo">QUICKBILL</div>
            <h2 class="forgot-title">Reset your password</h2>
            <p class="forgot-subtitle">Please enter your email address to receive<br>a verification code</p>
        </div>

        <div class="forgot-card">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/forgot-password-otp') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email"
                           type="email"
                           class="form-input @error('email') is-invalid @enderror"
                           name="email"
                           required
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="send-btn">Send</button>

                <a href="{{ route('login') }}" class="back-btn">
                    <span class="back-icon">←</span>
                    Back to login
                </a>
            </form>
        </div>
    </div>
@endsection
