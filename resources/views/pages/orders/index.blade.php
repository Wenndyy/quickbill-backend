@extends('layouts.app')

@section('title', 'Orders')

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
                    <h1 style="margin: 0; padding: 0; font-size: 32px; font-weight: bold; color: #333;">Orders</h1>
                    <p style="margin: 0; padding: 0; color: #888; font-size: 14px;">You can view all Orders, including
                        their details and statuses.</p>
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
                                <h4 style="color: #48A6A7;">All Orders</h4>

                            </div>
                            <div class="card-body">



                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Transaction Time</th>
                                            <th>Total Price</th>
                                            <th>Total Item</th>
                                            <th>Kasir</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($orders as $order)
                                            <tr>

                                                <td>
                                                        {{ $order->transaction_time }}
                                                </td>
                                                <td>
                                                    {{ $order->total_price }}
                                                </td>
                                                <td>
                                                    {{ $order->total_item }}
                                                </td>
                                                <td>
                                                    {{ $order->kasir->name }}

                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('order.show', $order->id) }}"
                                                            class="btn btn-sm btn-icon"
                                                            style="background-color: #47CA47; color: white;">
                                                            <i class="fas fa-eye"></i>
                                                            View
                                                        </a>
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
                                    {{ $orders->withQueryString()->links() }}
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
