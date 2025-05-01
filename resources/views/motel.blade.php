<x-tenant-layout>
    <div class="bg-gray-50 min-h-screen pb-10">
        <!-- Hero Section with Search -->
        <div class="relative bg-indigo-600 h-64 md:h-80">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-indigo-800 opacity-90"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center w-full max-w-3xl">
                    <h1 class="text-white text-3xl md:text-4xl font-bold mb-4">Tìm phòng trọ phù hợp với bạn</h1>
                    <div class="bg-white p-1 rounded-full shadow-lg">
                        <div class="flex items-center">
                            <input type="text" placeholder="Tìm kiếm phòng trọ..."
                                class="w-full px-5 py-3 rounded-full focus:outline-none" />
                            <button
                                class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition">
                                <i class="fas fa-search mr-2"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Results Section -->
        <div class="container mx-auto px-4 -mt-10 relative z-20">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Bộ lọc tìm kiếm</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa điểm</label>
                        <select
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option>Tất cả địa điểm</option>
                            <option>Hà Nội</option>
                            <option>Hồ Chí Minh</option>
                            <option>Đà Nẵng</option>
                            <option>Cần Thơ</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Giá (VNĐ/tháng)</label>
                        <div class="flex space-x-2">
                            <input type="number" placeholder="Từ"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <input type="number" placeholder="Đến"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Diện tích (m²)</label>
                        <div class="flex space-x-2">
                            <input type="number" placeholder="Từ"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <input type="number" placeholder="Đến"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Áp
                        dụng</button>
                </div>
            </div>

            <!-- Results Section -->
            <h2 class="text-2xl font-bold mb-6">Kết quả tìm kiếm</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Motel Card 1 -->
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-52">
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267" alt="Phòng trọ"
                            class="w-full h-full object-cover">
                        <div class="absolute top-0 right-0 bg-indigo-600 text-white px-3 py-1 m-2 rounded-md">
                            <span class="font-semibold">2.5 triệu/tháng</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Phòng trọ cao cấp Quận 7</h3>
                        <p class="text-gray-600 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            123 Nguyễn Văn Linh, Quận 7, TP. HCM
                        </p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                </svg>
                                25m²
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7m-7-7v14" />
                                </svg>
                                Lầu 3
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Hôm nay
                            </span>
                        </div>
                        <div class="mt-4">
                            <a href="#"
                                class="block text-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">Xem
                                chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Motel Card 2 -->
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-52">
                        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2" alt="Phòng trọ"
                            class="w-full h-full object-cover">
                        <div class="absolute top-0 right-0 bg-indigo-600 text-white px-3 py-1 m-2 rounded-md">
                            <span class="font-semibold">1.8 triệu/tháng</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Phòng trọ gần ĐH Bách Khoa</h3>
                        <p class="text-gray-600 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            45 Lý Thường Kiệt, Quận 10, TP. HCM
                        </p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                </svg>
                                18m²
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7m-7-7v14" />
                                </svg>
                                Lầu 2
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Hôm qua
                            </span>
                        </div>
                        <div class="mt-4">
                            <a href="#"
                                class="block text-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">Xem
                                chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Motel Card 3 -->
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-52">
                        <img src="https://images.unsplash.com/photo-1598928506311-c55ded91a20c" alt="Phòng trọ"
                            class="w-full h-full object-cover">
                        <div class="absolute top-0 right-0 bg-indigo-600 text-white px-3 py-1 m-2 rounded-md">
                            <span class="font-semibold">3 triệu/tháng</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Căn hộ mini full nội thất</h3>
                        <p class="text-gray-600 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            78 Võ Văn Tần, Quận 3, TP. HCM
                        </p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                </svg>
                                30m²
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7m-7-7v14" />
                                </svg>
                                Lầu 5
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                3 ngày trước
                            </span>
                        </div>
                        <div class="mt-4">
                            <a href="#"
                                class="block text-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">Xem
                                chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-3 py-2 rounded-md border text-gray-500 hover:bg-gray-50">Trước</a>
                    <a href="#" class="px-3 py-2 rounded-md border bg-indigo-600 text-white">1</a>
                    <a href="#" class="px-3 py-2 rounded-md border text-gray-500 hover:bg-gray-50">2</a>
                    <a href="#" class="px-3 py-2 rounded-md border text-gray-500 hover:bg-gray-50">3</a>
                    <span class="px-3 py-2">...</span>
                    <a href="#" class="px-3 py-2 rounded-md border text-gray-500 hover:bg-gray-50">10</a>
                    <a href="#" class="px-3 py-2 rounded-md border text-gray-500 hover:bg-gray-50">Sau</a>
                </nav>
            </div>
        </div>
    </div>
</x-tenant-layout>
