@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard </h1>

            </div>
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon-wrapper bg-primary-gradient">
                                    <i class="fas fa-users card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Total Users</h4>
                                    <div class="number">{{ number_format($totalUsers ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon-wrapper bg-success-gradient">
                                    <i class="fas fa-boxes card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Total Products</h4>
                                    <div class="number">{{ number_format($totalProducts ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon-wrapper bg-info-gradient">
                                    <i class="fas fa-shopping-cart card-icon"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Total Orders</h4>
                                    <div class="number">{{ number_format($totalOrders ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Prediction -->
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h4>Weekly Sales Trend</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dashboard-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>7-Day Sales Forecast</h4>
                            <span class="badge prediction-badge" style="color: white; background-color: #63d7b0;">AI Prediction</span>
                        </div>
                        <div class="card-body">
                            @if(count($predicted) > 0)
                                <div class="table-responsive">
                                    <table class="table prediction-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th style="text-align: right">Forecast</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($predicted as $item)
                                                <tr>
                                                    <td>{{ $item['product_name'] }}</td>
                                                    <td style="text-align: right">
                                                        <strong>{{ number_format($item['predicted_next_7_days']) }}</strong> pcs
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="no-prediction">
                                    <i class="fas fa-chart-line"></i>
                                    <h5>No Prediction Data</h5>
                                    <p class="text-muted">Sales forecast will appear here</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');

            // Create gradient
            const salesGradient = salesCtx.createLinearGradient(0, 0, 0, 300);
            salesGradient.addColorStop(0, 'rgba(103, 119, 239, 0.2)');
            salesGradient.addColorStop(1, 'rgba(103, 119, 239, 0.05)');

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($weeks),
                    datasets: [{
                        label: 'Weekly Sales',
                        data: @json($sales),
                        borderColor: '#6777ef',
                        backgroundColor: salesGradient,
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6777ef',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.03)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6c757d',
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000).toLocaleString('id-ID') + 'M';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
