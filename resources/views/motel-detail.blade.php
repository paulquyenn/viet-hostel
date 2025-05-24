<x-tenant-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <!-- Hero section with sticky header -->
        <div class="sticky top-0 z-30 bg-white shadow-md transition-all duration-300" x-data="{ isScrolled: false }"
            x-init="window.addEventListener('scroll', () => { isScrolled = window.pageYOffset > 100 })">
            <!-- Breadcrumb -->
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm text-gray-500">
                        <a href="{{ route('motel') }}" class="hover:text-indigo-600 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Trang chủ
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-gray-900 font-medium">{{ $room->room_number }} -
                            {{ $room->building->name }}</span>
                    </div>

                    <!-- Quick info visible on scroll -->
                    <div class="hidden md:flex items-center space-x-4" x-show="isScrolled"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="text-indigo-700 font-bold">{{ number_format($room->price) }} VND/tháng</div>
                        <a href="#contact"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-200 text-sm font-medium">Liên
                            hệ ngay</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <!-- Carousel/Gallery with Thumbnails -->
                <div class="relative" x-data="{
                    activeSlide: 0,
                    totalSlides: {{ $room->images->count() }},
                    isFullscreen: false,
                    toggleFullscreen() {
                        this.isFullscreen = !this.isFullscreen;
                        document.body.classList.toggle('overflow-hidden');
                    }
                }">
                    <!-- Fullscreen Gallery -->
                    <div x-show="isFullscreen" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black bg-opacity-90 z-50 flex flex-col">
                        <div class="flex justify-end p-4">
                            <button @click="toggleFullscreen()"
                                class="text-white hover:text-gray-300 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 flex items-center justify-center p-4 relative">
                            @foreach ($room->images as $key => $image)
                                <div x-show="activeSlide === {{ $key }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                        alt="Hình ảnh phòng {{ $key + 1 }}"
                                        class="max-h-full max-w-full object-contain">
                                </div>
                            @endforeach
                            <!-- Fullscreen controls -->
                            <div class="absolute inset-x-0 flex items-center justify-between p-4 z-10">
                                <button @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1"
                                    class="bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-3 text-white focus:outline-none transition transform hover:-translate-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1"
                                    class="bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-3 text-white focus:outline-none transition transform hover:translate-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Image counter -->
                        <div class="text-white text-center pb-6">
                            <span x-text="activeSlide + 1"></span> / <span x-text="totalSlides"></span>
                        </div>
                    </div>

                    <!-- Main carousel -->
                    <div>
                        <!-- Carousel indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-10 flex space-x-2">
                            @foreach ($room->images as $key => $image)
                                <button @click="activeSlide = {{ $key }}"
                                    :class="{
                                        'bg-white': activeSlide === {{ $key }},
                                        'bg-gray-400': activeSlide !==
                                            {{ $key }}
                                    }"
                                    class="h-2 w-12 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>

                        <!-- Carousel slides -->
                        <div class="relative h-96 md:h-[500px] overflow-hidden cursor-pointer"
                            @click="toggleFullscreen()">
                            @foreach ($room->images as $key => $image)
                                <div x-show="activeSlide === {{ $key }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-x-full"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform translate-x-0"
                                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                                    class="absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                        alt="Hình ảnh phòng {{ $key + 1 }}" class="object-cover w-full h-full">
                                    <!-- Fullscreen button -->
                                    <div class="absolute top-4 right-4">
                                        <button @click.stop="toggleFullscreen()"
                                            class="bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-2 text-white focus:outline-none transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Carousel controls -->
                        <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between p-4">
                            <button @click.stop="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1"
                                class="bg-black bg-opacity-50 hover:bg-opacity-70 hover:bg-indigo-700 rounded-full p-2 text-white focus:outline-none transition transform hover:-translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click.stop="activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1"
                                class="bg-black bg-opacity-50 hover:bg-opacity-70 hover:bg-indigo-700 rounded-full p-2 text-white focus:outline-none transition transform hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="flex overflow-x-auto px-4 py-3 space-x-3 hide-scrollbar">
                        @foreach ($room->images as $key => $image)
                            <div @click="activeSlide = {{ $key }}"
                                :class="{
                                    'ring-2 ring-indigo-600': activeSlide ===
                                        {{ $key }},
                                    'opacity-70': activeSlide !== {{ $key }}
                                }"
                                class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden cursor-pointer transition-all duration-200 hover:opacity-100">
                                <img src="{{ asset('storage/' . $image->path) }}"
                                    alt="Thumbnail {{ $key + 1 }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Room details -->
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between gap-6 mb-8">
                        <div class="md:max-w-3xl">
                            <div class="flex items-center mb-3">
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} mr-2">
                                    <span
                                        class="w-2 h-2 rounded-full {{ $room->status === 'available' ? 'bg-green-500' : 'bg-red-500' }} mr-1"></span>
                                    {{ $room->status_text }}
                                </div>
                                @if ($room->created_at->diffInDays(now()) < 7)
                                    <span
                                        class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-semibold">Mới</span>
                                @endif
                            </div>

                            <h1 class="text-3xl font-bold text-gray-900 mb-3">Phòng {{ $room->room_number }} -
                                {{ $room->building->name }}</h1>

                            <p class="text-gray-600 flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="leading-relaxed">{{ $room->building->address }},
                                    {{ $room->building->ward->name }},
                                    {{ $room->building->district->name }},
                                    {{ $room->building->province->name }}</span>
                            </p>

                            <div class="flex flex-wrap gap-3 mb-5">
                                <div
                                    class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1 text-sm text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Ngày đăng: {{ $room->created_at->format('d/m/Y') }}
                                </div>
                                <div
                                    class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1 text-sm text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    {{ $room->reviews->count() }} đánh giá
                                </div>
                            </div>
                        </div>

                        <div class="shrink-0 flex flex-col md:items-end">
                            <div
                                class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-5 rounded-xl shadow-sm text-center md:text-right w-full md:w-auto">
                                <div class="flex items-center justify-center md:justify-end">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-indigo-700 font-semibold uppercase">Giá thuê hàng
                                        tháng</span>
                                </div>
                                <div class="mt-2">
                                    <span class="text-3xl font-bold text-indigo-700">{{ number_format($room->price) }}
                                        <span class="text-lg">VND</span></span>
                                </div>
                                <div id="contact" class="mt-4 flex flex-col space-y-2">
                                    @if ($room->has_available_space)
                                        <a href="{{ route('tenant.bookings.create', $room->id) }}"
                                            class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Đặt phòng ngay
                                        </a>
                                    @endif
                                    <a href="tel:+84123456789"
                                        class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Gọi ngay
                                    </a>
                                    <button id="shareButton"
                                        class="inline-flex items-center justify-center border border-indigo-500 text-indigo-600 hover:bg-indigo-50 py-3 px-4 rounded-lg transition duration-200 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        Chia sẻ
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room amenities/info cards with icons -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div
                            class="bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md p-4 rounded-xl transition-all duration-300 flex flex-col items-center text-center">
                            <div class="bg-indigo-100 p-3 rounded-full mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-500">Diện tích</div>
                            <div class="mt-1 text-xl font-bold text-gray-900">{{ $room->area }} m²</div>
                        </div>
                        <div
                            class="bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md p-4 rounded-xl transition-all duration-300 flex flex-col items-center text-center">
                            <div class="bg-indigo-100 p-3 rounded-full mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-500">Đặt cọc</div>
                            <div class="mt-1 text-xl font-bold text-gray-900">{{ number_format($room->deposit) }} VND
                            </div>
                        </div>
                        <div
                            class="bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md p-4 rounded-xl transition-all duration-300 flex flex-col items-center text-center">
                            <div class="bg-indigo-100 p-3 rounded-full mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-500">Trạng thái</div>
                            <div
                                class="mt-1 text-xl font-bold {{ $room->status === 'available' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $room->status === 'available' ? 'Còn trống' : $room->status }}
                            </div>
                        </div>
                        <div
                            class="bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md p-4 rounded-xl transition-all duration-300 flex flex-col items-center text-center">
                            <div class="bg-indigo-100 p-3 rounded-full mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-500">Số người tối đa</div>
                            <div class="mt-1 text-xl font-bold text-gray-900">{{ $room->max_person }} người</div>
                        </div>
                    </div>

                    <!-- Room info tabs -->
                    <div x-data="{ activeTab: 'description' }" class="mb-10 overflow-hidden">
                        <!-- Tab navigation -->
                        <div class="flex border-b border-gray-200 mb-6">
                            <button @click="activeTab = 'description'"
                                :class="{ 'text-indigo-600 border-indigo-600 font-semibold': activeTab === 'description', 'text-gray-500 border-transparent hover:text-gray-700': activeTab !== 'description' }"
                                class="px-5 py-3 border-b-2 text-sm font-medium transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Chi tiết & Mô tả
                            </button>
                            <button @click="activeTab = 'amenities'"
                                :class="{ 'text-indigo-600 border-indigo-600 font-semibold': activeTab === 'amenities', 'text-gray-500 border-transparent hover:text-gray-700': activeTab !== 'amenities' }"
                                class="px-5 py-3 border-b-2 text-sm font-medium transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                Tiện ích
                            </button>
                            <button @click="activeTab = 'policy'"
                                :class="{ 'text-indigo-600 border-indigo-600 font-semibold': activeTab === 'policy', 'text-gray-500 border-transparent hover:text-gray-700': activeTab !== 'policy' }"
                                class="px-5 py-3 border-b-2 text-sm font-medium transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Quy định
                            </button>
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content">
                            <!-- Description tab -->
                            <div x-show="activeTab === 'description'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                <div class="bg-white border border-gray-100 rounded-xl p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Thông tin chi tiết
                                    </h3>
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        <p class="whitespace-pre-line">{{ $room->description }}</p>
                                    </div>

                                    <div class="mt-8">
                                        <h4 class="font-semibold text-lg mb-3">Thông tin bổ sung:</h4>
                                        <div class="grid md:grid-cols-2 gap-4">
                                            <div class="bg-gray-50 p-3 rounded-lg flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-indigo-500 mr-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <div>
                                                    <div class="text-sm text-gray-500">Khu vực</div>
                                                    <div class="font-medium">{{ $room->building->ward->name }}</div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-lg flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-indigo-500 mr-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <div>
                                                    <div class="text-sm text-gray-500">Tòa nhà</div>
                                                    <div class="font-medium">{{ $room->building->name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Amenities tab -->
                            <div x-show="activeTab === 'amenities'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                <div class="bg-white border border-gray-100 rounded-xl p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        Tiện ích
                                    </h3>

                                    <!-- Convert utilities string to list -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @php
                                            $utilitiesList = explode(',', $room->utilities);
                                        @endphp

                                        @foreach ($utilitiesList as $utility)
                                            @if (trim($utility))
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-green-500 mr-3" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-700">{{ trim($utility) }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                                        <div class="flex items-start">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6 text-indigo-500 mt-1 mr-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-indigo-900 text-sm">Tiện ích có thể khác nhau giữa các
                                                phòng. Vui lòng liên hệ với chủ nhà để biết thêm chi tiết.</p>
                                        </div>
                                    </div>

                                    <!-- Current Tenants Section -->
                                    @if ($room->current_tenant_count > 0 && isset($currentTenants) && $currentTenants->count() > 0)
                                        <div class="mt-10">
                                            <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 mr-2 text-indigo-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Người đang thuê
                                                ({{ $room->current_tenant_count }}/{{ $room->max_person }})
                                            </h3>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                @foreach ($currentTenants as $tenant)
                                                    <div
                                                        class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3 flex-shrink-0">
                                                            <span
                                                                class="text-indigo-700 font-medium">{{ substr($tenant->name, 0, 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-medium text-gray-900">{{ $tenant->name }}
                                                            </h4>
                                                            <p class="text-sm text-gray-500">
                                                                Thuê từ:
                                                                {{ \Carbon\Carbon::parse($room->contracts->where('tenant_id', $tenant->id)->first()->start_date ?? '')->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if ($room->has_available_space)
                                                <div
                                                    class="mt-4 p-3 bg-green-50 text-green-800 rounded-lg flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 mr-2 text-green-500" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Còn {{ $room->available_spots }} chỗ trống. Bạn có thể đặt
                                                        phòng ngay!</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Policy tab -->
                            <div x-show="activeTab === 'policy'" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                <div class="bg-white border border-gray-100 rounded-xl p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Quy định và chính sách
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <h4 class="font-semibold text-lg mb-2">Quy định chung:</h4>
                                            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                                                <li>Giờ giấc tự do</li>
                                                <li>Tối đa {{ $room->max_person }} người ở</li>
                                                <li>Không gây ồn ào sau 22:00</li>
                                                <li>Không hút thuốc trong phòng</li>
                                                <li>Vệ sinh chung sạch sẽ</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <h4 class="font-semibold text-lg mb-2">Quy định thanh toán:</h4>
                                            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                                                <li>Đặt cọc: {{ number_format($room->deposit) }} VND</li>
                                                <li>Thanh toán tiền phòng: Trước ngày 5 hàng tháng</li>
                                                <li>Phí điện: 3,500 VND/kWh</li>
                                                <li>Phí nước: 20,000 VND/người/tháng</li>
                                                <li>Phí internet: 100,000 VND/tháng</li>
                                            </ul>
                                        </div>

                                        <div class="bg-yellow-50 p-4 rounded-lg">
                                            <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 text-yellow-500 mr-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="text-sm text-yellow-800">
                                                    <strong>Lưu ý:</strong> Các quy định có thể thay đổi, vui lòng liên
                                                    hệ chủ nhà để biết thông tin chính xác nhất.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews section -->
                    <div class="mb-8 bg-white border border-gray-100 rounded-xl p-6">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500 mr-3"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    Đánh giá từ người thuê
                                    <span
                                        class="ml-2 text-lg font-normal text-indigo-600">({{ $room->reviews->count() }})</span>
                                </h2>
                            </div>
                            <a href="{{ route('review.create', ['room_id' => $room->id]) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 px-5 rounded-lg transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Viết đánh giá
                            </a>
                        </div>

                        @if ($room->reviews->count() > 0)
                            <div
                                class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl mb-6 flex flex-col md:flex-row md:items-center gap-6">
                                <div class="text-center md:text-left">
                                    <div class="text-4xl font-bold text-indigo-700 mb-1">
                                        {{ number_format($room->average_rating, 1) }}<span class="text-xl">/5</span>
                                    </div>
                                    <div class="flex justify-center md:justify-start">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($room->average_rating))
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 text-yellow-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">{{ $room->reviews->count() }} đánh giá
                                    </div>
                                </div>

                                <div class="hidden md:block bg-gray-300 w-px h-16 mx-4"></div>
                                <div class="md:hidden h-px w-full bg-gray-300 my-4"></div>

                                <div class="flex-1 space-y-2">
                                    @php
                                        $ratings = [0, 0, 0, 0, 0];
                                        foreach ($room->reviews as $review) {
                                            $ratings[$review->rating - 1]++;
                                        }
                                        $totalReviews = $room->reviews->count();
                                    @endphp

                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="flex items-center">
                                            <span class="w-12 text-sm text-gray-600">{{ $i }} sao</span>
                                            <div class="flex-1 h-2 mx-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="bg-yellow-400 h-full rounded-full"
                                                    style="width: {{ $totalReviews > 0 ? ($ratings[$i - 1] / $totalReviews) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="w-8 text-xs text-gray-500 text-right">{{ $ratings[$i - 1] }}</span>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Reviews list -->
                            <div x-data="{ showAll: false, reviewLimit: 3 }" class="space-y-6 mb-4">
                                @foreach ($room->reviews->take(3) as $review)
                                    <div
                                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:border-indigo-100 hover:shadow-md transition-all duration-300">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-start">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg mr-4">
                                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900 flex items-center">
                                                        {{ $review->user->name }}
                                                        @if (rand(0, 1))
                                                            <span
                                                                class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Đã
                                                                thuê</span>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4 text-yellow-400"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4 text-gray-300" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                        <span
                                                            class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if (auth()->id() === $review->user_id)
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('review.edit', $review->id) }}"
                                                        class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                        Sửa
                                                    </a>
                                                    <form action="{{ route('review.destroy', $review->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-sm text-red-600 hover:text-red-800 flex items-center"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-3 text-gray-700 bg-gray-50 p-4 rounded-lg">
                                            {{ $review->comment ?? 'Không có nhận xét' }}
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Show more reviews -->
                                <div x-show="!showAll && {{ $room->reviews->count() }} > 3" class="text-center">
                                    <button @click="showAll = true"
                                        class="mt-4 inline-flex items-center px-4 py-2 border border-indigo-300 rounded-md shadow-sm text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                        Xem thêm {{ $room->reviews->count() - 3 }} đánh giá
                                    </button>
                                </div>

                                <!-- Additional reviews (hidden by default) -->
                                <template x-if="showAll">
                                    <div class="space-y-6">
                                        @foreach ($room->reviews->skip(3) as $review)
                                            <div
                                                class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:border-indigo-100 hover:shadow-md transition-all duration-300">
                                                <div class="flex justify-between items-start mb-4">
                                                    <div class="flex items-start">
                                                        <div
                                                            class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg mr-4">
                                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="font-medium text-gray-900 flex items-center">
                                                                {{ $review->user->name }}
                                                                @if (rand(0, 1))
                                                                    <span
                                                                        class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Đã
                                                                        thuê</span>
                                                                @endif
                                                            </div>
                                                            <div class="flex items-center mt-1">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $review->rating)
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-4 w-4 text-yellow-400"
                                                                            viewBox="0 0 20 20" fill="currentColor">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-4 w-4 text-gray-300"
                                                                            viewBox="0 0 20 20" fill="currentColor">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                        </svg>
                                                                    @endif
                                                                @endfor
                                                                <span
                                                                    class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if (auth()->id() === $review->user_id)
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('review.edit', $review->id) }}"
                                                                class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4 mr-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                </svg>
                                                                Sửa
                                                            </a>
                                                            <form action="{{ route('review.destroy', $review->id) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-sm text-red-600 hover:text-red-800 flex items-center"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4 mr-1" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                    Xóa
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-3 text-gray-700 bg-gray-50 p-4 rounded-lg">
                                                    {{ $review->comment ?? 'Không có nhận xét' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </template>
                            </div>
                        @else
                            <div class="bg-indigo-50 p-6 rounded-xl text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <p class="text-lg text-gray-700 font-medium">Chưa có đánh giá nào cho phòng này.</p>
                                <p class="mt-2 text-indigo-600">Hãy là người đầu tiên chia sẻ trải nghiệm của bạn!</p>
                            </div>
                        @endif

                        <!-- Review Button -->
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('review.create', ['room_id' => $room->id]) }}"
                                class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Viết đánh giá
                            </a>
                        </div>
                    </div>

                    <!-- Similar properties section -->
                    <div class="mb-8 bg-white border border-gray-100 rounded-xl p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-500 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Phòng tương tự
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @forelse($similarRooms as $similarRoom)
                                <div
                                    class="bg-white border border-gray-200 hover:border-indigo-300 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                                    <div class="relative h-48 overflow-hidden">
                                        @if ($similarRoom->images->count() > 0)
                                            <img src="{{ asset('storage/' . $similarRoom->images->first()->path) }}"
                                                alt="{{ $similarRoom->room_number }}"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400">Không có hình ảnh</span>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 left-3">
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Còn
                                                trống</span>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <button
                                                class="p-1.5 bg-white rounded-full text-gray-700 hover:text-red-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="text-lg font-semibold text-gray-800">Phòng
                                                {{ $similarRoom->room_number }}
                                            </h3>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span class="text-sm font-medium text-gray-600 ml-1">
                                                    @if ($similarRoom->reviews->count() > 0)
                                                        {{ number_format($similarRoom->average_rating, 1) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-gray-600 text-sm mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $similarRoom->building->district->name }},
                                            {{ $similarRoom->building->province->name }}
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 mb-3">
                                            <div class="flex items-center text-gray-600 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-1 text-indigo-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                </svg>
                                                {{ $similarRoom->area }} m²
                                            </div>
                                            <div class="flex items-center text-gray-600 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-1 text-indigo-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $similarRoom->max_person }} người
                                            </div>
                                            <div class="flex items-center text-gray-600 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-1 text-indigo-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ number_format($similarRoom->price / 1000000, 1) }}tr
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <div class="flex justify-between items-center">
                                                <p class="font-bold text-indigo-600">
                                                    {{ number_format($similarRoom->price) }} <span
                                                        class="text-sm">VND/tháng</span></p>
                                                <a href="{{ route('motel.detail', $similarRoom->id) }}"
                                                    class="inline-flex items-center justify-center bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-1.5 px-3 rounded-lg text-sm transition-colors">
                                                    Chi tiết
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="lg:col-span-3 text-center py-8">
                                    <p class="text-gray-500">Không tìm thấy phòng tương tự.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fixed contact button for mobile -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-3 md:hidden z-40">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs text-gray-500">Giá thuê</div>
                    <div class="text-lg font-bold text-indigo-700">{{ number_format($room->price) }} VND</div>
                </div>
                <a href="tel:+84123456789"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-6 py-2.5 font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Liên hệ ngay
                </a>
            </div>
        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shareButton = document.getElementById('shareButton');

            shareButton.addEventListener('click', function() {
                // Get current URL
                const currentUrl = window.location.href;

                // Create a temporary input element
                const tempInput = document.createElement('input');
                tempInput.value = currentUrl;
                document.body.appendChild(tempInput);

                // Select and copy the URL
                tempInput.select();
                document.execCommand('copy');

                // Remove the temporary input
                document.body.removeChild(tempInput);

                // Show a notification or change button text temporarily
                const originalText = shareButton.innerHTML;
                shareButton.innerHTML = `
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Đã sao chép!
                                                `;

                // Revert button back to original state after 2 seconds
                setTimeout(function() {
                    shareButton.innerHTML = originalText;
                }, 2000);
            });
        });
    </script>
</x-tenant-layout>
