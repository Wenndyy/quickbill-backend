@extends('layouts.app')

@section('title', 'Products')

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
                    <h1 style="margin: 0; padding: 0; font-size: 32px; font-weight: bold; color: #333;">Products</h1>
                    <p style="margin: 0; padding: 0; color: #888; font-size: 14px;">You can manage all Products, such as
                        editing, deleting and more.</p>
                </div>

                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary"
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
                                <h4 style="color: #48A6A7; margin: 0;">All Products</h4>
                                <form method="GET" action="{{ route('product.index') }}" class="mb-0">
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
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stok</th>
                                            <th>Photo</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr>

                                                <td>{{ $product->name }}
                                                </td>
                                                <td>
                                                    {{ $product->category }}
                                                </td>
                                                <td>
                                                    {{ $product->price }}
                                                </td>
                                                <td>
                                                    {{ $product->stock }}
                                                </td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/products/' . $product->image) }}"
                                                            alt="" width="100px" class="img-thumbnail">
                                                    @else
                                                        <span class="badge badge-danger">No Image</span>
                                                    @endif

                                                </td>
                                                <td>{{ $product->created_at }}</td>
                                                <td>
                                                    <div class="d-flex ">
                                                        <a href='{{ route('product.edit', $product->id) }}'
                                                            class="btn btn-sm btn-icon"
                                                            style="background-color: #2973B2; color: white;">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('product.destroy', $product->id) }}"
                                                            method="POST" class="ml-2">
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
                                    {{ $products->withQueryString()->links() }}
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
