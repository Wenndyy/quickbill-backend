@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('main')
    <div class="login-container">
        <div class="header-section">
            <div class="logo">QUICKBILL</div>
            <h2 class="login-title">Login to your account</h2>
        </div>

        <div class="login-card">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
               @if (session('status'))
                <div id="flash-message" class="alert alert-success">
                    {{ session('status') }}
                </div>

                <script>
                    setTimeout(function() {
                        var flash = document.getElementById('flash-message');
                        if (flash) {
                            flash.style.transition = "opacity 0.5s ease-out";
                            flash.style.opacity = '0';
                            setTimeout(() => flash.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif


                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email"
                           type="email"
                           class="form-input @error('email') is-invalid @enderror"
                           name="email"
                           tabindex="1"
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password"
                           type="password"
                           class="form-input @error('password') is-invalid @enderror"
                           name="password"
                           tabindex="2">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="forgot-password">
                    <a href="{{ route('forgot.otp.form') }}">Forgot your password?</a>
                </div>

                <button type="submit" class="login-btn" tabindex="4">
                    LOGIN
                </button>

                <div class="divider">
                    <span>New to QUICKBILL?</span>
                </div>

                <a href="{{ route('register') }}" class="create-account-btn">Create an account</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
