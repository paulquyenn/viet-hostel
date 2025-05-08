<x-tenant-layout>
    <!-- Hero Section với gradient và animation -->
    <div
        class="relative bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-400 min-h-[40vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl mb-4">
                    <span class="block">Liên Hệ Với Chúng Tôi</span>
                </h1>
                <p class="max-w-xl mt-5 mx-auto text-xl text-white/80">Chúng tôi luôn sẵn sàng hỗ trợ và lắng nghe ý kiến
                    của bạn.</p>
                <div class="mt-8 flex justify-center">
                    <div class="rounded-md shadow">
                        <a href="#contact-form"
                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10 transition duration-300 ease-in-out transform hover:-translate-y-1">
                            Gửi tin nhắn
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative elements -->
        <div class="hidden lg:block absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -mb-16 -ml-16"></div>
        <div class="hidden lg:block absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -mt-20 -mr-20"></div>
    </div>

    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12" id="contact-form">
                <!-- Contact Form with improved design -->
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition hover:shadow-2xl duration-300 border border-gray-100">
                    <div class="px-6 py-8 sm:p-10">
                        <div class="flex items-center mb-8">
                            <div class="bg-indigo-100 rounded-full p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Gửi tin nhắn cho chúng tôi</h2>
                        </div>

                        <form class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="relative">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và
                                        tên</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="name" name="name"
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                                            placeholder="Nguyễn Văn A">
                                    </div>
                                </div>
                                <div class="relative">
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                                            placeholder="example@email.com">
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Tiêu
                                    đề</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="subject" name="subject"
                                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                                        placeholder="Tiêu đề tin nhắn">
                                </div>
                            </div>
                            <div class="relative">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Nội
                                    dung</label>
                                <div class="relative rounded-md shadow-sm">
                                    <textarea id="message" name="message" rows="5"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                                        placeholder="Nhập nội dung tin nhắn của bạn..."></textarea>
                                </div>
                            </div>
                            <div>
                                <button type="submit"
                                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-indigo-200 group-hover:text-indigo-100" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </span>
                                    Gửi tin nhắn
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info with improved design -->
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition hover:shadow-2xl duration-300 border border-gray-100">
                    <div class="px-6 py-8 sm:p-10">
                        <div class="flex items-center mb-8">
                            <div class="bg-indigo-100 rounded-full p-3 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Thông tin liên hệ</h2>
                        </div>

                        <div class="space-y-8">
                            <div
                                class="flex items-start p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition duration-300">
                                <div class="bg-indigo-100 rounded-full p-3 flex-shrink-0">
                                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">Địa chỉ</p>
                                    <p class="mt-1 text-gray-600">123 Đường Nguyễn Văn Linh, Quận 7, TP. Hồ Chí Minh
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-start p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition duration-300">
                                <div class="bg-indigo-100 rounded-full p-3 flex-shrink-0">
                                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">Điện thoại</p>
                                    <p class="mt-1 text-gray-600">+84 28 1234 5678</p>
                                </div>
                            </div>

                            <div
                                class="flex items-start p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition duration-300">
                                <div class="bg-indigo-100 rounded-full p-3 flex-shrink-0">
                                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">Email</p>
                                    <p class="mt-1 text-gray-600">info@example.com</p>
                                </div>
                            </div>

                            <div
                                class="flex items-start p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition duration-300">
                                <div class="bg-indigo-100 rounded-full p-3 flex-shrink-0">
                                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">Giờ làm việc</p>
                                    <p class="mt-1 text-gray-600">Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                                    <p class="text-gray-600">Thứ 7: 8:00 - 12:00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="mt-10">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Theo dõi chúng tôi</h3>
                            <div class="flex space-x-5">
                                <a href="#"
                                    class="bg-gray-100 p-3 rounded-full hover:bg-blue-100 hover:text-blue-600 transition duration-300">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="bg-gray-100 p-3 rounded-full hover:bg-pink-100 hover:text-pink-600 transition duration-300">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="bg-gray-100 p-3 rounded-full hover:bg-blue-100 hover:text-blue-500 transition duration-300">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="bg-gray-100 p-3 rounded-full hover:bg-green-100 hover:text-green-600 transition duration-300">
                                    <span class="sr-only">Zalo</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"
                                        fill="currentColor">
                                        <path
                                            d="M24,4C12.95,4,4,12.95,4,24s8.95,20,20,20s20-8.95,20-20S35.05,4,24,4z M13.7,12.2h14.4c0.55,0,1,0.45,1,1v0.5 c0,0.55-0.45,1-1,1h-14.4c-0.55,0-1-0.45-1-1v-0.5C12.7,12.64,13.14,12.2,13.7,12.2z M34.38,27.9c-0.02,0.09-0.04,0.19-0.07,0.29 c-0.64,2.62-3.3,3.82-5.64,2.78c-2.35-1.05-5.66-2.14-5.73-2.17c-1.36-0.29-2.76,0.57-3.05,1.94c-0.29,1.36,0.57,2.76,1.94,3.05 c0.03,0.01,3.28,1.07,5.74,2.17c0.8,0.36,1.65,0.53,2.49,0.53c3.38,0,6.4-2.53,6.85-6c0-0.01,0-0.02,0.01-0.04 c0.02-0.16,0.04-0.33,0.05-0.5c0.01-0.13,0.02-0.26,0.02-0.4c0.01-0.12,0-0.25,0-0.37c-0.01-0.12-0.01-0.24-0.02-0.36 c-0.01-0.13-0.04-0.26-0.06-0.39c-0.03-0.12-0.05-0.25-0.08-0.37c-0.04-0.13-0.08-0.26-0.13-0.39c-0.05-0.12-0.1-0.24-0.15-0.36 c-0.05-0.12-0.12-0.22-0.18-0.34c-0.06-0.08-0.11-0.17-0.17-0.25c-0.09-0.14-0.19-0.28-0.3-0.41c-0.05-0.06-0.1-0.13-0.15-0.18 c-0.09-0.1-0.19-0.2-0.29-0.29c-0.1-0.09-0.19-0.17-0.29-0.25c-0.1-0.08-0.2-0.16-0.31-0.23c-0.11-0.07-0.23-0.14-0.35-0.21 c-0.06-0.03-0.11-0.07-0.17-0.1l-11.6-6.27c-0.68-0.37-1.5-0.28-2.08,0.19C13.89,16.9,9.23,21.1,9.56,21.44 c0.49,0.51,4.5-1.91,7.91-4.05l10.62,5.69c0.19,0.1,0.37,0.24,0.53,0.4c0.16,0.16,0.29,0.32,0.4,0.51c0.11,0.19,0.19,0.39,0.23,0.61 c0.05,0.23,0.07,0.45,0.04,0.68c-0.08,0.64-0.46,1.21-1.01,1.5c-1.1,0.59-3.15,1.5-5.02,2.31c-0.04,0.02-0.08,0.04-0.12,0.05 c-0.56,0.24-0.95,0.68-1.04,1.2c-0.09,0.53,0.11,1.07,0.54,1.45c0.98,0.86,3.94,1.83,7.77,1.83c3.83,0,7.26-0.98,7.96-2.03 c0.58-0.87-0.58-2.58-1.45-3.53c-0.08-0.08-0.15-0.16-0.24-0.24c-0.57-0.54-1.47-0.51-2.01,0.06c-0.54,0.57-0.51,1.47,0.06,2.01 c0.07,0.07,0.14,0.13,0.2,0.2c0.19,0.2,0.34,0.37,0.44,0.5C34.96,29.2,34.5,28.49,34.38,27.9z M30,26.5c0.83,0,1.5-0.67,1.5-1.5 s-0.67-1.5-1.5-1.5c-0.83,0-1.5,0.67-1.5,1.5S29.17,26.5,30,26.5z M27,25c0-0.43-0.1-0.84-0.3-1.2c-0.2-0.37-0.45-0.7-0.8-0.94 c-0.33-0.25-0.71-0.44-1.12-0.55C24.38,22.1,23.9,22.04,23.42,22.1c-0.46,0.04-0.9,0.19-1.3,0.41c-0.41,0.22-0.77,0.5-1.06,0.87 c-0.3,0.36-0.52,0.76-0.65,1.22c-0.14,0.47-0.18,0.92-0.11,1.4c0.07,0.47,0.24,0.9,0.48,1.29c0.25,0.39,0.56,0.7,0.93,0.94 c0.37,0.24,0.8,0.41,1.27,0.5c0.47,0.09,0.95,0.08,1.4-0.03c0.45-0.11,0.88-0.3,1.25-0.57c0.37-0.27,0.69-0.61,0.93-1.03 c0.12-0.2,0.22-0.42,0.28-0.65c0.07-0.23,0.12-0.46,0.14-0.7l0.02-0.21v-0.12l0-0.07v-0.07V25z M23.92,27.42 c-0.04,0.08-0.09,0.15-0.14,0.21c-0.14,0.19-0.33,0.34-0.53,0.45c-0.21,0.11-0.42,0.17-0.64,0.2c-0.23,0.03-0.45,0.03-0.66-0.02 c-0.2-0.05-0.4-0.13-0.58-0.26c-0.18-0.12-0.33-0.27-0.44-0.45c-0.12-0.17-0.19-0.37-0.24-0.58c-0.04-0.21-0.04-0.41-0.01-0.61 c0.04-0.2,0.12-0.39,0.22-0.55c0.11-0.17,0.25-0.3,0.42-0.42c0.16-0.11,0.35-0.19,0.55-0.24c0.2-0.04,0.41-0.04,0.61,0 c0.21,0.04,0.4,0.13,0.58,0.24c0.17,0.11,0.3,0.25,0.39,0.41c0.03,0.05,0.06,0.1,0.08,0.16c0.02,0.05,0.04,0.11,0.06,0.17 c0.04,0.11,0.06,0.24,0.07,0.36L24,26.24l0,0.05l0,0.03v0.22c0,0.12-0.01,0.24-0.03,0.36C23.98,27.02,23.96,27.14,23.92,27.42z M19,26.5c0.83,0,1.5-0.67,1.5-1.5s-0.67-1.5-1.5-1.5c-0.83,0-1.5,0.67-1.5,1.5S18.17,26.5,19,26.5z M35.3,34.8h-14.4 c-0.55,0-1-0.45-1-1v-0.5c0-0.55,0.45-1,1-1h14.4c0.55,0,1,0.45,1,1v0.5C36.3,34.36,35.86,34.8,35.3,34.8z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section with shadow and styling -->
            <div class="mt-16">
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition hover:shadow-2xl duration-300">
                    <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h2 class="ml-3 text-2xl font-bold text-white">Vị trí của chúng tôi</h2>
                        </div>
                        <p class="text-indigo-100 ml-9">Ghé thăm văn phòng của chúng tôi tại địa chỉ bên dưới</p>
                    </div>
                    <div class="h-96 relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none">
                        </div>
                        <iframe class="w-full h-full"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59912.57478730237!2d105.63770052119137!3d18.679016599999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3139cddf0bf29e9d%3A0x987a820e4a10c3df!2zVGjDoG5oIHBo4buRIFZpbmgsIE5naOG7hyBBbiwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1631234567890!5m2!1svi!2s"
                            style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add some CSS -->
    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 0.5;
        }

        input:focus::placeholder,
        textarea:focus::placeholder {
            opacity: 0.3;
        }
    </style>
</x-tenant-layout>
