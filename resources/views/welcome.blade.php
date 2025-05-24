<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TroViet - Tìm kiếm phòng trọ lý tưởng</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        .floating-animation-delay {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="bg-white">
    <!-- Header Navigation -->
    <header class="relative z-50">
        <nav class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold gradient-text">Trọ Việt</h1>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('motel') }}"
                            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">
                            Tìm phòng trọ
                        </a>
                        <a href="{{ route('about') }}"
                            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">
                            Về chúng tôi
                        </a>
                        <a href="{{ route('contact') }}"
                            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">
                            Liên hệ
                        </a>
                    </div>

                    <!-- Auth Links -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">
                                Đăng nhập
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Đăng ký
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-white min-h-screen">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-pattern"></div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-indigo-100 rounded-full floating-animation"></div>
        <div class="absolute bottom-20 right-10 w-48 h-48 bg-purple-100 rounded-full floating-animation-delay"></div>
        <div class="absolute top-1/2 left-1/4 w-20 h-20 bg-pink-100 rounded-full floating-animation"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-32">
            <div class="text-center">
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                    Tìm <span class="relative">
                        <span class="text-indigo-600">phòng trọ</span>
                        <span class="absolute bottom-2 left-0 w-full h-3 bg-indigo-200 rounded-full"></span>
                    </span><br>
                    lý tưởng cho bạn
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto font-light">
                    Kết nối không gian sống hoàn hảo với hơn <span class="font-semibold text-indigo-600">10,000+</span>
                    phòng trọ chất lượng trên toàn quốc
                </p>

                <!-- CTA Buttons -->
                <div
                    class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6 mb-16">
                    <a href="{{ route('motel') }}"
                        class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Tìm phòng ngay
                    </a>

                    @guest
                        <a href="{{ route('register') }}"
                            class="border-2 border-indigo-600 text-indigo-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-600 hover:text-white transition-all duration-300">
                            Đăng ký miễn phí
                        </a>
                    @endguest
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">10,000+</div>
                        <div class="text-gray-600">Phòng trọ</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">50+</div>
                        <div class="text-gray-600">Tỉnh thành</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">99%</div>
                        <div class="text-gray-600">Hài lòng</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave decoration -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 200" class="fill-current text-gray-50">
                <path fill-opacity="1"
                    d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Tại sao chọn TroViet?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Chúng tôi cung cấp nền tảng toàn diện để tìm kiếm và quản lý phòng trọ một cách dễ dàng
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-white p-8 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200">
                    <div class="bg-indigo-100 p-4 rounded-xl w-fit mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tìm kiếm thông minh</h3>
                    <p class="text-gray-600">
                        Tìm phòng trọ phù hợp với bộ lọc thông minh theo vị trí, giá cả và tiện ích
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-white p-8 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200">
                    <div class="bg-green-100 p-4 rounded-xl w-fit mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">An toàn & Đáng tin cậy</h3>
                    <p class="text-gray-600">
                        Thông tin được xác minh, giao dịch an toàn với hệ thống đánh giá minh bạch
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-white p-8 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200">
                    <div class="bg-purple-100 p-4 rounded-xl w-fit mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Quản lý toàn diện</h3>
                    <p class="text-gray-600">
                        Từ đặt phòng, ký hợp đồng đến thanh toán - tất cả trong một nền tảng
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Cách thức hoạt động
                </h2>
                <p class="text-xl text-gray-600">
                    Chỉ với 3 bước đơn giản để tìm được phòng trọ mơ ước
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div
                        class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tìm kiếm</h3>
                    <p class="text-gray-600">Sử dụng bộ lọc để tìm phòng trọ phù hợp với nhu cầu và
                        ngân sách</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div
                        class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Liên hệ</h3>
                    <p class="text-gray-600">Kết nối trực tiếp với chủ trọ để xem phòng và thương
                        lượng</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div
                        class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Chuyển vào</h3>
                    <p class="text-gray-600">Hoàn tất thủ tục và bắt đầu cuộc sống mới tại không
                        gian lý tưởng</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Sẵn sàng tìm ngôi nhà mới?
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Hàng ngàn phòng trọ chất lượng đang chờ bạn khám phá
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('motel') }}"
                    class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg">
                    Bắt đầu tìm kiếm
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="border-2 border-indigo-600 text-indigo-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-600 hover:text-white transition-all duration-300">
                        Đăng ký tài khoản
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-bold gradient-text mb-4">TroViet</h3>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Nền tảng kết nối phòng trọ hàng đầu Việt Nam, giúp bạn tìm kiếm không gian sống lý tưởng một
                        cách dễ dàng và an toàn.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liên kết nhanh</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('motel') }}"
                                class="text-gray-400 hover:text-white transition-colors">Tìm phòng trọ</a></li>
                        <li><a href="{{ route('about') }}"
                                class="text-gray-400 hover:text-white transition-colors">Về chúng tôi</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="text-gray-400 hover:text-white transition-colors">Liên hệ</a></li>
                        @guest
                            <li><a href="{{ route('register') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Đăng ký</a></li>
                        @endguest
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liên hệ</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@troviet.com</li>
                        <li>Hotline: 1900 1234</li>
                        <li>Địa chỉ: 123 Đường ABC, TP.HCM</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">© 2025 TroViet™. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
