<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Xác nhận mật khẩu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left side - Confirm Password Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Logo -->
                <div class="text-center">
                    <div class="flex justify-center">
                        <x-application-logo class="w-16 h-16 text-indigo-600" />
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-900">Xác nhận mật khẩu</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Đây là khu vực bảo mật. Vui lòng xác nhận mật khẩu của bạn để tiếp tục.
                    </p>
                </div>

                <!-- Security Info -->
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-amber-700">
                                <strong>Bảo mật cao:</strong> Để truy cập khu vực này, bạn cần nhập lại mật khẩu của
                                mình.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Confirm Password Form -->
                <div class="bg-white">
                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                        @csrf

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
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Nhập mật khẩu để xác nhận">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:scale-105">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                Xác nhận mật khẩu
                            </button>
                        </div>

                        <!-- Back Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                <a href="{{ url()->previous() }}"
                                    class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                                    ← Quay lại trang trước
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right side - Security Illustration -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div
                class="absolute inset-0 h-full w-full bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 flex items-center justify-center p-12">
                <!-- Background pattern -->
                <div class="absolute inset-0 bg-pattern opacity-10"></div>

                <!-- Content -->
                <div class="relative z-10 text-center">
                    <div class="max-w-md">
                        <h1 class="text-4xl font-bold mb-6">
                            Bảo mật
                            <span class="block text-indigo-200">tối đa</span>
                        </h1>
                        <p class="text-lg text-indigo-100 mb-8">
                            Chúng tôi cam kết bảo vệ thông tin của bạn với các biện pháp bảo mật hàng đầu.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-indigo-100">Xác thực hai lớp</p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-indigo-100">Mã hóa SSL 256-bit</p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="ml-3 text-indigo-100">Bảo vệ dữ liệu toàn diện</p>
                            </div>
                        </div>
                    </div>

                    <!-- Security shield illustration -->
                    <div class="mt-12 relative">
                        <div class="w-32 h-32 mx-auto bg-white/10 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <!-- Animated security rings -->
                        <div class="absolute inset-0 rounded-full border-2 border-white/20 animate-pulse"></div>
                        <div
                            class="absolute inset-4 rounded-full border-2 border-white/30 animate-pulse animation-delay-1000">
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
            <svg class="animate-spin h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-700">Đang xác thực...</span>
        </div>
    </div>

    <script>
        // Show loading overlay when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });

        // Auto-focus on password field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('password').focus();
        });

        // Add custom CSS for animation delay
        const style = document.createElement('style');
        style.textContent = `
            .animation-delay-1000 {
                animation-delay: 1s;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
