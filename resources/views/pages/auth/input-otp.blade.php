@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@push('style')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/input-otp.css') }}">
@endpush

@section('main')
    <div class="verify-container">
        <div class="header-section">
            <div class="logo">QUICKBILL</div>
            <h2 class="verify-title">Reset your password</h2>
            <p class="verify-subtitle">Please enter 4 digit code sent to<br>{{ session('email') ? substr(session('email'), 0, 1) . str_repeat('*', strlen(explode('@', session('email'))[0]) - 2) . substr(explode('@', session('email'))[0], -1) . '@' . explode('@', session('email'))[1] : 'd**e@gmail.com' }}</p>
        </div>

        <div class="verify-card">
            <div class="email-icon">
                ✉
            </div>
            <div class="check-email-text">Check your email</div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('forgot.otp.verify') }}" id="otpForm">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">

                <div class="otp-container">
                    <input type="text" class="otp-input" maxlength="1" data-index="0">
                    <input type="text" class="otp-input" maxlength="1" data-index="1">
                    <input type="text" class="otp-input" maxlength="1" data-index="2">
                    <input type="text" class="otp-input" maxlength="1" data-index="3">
                    <input type="text" class="otp-input" maxlength="1" data-index="4">
                    <input type="text" class="otp-input" maxlength="1" data-index="5">
                </div>

                <!-- Hidden input for form submission -->
                <input type="hidden" name="otp" id="hiddenOtp" class="hidden-otp-input">

                <button type="submit" class="verify-btn">Verify</button>

                <a href="{{ route('login') }}" class="back-btn">
                    <span class="back-icon">←</span>
                    Back to login
                </a>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const hiddenOtp = document.getElementById('hiddenOtp');
            const form = document.getElementById('otpForm');

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }

                    if (value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }

                    updateHiddenInput();
                });

                input.addEventListener('keydown', function(e) {

                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 4);

                    for (let i = 0; i < pastedData.length && i < otpInputs.length; i++) {
                        otpInputs[i].value = pastedData[i];
                    }

                    updateHiddenInput();
                });
            });

            function updateHiddenInput() {
                const otpValue = Array.from(otpInputs).map(input => input.value).join('');
                hiddenOtp.value = otpValue;
            }

            // Focus first input on load
            otpInputs[0].focus();
        });
    </script>
@endsection
