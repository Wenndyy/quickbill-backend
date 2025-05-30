{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'My Profile')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>My Profile</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                   <div class="card">
                        <div class="card-header">
                            <h4 style="color: #48A6A7;">Profile Details</h4>
                           <div class="card-header-action"  >
                                <a href="{{ route('profile.edit') }}" class="btn" style="background-color: #48A6A7; color: white;">
                                    <i class="fas fa-edit" style="color: white;"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 text-muted">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-dark mb-0 font-weight-bold">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 text-muted">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-dark mb-0">
                                            {{ $user->email }}
                                            <span class="badge badge-light ml-2">
                                                <i class="fas fa-lock"></i> Cannot be changed
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 text-muted">Phone Number</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-dark mb-0">
                                            {{ $user->phone ?? 'Not provided' }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 text-muted">Joined Date</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-dark mb-0">{{ $user->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
