@extends('layouts.app')

@section('title', 'Order Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .order-summary {
            background: linear-gradient(135deg, #48A6A7 0%, #2973B2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-summary h3 {
            margin-bottom: 15px;
            color: white;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        .summary-item:not(:last-child) {
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .order-info-card {
            border-left: 4px solid #6777ef;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .status-badge {
            font-size: 0.8em;
            padding: 5px 10px;
            border-radius: 15px;
            background-color: #48A6A7 !important;
            border-color: #48A6A7 !important;
            color: white !important;
        }
        .card-header h4 {
            color: #48A6A7 !important;
            font-weight: 600;
        }

        .breadcrumb-item a{
            color: #48A6A7;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order Detail</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></div>
                    <div class="breadcrumb-item active">Order #{{ $order->id }}</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Order Summary Card -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card order-info-card">
                            <div class="card-header">
                                <h4>Order Information</h4>
                                <div class="card-header-action">
                                    <span class="badge badge-primary status-badge">
                                        {{ ucfirst($order->payment_status ?? 'Pending') }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Order ID:</strong></td>
                                                <td>#{{ $order->id }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Transaction Time:</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d M Y, H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Items:</strong></td>
                                                <td>{{ $order->total_item }} items</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            @if(isset($order->customer_name))
                                            <tr>
                                                <td><strong>Customer:</strong></td>
                                                <td>{{ $order->customer_name }}</td>
                                            </tr>
                                            @endif
                                            @if(isset($order->payment_method))
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td>{{ $order->payment_method }}</td>
                                            </tr>
                                            @endif
                                            @if(isset($order->notes))
                                            <tr>
                                                <td><strong>Notes:</strong></td>
                                                <td>{{ $order->notes }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Order Items</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if(isset($item->product->image))
                                                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="product-image mr-3">
                                                        @else
                                                        <div class="product-image mr-3 bg-light d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                        @endif
                                                        <div>
                                                            <strong>{{ $item->product->name }}</strong>
                                                            @if(isset($item->product->description))
                                                            <br><small class="text-muted">{{ Str::limit($item->product->description, 50) }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="font-weight-600">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light">{{ $item->quantity }}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-600">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="total-row">
                                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                                <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="col-md-4">
                        <div class="order-summary">
                            <h3><i class="fas fa-receipt mr-2"></i>Order Summary</h3>
                            <div class="summary-item">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            @if(isset($order->tax_amount))
                            <div class="summary-item">
                                <span>Tax:</span>
                                <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if(isset($order->discount_amount))
                            <div class="summary-item">
                                <span>Discount:</span>
                                <span>-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="summary-item" style="font-size: 1.2em; margin-top: 10px;">
                                <span><strong>Total:</strong></span>
                                <span><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Actions</h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('order.index') }}" class="btn btn-secondary btn-block mb-2">
                                        <i class="fas fa-arrow-left mr-1"></i> Back to Orders
                                    </a>
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
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        // Add any custom JavaScript for order detail functionality
        $(document).ready(function() {
            // Print invoice functionality
            $('.btn-info').click(function() {
                window.print();
            });
        });
    </script>
@endpush
