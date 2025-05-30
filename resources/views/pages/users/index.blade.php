@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">

            <div class="section-header"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <h1 style="margin: 0; padding: 0; font-size: 32px; font-weight: bold; color: #333;">Users</h1>
                    <p style="margin: 0; padding: 0; color: #888; font-size: 14px;">Easily manage all Users, including
                        viewing profiles, editing information, and deleting accounts.</p>
                </div>
                <div class="section-header-button">
                    <a href="{{ route('user.create') }}" class="btn btn-primary"
                        style="background-color: #48A6A7; color: white; border-color: #48A6A7; font-weight: 800; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                        Add New
                    </a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                     <h4 style="color: #48A6A7;">All Users</h4>
                                    <form method="GET" action="{{ route('user.index') }}">
                                        <div
                                            style="display: flex; align-items: center; background: #fff; border-radius: 999px; padding: 8px 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 300px;">
                                            <button
                                                style="border: none; background: hsla(0, 0%, 0%, 0.05); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                                                <i class="fas fa-search" style="color: #777777;"></i>
                                            </button>
                                            <input type="text" placeholder="Search" name="name"
                                                style="border: none; outline: none; font-size: 14px; color: #777; flex: 1;">
                                        </div>
                                    </form>
                            </div>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Email</th>

                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($users as $user)
                                            <tr>

                                                <td>{{ $user->name }}
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>

                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('user.edit', $user->id) }}'
                                                            class="btn btn-sm btn-icon"
                                                            style="background-color: #2973B2; color: white;">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                            class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-icon confirm-delete"
                                                                style="background-color: #B22929; color: white;">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>

                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <style>
                                    .page-item.active .page-link {
                                        background-color: #48A6A7;
                                        border-color: #48A6A7;
                                    }

                                    .page-link {
                                        color: #48A6A7;
                                    }

                                    .page-link:hover {
                                        color: #fff;
                                        background-color: #48A6A7;
                                        border-color: #48A6A7;
                                    }
                                </style>

                                <div class="float-right">
                                    {{ $users->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
