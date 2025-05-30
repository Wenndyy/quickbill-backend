<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickBill - Auto-Sync, Auto-Count, Auto-Profit!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'quickbill-blue': '#5FA8C7',
                        'quickbill-teal': '#7CBDCD',
                        'quickbill-dark': '#2C3E50',
                        'quickbill-gray': '#95A5A6'
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f8fbff 0%, #e8f4f8 100%);
        }
        .feature-card {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-image {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .responsive-img {
            width: 100%;
            height: auto;
            max-width: 100%;
            display: block;
        }

        .hero-image img,
        .feature-image img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>
<body class="font-sans antialiased gradient-bg">
    <!-- Header -->
    <header class="container mx-auto px-6 py-6">
        <nav class="flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-quickbill-teal tracking-wide">QUICKBILL</h1>
            </div>
            <div>
                <a href="{{ route('login') }}"
                   class="bg-quickbill-teal hover:bg-quickbill-blue text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                    GET STARTED
                </a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-8">
                <div class="space-y-6">
                    <h2 class="text-5xl lg:text-6xl font-bold text-quickbill-dark leading-tight">
                        Auto-Sync, Auto-Count,<br>
                        <span class="text-quickbill-teal">Auto-Profit!</span>
                    </h2>

                    <div class="space-y-4">
                        <p class="text-xl text-quickbill-gray leading-relaxed">
                            Waktu Anda Berharga – Jangan Buang-Buang di Kasir.
                        </p>
                        <p class="text-xl leading-relaxed">
                            <span class="text-quickbill-teal font-semibold">QUICKBILL</span>
                            <span class="text-quickbill-gray">yang Mengurus, Anda yang Mengembangkan!</span>
                        </p>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="{{ route('login') }}"
                       class="inline-block bg-quickbill-teal hover:bg-quickbill-blue text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl">
                        GET STARTED
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="relative">
               <div class="hero-image rounded-2xl overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="QuickBill POS System"
                        class="w-full h-auto md:h-[500px] object-cover"
                        loading="lazy">
                </div>
                <!-- Floating Elements -->
                <div class="absolute -top-4 -right-4 bg-white rounded-full p-4 shadow-lg">
                    <div class="w-8 h-8 bg-quickbill-teal rounded-full"></div>
                </div>
                <div class="absolute -bottom-4 -left-4 bg-quickbill-blue rounded-full p-6 shadow-lg">
                    <div class="w-6 h-6 bg-white rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="container mx-auto px-6 py-20">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-quickbill-dark mb-6">Key Features Overview</h3>
            <div class="w-24 h-1 bg-quickbill-teal mx-auto rounded-full"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Center Image -->
            <div class="relative order-2 lg:order-1">
                <div class="rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f"
                        alt="Team collaboration"
                        class="responsive-img w-full h-auto object-cover">
                </div>
                <!-- Floating feature cards -->
                <div class="absolute -top-8 -left-4 transform rotate-3">
                    <div class="bg-white/90 feature-card rounded-xl p-4 shadow-xl backdrop-blur-sm">
                        <div class="flex items-center space-x-3">
                            <div class="bg-quickbill-teal p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-quickbill-dark">Auto-Sync</span>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-8 -right-8 transform -rotate-3">
                    <div class="bg-white/90 feature-card rounded-xl p-4 shadow-xl backdrop-blur-sm">
                        <div class="flex items-center space-x-3">
                            <div class="bg-quickbill-blue p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-quickbill-dark">Analytics</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="space-y-8 order-1 lg:order-2">
                <!-- Orders Feature -->
                <div class="bg-white/20 feature-card rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-start space-x-6">
                        <div class="bg-quickbill-blue p-4 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v5a1 1 0 01-1 1H9a1 1 0 01-1-1v-5m6-5V7a1 1 0 00-1-1H9a1 1 0 00-1-1v1m6 0V7"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-quickbill-dark mb-3">
                                Fitur <span class="text-quickbill-blue">Orders</span>
                            </h4>
                            <p class="text-quickbill-gray leading-relaxed">
                                menampilkan tabel transaksi, dari waktu transaksi, total harga, total item, dan kasir yang melayani.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Product Feature -->
                <div class="bg-white/20 feature-card rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-start space-x-6">
                        <div class="bg-quickbill-teal p-4 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-quickbill-dark mb-3">
                                Fitur <span class="text-quickbill-teal">Product</span>
                            </h4>
                            <p class="text-quickbill-gray leading-relaxed">
                                berfungsi agar pengguna dapat menambahkan produk, mengedit produk, dan menghapus produk
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-gradient-to-r from-quickbill-teal to-quickbill-blue py-20">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto space-y-8">
                <h3 class="text-4xl font-bold text-white">
                    Siap Mengembangkan Bisnis Anda?
                </h3>
                <p class="text-xl text-white/90 leading-relaxed">
                    Bergabunglah dengan ribuan bisnis yang telah mempercayai QuickBill untuk mengelola transaksi mereka secara otomatis dan efisien.
                </p>
                <div class="pt-4">
                    <a href="#get-started"
                       class="inline-block bg-white text-quickbill-teal px-12 py-4 rounded-lg font-bold text-lg hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-xl">
                        MULAI SEKARANG
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-quickbill-dark py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h4 class="text-2xl font-bold text-quickbill-teal mb-4">QUICKBILL</h4>
                <p class="text-gray-400">
                    Solusi POS terdepan untuk bisnis modern
                </p>
                <div class="mt-8 pt-8 border-t border-gray-700">
                    <p class="text-gray-500 text-sm">
                        © {{ date('Y') }} QuickBill. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Optional: Add any additional scroll effects here if needed
    </script>
</body>
</html>
