@extends('layouts.auth')

@section('title', 'Create Account')

@push('style')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('main')
    <div class="register-container">
        <div class="header-section">
            <div class="logo">QUICKBILL</div>
            <h2 class="register-title">Create your account</h2>
        </div>

        <div class="register-card">
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

           <form method="POST" action="{{ route('registration') }}">

                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input id="name"
                           type="text"
                           class="form-input @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email"
                           type="email"
                           class="form-input @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required>
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
                           required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
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

                <button type="submit" class="create-btn">Create account</button>
                <div class="divider">
                    <span>Already have an account</span>
                </div>


                <a href="{{ route('login') }}" class="login-btn">
                    Login instead
                </a>
            </form>
        </div>
    </div>
@endsection
