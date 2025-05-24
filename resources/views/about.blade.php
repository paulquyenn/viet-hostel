<x-tenant-layout>
    <!-- Hero Section với gradient và pattern -->
    <div class="relative bg-gradient-to-b from-indigo-900 via-indigo-800 to-indigo-700 py-24 overflow-hidden">
        <!-- Pattern background -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                <path fill="#fff" fill-opacity="1"
                    d="M14 16H9v-2h5V9h2v5h5v2h-5v5h-2v-5zm-1.56 20.44l5.37-5.36 1.42 1.42-5.37 5.36-1.42-1.42zm13.12-13.12l5.37-5.37 1.42 1.42-5.37 5.37-1.42-1.42zM29 16v-2h16v2H29zm0 12v-2h16v2H29zm-1.56 12.44l5.37-5.36 1.42 1.42-5.37 5.36-1.42-1.42zm13.12-13.12l5.37-5.37 1.42 1.42-5.37 5.37-1.42-1.42zM49 16v-2h16v2H49zm0 12v-2h16v2H49zm-1.56 12.44l5.37-5.36 1.42 1.42-5.37 5.36-1.42-1.42zm13.12-13.12l5.37-5.37 1.42 1.42-5.37 5.37-1.42-1.42zM69 16v-2h5V9h2v5h5v2h-5v5h-2v-5h-5zm-1.56 20.44l5.37-5.36 1.42 1.42-5.37 5.36-1.42-1.42zm13.12-13.12l5.37-5.37 1.42 1.42-5.37 5.37-1.42-1.42z">
                </path>
            </svg>
        </div>

        <!-- Decorative circles -->
        <div
            class="absolute top-10 left-10 w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-10 right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <span
                    class="inline-block px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full mb-5">Về
                    chúng tôi</span>
                <h1 class="text-4xl md:text-6xl font-bold text-white tracking-tight mb-4">
                    Chào mừng đến với <span class="text-yellow-300 inline-block relative">
                        Trọ Việt
                        <span class="absolute bottom-1 left-0 w-full h-1 bg-yellow-300 opacity-70"></span>
                    </span>
                </h1>
                <p class="mt-4 max-w-2xl text-xl text-indigo-100 opacity-90 mx-auto font-light">
                    Kết nối không gian sống lý tưởng cho mọi nhu cầu của bạn
                </p>
            </div>
        </div>

        <!-- Wave decoration -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 200" class="fill-current text-white">
                <path fill-opacity="1"
                    d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,85.3C672,75,768,85,864,122.7C960,160,1056,224,1152,224C1248,224,1344,160,1392,128L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tầm nhìn Section -->
            <div class="mb-24">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-24 h-24 bg-indigo-100 rounded-full z-0"></div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-yellow-100 rounded-full z-0"></div>
                        <div class="aspect-w-4 aspect-h-3 relative z-10 rounded-2xl overflow-hidden shadow-2xl">
                            <img class="object-cover" src="{{ asset('images/about-banner.jpg') }}"
                                alt="Tầm nhìn Trọ Việt"
                                onerror="this.src='https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1267&q=80'">
                            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/60 via-transparent"></div>
                        </div>
                    </div>
                    <div>
                        <span
                            class="inline-block px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full mb-4">Tầm
                            nhìn</span>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Kết nối <span class="text-indigo-600">không
                                gian sống</span> và con người</h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            Trọ Việt ra đời với sứ mệnh kết nối người tìm thuê phòng và các chủ nhà trọ, mang đến giải
                            pháp tối ưu cho cả hai bên.
                            Chúng tôi tin rằng mọi người đều xứng đáng có một không gian sống phù hợp với nhu cầu và
                            ngân sách của mình.
                        </p>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            Với tầm nhìn trở thành nền tảng hàng đầu trong lĩnh vực tìm kiếm và quản lý nhà trọ, chúng
                            tôi không ngừng đổi mới
                            và nâng cao chất lượng dịch vụ, đem lại trải nghiệm tốt nhất cho người dùng.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Giá trị cốt lõi -->
            <div class="mb-24 text-center">
                <span
                    class="inline-block px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full mb-4">Giá
                    trị cốt lõi</span>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Điều tạo nên sự khác biệt</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-16">
                    Những giá trị chúng tôi theo đuổi trong mọi hoạt động và quyết định
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <div
                            class="absolute -top-5 left-1/2 transform -translate-x-1/2
                                  flex items-center justify-center h-16 w-16 rounded-full
                                  bg-gradient-to-br from-indigo-500 to-purple-600
                                  text-white mb-4 group-hover:rotate-6 transition-transform">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="pt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Chất lượng</h3>
                            <p class="text-gray-600">Cam kết cung cấp thông tin chính xác, đầy đủ và những dịch vụ chất
                                lượng cao nhất.</p>
                        </div>
                    </div>

                    <div
                        class="group relative bg-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <div
                            class="absolute -top-5 left-1/2 transform -translate-x-1/2
                                  flex items-center justify-center h-16 w-16 rounded-full
                                  bg-gradient-to-br from-indigo-500 to-purple-600
                                  text-white mb-4 group-hover:rotate-6 transition-transform">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="pt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Tin cậy</h3>
                            <p class="text-gray-600">Xây dựng niềm tin là ưu tiên hàng đầu, mọi người dùng đều được đối
                                xử công bằng và minh bạch.</p>
                        </div>
                    </div>

                    <div
                        class="group relative bg-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <div
                            class="absolute -top-5 left-1/2 transform -translate-x-1/2
                                  flex items-center justify-center h-16 w-16 rounded-full
                                  bg-gradient-to-br from-indigo-500 to-purple-600
                                  text-white mb-4 group-hover:rotate-6 transition-transform">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="pt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Hiệu quả</h3>
                            <p class="text-gray-600">Tối ưu hóa quy trình để mang lại kết quả nhanh chóng và chính xác
                                cho người dùng.</p>
                        </div>
                    </div>

                    <div
                        class="group relative bg-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <div
                            class="absolute -top-5 left-1/2 transform -translate-x-1/2
                                  flex items-center justify-center h-16 w-16 rounded-full
                                  bg-gradient-to-br from-indigo-500 to-purple-600
                                  text-white mb-4 group-hover:rotate-6 transition-transform">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="pt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Trải nghiệm</h3>
                            <p class="text-gray-600">Tạo ra trải nghiệm người dùng xuất sắc ở mọi điểm tiếp xúc với dịch
                                vụ của chúng tôi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin và con số -->
            <div class="mb-24">
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-12">
                            <span
                                class="inline-block px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full mb-4">Lịch
                                sử phát triển</span>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Hành trình của chúng tôi</h2>

                            <div class="space-y-8">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white">
                                            2020
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Khởi đầu</h3>
                                        <p class="mt-2 text-base text-gray-600">Trọ Việt được thành lập với sứ mệnh kết
                                            nối không gian sống.</p>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white">
                                            2022
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Mở rộng</h3>
                                        <p class="mt-2 text-base text-gray-600">Mở rộng hoạt động tới nhiều tỉnh thành
                                            trên cả nước.</p>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white">
                                            2025
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Hiện tại</h3>
                                        <p class="mt-2 text-base text-gray-600">Tiếp tục đổi mới và hoàn thiện với công
                                            nghệ hiện đại.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white p-12 flex items-center">
                            <div class="grid grid-cols-2 gap-8 w-full">
                                <div class="text-center">
                                    <div class="text-5xl font-bold mb-2">1000+</div>
                                    <div class="text-indigo-100">Phòng trọ</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-5xl font-bold mb-2">25+</div>
                                    <div class="text-indigo-100">Tỉnh thành</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-5xl font-bold mb-2">500+</div>
                                    <div class="text-indigo-100">Chủ nhà</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-5xl font-bold mb-2">10k+</div>
                                    <div class="text-indigo-100">Người dùng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="relative overflow-hidden rounded-3xl">
                <div
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 py-16 px-8 md:py-20 md:px-16 text-center relative z-10">
                    <div class="max-w-3xl mx-auto">
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Hãy cùng nhau tìm kiếm không gian
                            sống lý tưởng</h2>
                        <p class="text-xl text-indigo-100 mb-10 leading-relaxed">
                            Bạn có câu hỏi hoặc cần tư vấn về việc tìm phòng trọ phù hợp?
                            Đội ngũ chuyên nghiệp của chúng tôi luôn sẵn sàng hỗ trợ.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('contact') }}"
                                class="inline-block bg-white text-indigo-600 font-medium px-8 py-4 rounded-xl hover:bg-gray-50 transition duration-300 transform hover:-translate-y-1 shadow-lg">
                                <span class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Liên hệ ngay
                                </span>
                            </a>
                            <a href="{{ route('motel') }}"
                                class="inline-block bg-indigo-800 bg-opacity-50 text-white font-medium px-8 py-4 rounded-xl hover:bg-opacity-70 transition duration-300 border border-white/30 backdrop-blur-sm transform hover:-translate-y-1 shadow-lg">
                                <span class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Tìm phòng trọ
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                    <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full opacity-10"></div>
                    <div class="absolute bottom-10 right-10 w-32 h-32 bg-yellow-300 rounded-full opacity-10"></div>
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-300 rounded-full opacity-10 blur-2xl">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
