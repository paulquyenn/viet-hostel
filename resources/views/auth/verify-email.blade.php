<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Xác thực email</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left side - Email Verification Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Logo -->
                <div class="text-center">
                    <div class="flex justify-center">
                        <x-application-logo class="w-16 h-16 text-indigo-600" />
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-900">Xác thực email</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Chúng tôi đã gửi liên kết xác thực đến email của bạn
                    </p>
                </div>

                <!-- Email Sent Icon -->
                <div class="flex justify-center my-8">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Main Message -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Vui lòng kiểm tra email:</strong> Chúng tôi đã gửi liên kết xác thực đến địa chỉ
                                email bạn đã đăng ký.
                                Hãy nhấn vào liên kết để hoàn tất quá trình đăng ký.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <strong>Email đã được gửi!</strong> Một liên kết xác thực mới đã được gửi đến địa
                                    chỉ email của bạn.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Instructions -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Hướng dẫn xác thực:</h3>
                    <ol class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-6 h-6 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                                1
                            </span>
                            Kiểm tra hộp thư đến trong email của bạn
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-6 h-6 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                                2
                            </span>
                            Tìm email từ {{ config('app.name', 'TRO-VIET') }} với tiêu đề "Xác thực địa chỉ email"
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-6 h-6 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                                3
                            </span>
                            Nhấp vào nút "Xác thực email" trong email
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-6 h-6 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                                4
                            </span>
                            Bạn sẽ được chuyển hướng về trang chủ
                        </li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <!-- Resend Email Button -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:scale-105">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                            </span>
                            Gửi lại email xác thực
                        </button>
                    </form>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Đăng xuất
                        </button>
                    </form>
                </div>

                <!-- Help Text -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        Không nhận được email? Kiểm tra thư mục spam hoặc
                        <a href="mailto:support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500">
                            liên hệ hỗ trợ
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right side - Email Verification Illustration -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div
                class="absolute inset-0 h-full w-full bg-gradient-to-br from-green-600 via-teal-600 to-blue-700 flex items-center justify-center p-12">
                <!-- Background pattern -->
                <div class="absolute inset-0 bg-pattern opacity-10"></div>

                <!-- Content -->
                <div class="relative z-10 text-center">
                    <div class="max-w-md">
                        <h1 class="text-4xl font-bold mb-6">
                            Xác thực
                            <span class="block text-green-200">an toàn</span>
                        </h1>
                        <p class="text-lg text-green-100 mb-8">
                            Bảo mật tài khoản của bạn bằng cách xác thực địa chỉ email. Điều này giúp chúng tôi đảm bảo
                            tính bảo mật và liên lạc hiệu quả.
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
                                <p class="ml-3 text-green-100">Bảo mật tài khoản</p>
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
                                <p class="ml-3 text-green-100">Thông báo quan trọng</p>
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
                                <p class="ml-3 text-green-100">Khôi phục mật khẩu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Email verification illustration -->
                    <div class="mt-12 relative">
                        <div class="w-32 h-32 mx-auto bg-white/10 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <!-- Animated verification rings -->
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
            <span class="text-gray-700">Đang gửi email...</span>
        </div>
    </div>

    <script>
        // Show loading overlay when resend email form is submitted
        document.querySelector('form[action="{{ route('verification.send') }}"]').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });

        // Auto-hide success message after 5 seconds
        @if (session('status') == 'verification-link-sent')
            setTimeout(function() {
                const successAlert = document.querySelector('.bg-green-50');
                if (successAlert) {
                    successAlert.style.transition = 'opacity 0.5s ease-in-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 500);
                }
            }, 5000);
        @endif

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
