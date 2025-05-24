<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Đặt lại mật khẩu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left side - Reset Password Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Logo -->
                <div class="text-center">
                    <div class="flex justify-center">
                        <x-application-logo class="w-16 h-16 text-indigo-600" />
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-900">Tạo mật khẩu mới</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Vui lòng nhập mật khẩu mới cho tài khoản của bạn.
                    </p>
                </div>

                <!-- Security Info -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Tạo mật khẩu mạnh:</strong> Sử dụng ít nhất 8 ký tự với sự kết hợp của chữ cái,
                                số và ký tự đặc biệt.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reset Password Form -->
                <div class="bg-white">
                    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Địa chỉ email
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
                                <input id="email" name="email" type="email" autocomplete="username" required
                                    value="{{ old('email', $request->email) }}"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    readonly>
                            </div>
                            @if ($errors->get('email'))
                                <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('email')) }}</p>
                            @endif
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Mật khẩu mới
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
                                    class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Nhập mật khẩu mới">
                                <button type="button" onclick="togglePasswordVisibility('password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg id="password-eye" class="h-5 w-5 text-gray-400 hover:text-gray-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-1">
                                <div class="password-strength-bar">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div id="strength-bar" class="h-1.5 rounded-full transition-all duration-300">
                                        </div>
                                    </div>
                                    <p id="strength-text" class="text-xs text-gray-500 mt-1">Độ mạnh mật khẩu</p>
                                </div>
                            </div>
                            @if ($errors->get('password'))
                                <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('password')) }}</p>
                            @endif
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
                                    class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Nhập lại mật khẩu mới">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg id="password_confirmation-eye"
                                        class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div id="password-match" class="mt-1 text-xs"></div>
                            @if ($errors->get('password_confirmation'))
                                <p class="mt-2 text-sm text-red-600">
                                    {{ implode(', ', $errors->get('password_confirmation')) }}</p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:scale-105">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                        </path>
                                    </svg>
                                </span>
                                Đặt lại mật khẩu
                            </button>
                        </div>

                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Nhớ mật khẩu rồi?
                                <a href="{{ route('login') }}"
                                    class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                                    Quay lại đăng nhập
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
                class="absolute inset-0 h-full w-full bg-gradient-to-br from-indigo-600 via-blue-600 to-purple-700 flex items-center justify-center p-12">
                <!-- Background pattern -->
                <div class="absolute inset-0 bg-pattern opacity-10"></div>

                <!-- Content -->
                <div class="relative z-10 text-center">
                    <div class="max-w-md">
                        <h1 class="text-4xl font-bold mb-6">
                            Bảo mật
                            <span class="block text-blue-200">thông tin</span>
                        </h1>
                        <p class="text-lg text-blue-100 mb-8">
                            Mật khẩu mới sẽ giúp bảo vệ tài khoản của bạn khỏi những truy cập trái phép.
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
                                <p class="ml-3 text-blue-100">Mã hóa dữ liệu mạnh mẽ</p>
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
                                <p class="ml-3 text-blue-100">Xác thực an toàn</p>
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
                                <p class="ml-3 text-blue-100">Bảo vệ 24/7</p>
                            </div>
                        </div>
                    </div>

                    <!-- Password shield illustration -->
                    <div class="mt-12 relative">
                        <div class="w-32 h-32 mx-auto bg-white/10 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z">
                                </path>
                            </svg>
                        </div>
                        <!-- Animated lock rings -->
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
            <span class="text-gray-700">Đang đặt lại mật khẩu...</span>
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

        // Toggle password visibility
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');

            if (field.type === 'password') {
                field.type = 'text';
                eye.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                field.type = 'password';
                eye.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');

            let score = 0;
            let feedback = '';

            if (password.length >= 8) score++;
            if (password.match(/[a-z]/)) score++;
            if (password.match(/[A-Z]/)) score++;
            if (password.match(/[0-9]/)) score++;
            if (password.match(/[^a-zA-Z0-9]/)) score++;

            switch (score) {
                case 0:
                case 1:
                    strengthBar.className = 'h-1.5 rounded-full bg-red-500 transition-all duration-300';
                    strengthBar.style.width = '20%';
                    feedback = 'Rất yếu';
                    break;
                case 2:
                    strengthBar.className = 'h-1.5 rounded-full bg-orange-500 transition-all duration-300';
                    strengthBar.style.width = '40%';
                    feedback = 'Yếu';
                    break;
                case 3:
                    strengthBar.className = 'h-1.5 rounded-full bg-yellow-500 transition-all duration-300';
                    strengthBar.style.width = '60%';
                    feedback = 'Trung bình';
                    break;
                case 4:
                    strengthBar.className = 'h-1.5 rounded-full bg-blue-500 transition-all duration-300';
                    strengthBar.style.width = '80%';
                    feedback = 'Mạnh';
                    break;
                case 5:
                    strengthBar.className = 'h-1.5 rounded-full bg-green-500 transition-all duration-300';
                    strengthBar.style.width = '100%';
                    feedback = 'Rất mạnh';
                    break;
            }

            strengthText.textContent = feedback || 'Độ mạnh mật khẩu';
        });

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('password-match');

            if (confirmPassword) {
                if (password === confirmPassword) {
                    matchDiv.innerHTML = '<span class="text-green-600">✓ Mật khẩu khớp</span>';
                } else {
                    matchDiv.innerHTML = '<span class="text-red-600">✗ Mật khẩu không khớp</span>';
                }
            } else {
                matchDiv.innerHTML = '';
            }
        }

        document.getElementById('password').addEventListener('input', checkPasswordMatch);
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

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
