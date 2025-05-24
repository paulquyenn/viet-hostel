<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Đăng ký</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left side - Register Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <div class="flex justify-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-green-600 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-900">Tạo tài khoản mới</h2>
                    <p class="mt-2 text-sm text-gray-600">Tham gia cộng đồng quản lý nhà trọ thông minh</p>
                </div>

                <!-- Progress bar -->
                <div class="mb-8">
                    <div class="flex items-center">
                        <div class="flex items-center text-sm font-medium text-green-600">
                            <span
                                class="flex-shrink-0 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white">
                                1
                            </span>
                            <span class="ml-2">Thông tin cơ bản</span>
                        </div>
                        <div class="flex-1 mx-4 h-1 bg-gray-200 rounded">
                            <div class="h-1 bg-green-600 rounded w-full"></div>
                        </div>
                        <div class="flex items-center text-sm font-medium text-gray-400">
                            <span
                                class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                2
                            </span>
                            <span class="ml-2">Hoàn tất</span>
                        </div>
                    </div>
                </div>

                <!-- Register Form -->
                <div class="bg-white">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Họ và tên
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="name" name="name" type="text" autocomplete="name" required
                                    value="{{ old('name') }}"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                    placeholder="Nhập họ và tên của bạn">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                        </path>
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    value="{{ old('email') }}"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                    placeholder="Nhập email của bạn">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Mật khẩu
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="new-password"
                                    required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                    placeholder="Tạo mật khẩu mạnh">
                            </div>
                            <div class="mt-1">
                                <div class="text-xs text-gray-500">
                                    Mật khẩu phải có ít nhất 8 ký tự
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Xác nhận mật khẩu
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                    placeholder="Nhập lại mật khẩu">
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-gray-700">
                                    Tôi đồng ý với
                                    <a href="#" class="font-medium text-green-600 hover:text-green-500">Điều
                                        khoản dịch vụ</a>
                                    và
                                    <a href="#" class="font-medium text-green-600 hover:text-green-500">Chính
                                        sách bảo mật</a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-200 hover:scale-105">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-green-300 group-hover:text-green-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                </span>
                                Tạo tài khoản
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Đã có tài khoản?
                                <a href="{{ route('login') }}"
                                    class="font-medium text-green-600 hover:text-green-500 transition-colors duration-200">
                                    Đăng nhập ngay
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right side - Background Image/Illustration -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-blue-600 to-green-800">
                <!-- Background pattern -->
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <svg class="absolute inset-0 h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)"
                                stroke-width="1" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>

                <!-- Content overlay -->
                <div class="relative flex flex-col justify-center h-full px-12 text-white">
                    <div class="max-w-md">
                        <h1 class="text-4xl font-bold mb-6">
                            Bắt đầu hành trình
                            <span class="block text-green-200">quản lý nhà trọ</span>
                        </h1>
                        <p class="text-lg text-green-100 mb-8">
                            Tham gia cộng đồng và trải nghiệm những tính năng tuyệt vời của hệ thống quản lý nhà trọ
                            hiện đại.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-green-100">Đăng ký miễn phí</p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-green-100">Quản lý dễ dàng</p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-green-100">Hỗ trợ 24/7</p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-green-100">Bảo mật cao</p>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="mt-12 grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">1000+</div>
                                <div class="text-sm text-green-200">Phòng trọ</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">500+</div>
                                <div class="text-sm text-green-200">Người dùng</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading overlay -->
    <div id="loadingOverlay"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <svg class="animate-spin h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-700">Đang tạo tài khoản...</span>
        </div>
    </div>

    <script>
        // Show loading overlay when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });

        // Auto-focus on name field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').focus();
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.querySelector('.password-strength');

            if (password.length >= 8) {
                this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.add('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
            } else {
                this.classList.remove('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
                this.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            }
        });

        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (password === confirmPassword && password.length > 0) {
                this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.add('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
            } else if (confirmPassword.length > 0) {
                this.classList.remove('border-green-300', 'focus:ring-green-500', 'focus:border-green-500');
                this.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            }
        });
    </script>
</body>

</html>
