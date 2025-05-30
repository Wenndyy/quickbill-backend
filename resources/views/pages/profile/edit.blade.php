{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header" >
                            <h4  style="color: #48A6A7;">
                                <i class="fas fa-edit" style="color: #48A6A7;"></i> Edit Profile Information
                            </h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('profile.update') }}" method="POST" id="editProfileForm">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       id="name"
                                                       name="name"
                                                       value="{{ old('name', $user->name) }}"
                                                       placeholder="Enter your full name"
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                Only letters and spaces are allowed
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone"
                                                       name="phone"
                                                       value="{{ old('phone', $user->phone) }}"
                                                       placeholder="e.g., +6281234567890">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                Optional. Format: +62xxxxxxxxxx, 62xxxxxxxxxx, or 08xxxxxxxxxx
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="email"
                                               class="form-control"
                                               value="{{ $user->email }}"
                                               disabled>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fas fa-lock text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-shield-alt"></i> Email cannot be changed for security reasons
                                    </small>
                                </div>

                                <hr>

                                <div class="form-group d-flex justify-content-between">
                                    <a href="{{ route('profile.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left"></i> Back to Profile
                                    </a>
                                    <div>
                                        <button type="submit" class="btn ml-2" style="background-color: #48A6A7; color: white;">
                                            <i class="fas fa-save" style="color: white;"></i> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
.profile-summary-item {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #eee;
}

.profile-summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.profile-summary-label {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
}

.profile-summary-value {
    font-size: 1rem;
    color: #495057;
    font-weight: 500;
    margin-top: 0.2rem;
}

.guideline-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.8rem;
    font-size: 0.9rem;
}

.guideline-item i {
    margin-right: 0.5rem;
    width: 16px;
}

.guidelines {
    padding: 0.5rem 0;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

.form-control:disabled {
    background-color: #f8f9fa;
    opacity: 0.8;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Auto close alert after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Form validation
    $('#editProfileForm').on('submit', function(e) {
        let name = $('#name').val().trim();
        let isValid = true;

        // Reset previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Validate name
        if (name === '') {
            $('#name').addClass('is-invalid');
            $('#name').parent().append('<div class="invalid-feedback">Name is required</div>');
            isValid = false;
        }

        // Validate phone if provided
        let phone = $('#phone').val().trim();
        if (phone && !phone.match(/^(\+62|62|0)[0-9]{8,13}$/)) {
            $('#phone').addClass('is-invalid');
            $('#phone').parent().append('<div class="invalid-feedback">Please enter a valid Indonesian phone number</div>');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            return false;
        }

        // Show loading state
        $(this).find('button[type="submit"]')
               .html('<i class="fas fa-spinner fa-spin"></i> Saving...')
               .prop('disabled', true);
    });

    // Remove validation error on input
    $('#name, #phone').on('input', function() {
        $(this).removeClass('is-invalid');
        $(this).parent().find('.invalid-feedback').remove();
    });

    // Phone number formatting
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/[^0-9+]/g, '');
        $(this).val(value);
    });

    // Reset form
    $('button[type="reset"]').click(function() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    // Confirm before leaving with unsaved changes
    let formChanged = false;
    $('#editProfileForm input').on('input', function() {
        formChanged = true;
    });

    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    // Remove confirmation after form submit
    $('#editProfileForm').on('submit', function() {
        formChanged = false;
    });
});
</script>
@endpush
