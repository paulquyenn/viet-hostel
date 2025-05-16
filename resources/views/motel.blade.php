<x-tenant-layout>
    <div class="bg-gray-50 min-h-screen pb-10">
        <!-- Hero Section with Search - Improved Design -->
        <div
            class="relative h-[450px] md:h-[550px] overflow-hidden bg-gradient-to-br from-indigo-900 via-purple-800 to-indigo-800">
            <!-- Background pattern overlay -->
            <div class="absolute inset-0 bg-pattern opacity-10"></div>

            <!-- Wave decoration -->
            <div class="absolute left-0 right-0 bottom-0 w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 280" class="fill-current text-gray-50">
                    <path fill-opacity="1"
                        d="M0,224L48,202.7C96,181,192,139,288,149.3C384,160,480,224,576,229.3C672,235,768,181,864,170.7C960,160,1056,192,1152,186.7C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>

            <!-- Decorative circles -->
            <div
                class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-purple-400 to-indigo-400 rounded-full blur-3xl opacity-20">
            </div>
            <div
                class="absolute bottom-40 right-10 w-40 h-40 bg-gradient-to-br from-indigo-400 to-pink-400 rounded-full blur-3xl opacity-20">
            </div>

            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center w-full max-w-4xl">
                    <!-- Animated heading -->
                    <h1 class="text-white text-3xl md:text-5xl font-bold mb-4 md:mb-6 tracking-tight">
                        Tìm <span class="relative inline-block text-yellow-300">
                            phòng trọ
                            <span class="absolute bottom-1 left-0 w-full h-1 bg-yellow-300/50 rounded-full"></span>
                        </span> lý tưởng <br class="hidden md:block"> cho cuộc sống của bạn
                    </h1>

                    <p class="text-white/90 text-base md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto font-light">
                        Hơn 10.000+ phòng trọ chất lượng với giá cả phù hợp đang chờ bạn
                    </p>

                    <!-- Enhanced Search Form -->
                    <div class="relative max-w-3xl mx-auto">
                        <form action="{{ route('motel') }}" method="GET">
                            <div
                                class="p-2 bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl hover:shadow-indigo-500/20 transition-all duration-300">
                                <div class="flex flex-col md:flex-row items-center">
                                    <div
                                        class="flex items-center w-full bg-gray-50 rounded-xl p-2 md:mr-2 mb-2 md:mb-0">
                                        <div class="pl-3 pr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search"
                                            placeholder="Nhập địa chỉ, khu vực hoặc tên phòng trọ..."
                                            value="{{ request('search') }}"
                                            class="w-full py-3 px-2 text-gray-800 rounded-xl bg-transparent border-0 focus:ring-0 focus:outline-none" />
                                    </div>
                                    <button type="submit"
                                        class="w-full md:w-auto flex items-center justify-center px-6 py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-indigo-500/50 transition-all duration-300 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <span>Tìm kiếm</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Quick filters -->
                            <div class="mt-6 flex flex-wrap justify-center gap-2 md:gap-4 text-sm">
                                <a href="{{ route('motel', ['price_to' => 2000000]) }}"
                                    class="bg-white/20 backdrop-blur-sm text-white px-3 py-1.5 md:px-4 md:py-2 rounded-full hover:bg-white/30 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 mr-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Dưới 2 triệu</span>
                                </a>
                                <a href="{{ route('motel', ['area_from' => 20]) }}"
                                    class="bg-white/20 backdrop-blur-sm text-white px-3 py-1.5 md:px-4 md:py-2 rounded-full hover:bg-white/30 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 mr-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                    </svg>
                                    <span>Trên 20m²</span>
                                </a>
                                <a href="{{ route('motel', ['status' => '0']) }}"
                                    class="bg-white/20 backdrop-blur-sm text-white px-3 py-1.5 md:px-4 md:py-2 rounded-full hover:bg-white/30 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 mr-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Còn trống</span>
                                </a>
                                <a href="{{ route('motel') }}"
                                    class="bg-white/20 backdrop-blur-sm text-white px-3 py-1.5 md:px-4 md:py-2 rounded-full hover:bg-white/30 transition-all duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 mr-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span>Tất cả phòng</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Results Section -->
        <div class="container mx-auto px-4 -mt-16 relative z-20">
            <!-- Improved Filter Card -->
            <div class="bg-white rounded-2xl shadow-xl p-5 md:p-8 mb-10 border border-gray-100">
                <h2 class="text-lg md:text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 text-indigo-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Bộ lọc tìm kiếm</span>
                    <button type="button" id="toggleFilterBtn"
                        class="ml-auto text-gray-500 hover:text-indigo-600 text-sm flex items-center md:hidden">
                        <span id="filterBtnText">Hiện bộ lọc</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </h2>

                <form action="{{ route('motel') }}" method="GET" id="filterForm"
                    class="space-y-6 hidden md:block">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Location filter -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Địa điểm
                            </label>
                            <select name="province_id" id="province_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white text-sm">
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="relative">
                                <select name="district_id" id="district_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white text-sm {{ empty(request('province_id')) ? 'opacity-75 cursor-not-allowed' : '' }}"
                                    {{ empty(request('province_id')) ? 'disabled' : '' }}>
                                    <option value="">Chọn Quận/Huyện</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Price filter -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Giá phòng (VNĐ/tháng)
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="number" name="price_from" placeholder="Từ"
                                        value="{{ request('price_from') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm" />
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                                        ₫
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="number" name="price_to" placeholder="Đến"
                                        value="{{ request('price_to') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm" />
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                                        ₫
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Area filter -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                </svg>
                                Diện tích (m²)
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="number" name="area_from" placeholder="Từ"
                                        value="{{ request('area_from') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm" />
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                                        m²
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="number" name="area_to" placeholder="Đến"
                                        value="{{ request('area_to') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm" />
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                                        m²
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col md:flex-row md:items-center justify-between pt-4 border-t border-gray-100">
                        <div class="mb-4 md:mb-0">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="status" value="0"
                                    class="h-4 w-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                    {{ request('status') === '0' || request('status') === null ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700 text-sm">Chỉ hiển thị phòng còn trống</span>
                            </label>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('motel') }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Xóa bộ lọc
                            </a>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 flex items-center shadow-md text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Áp dụng lọc
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 text-indigo-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Kết quả tìm kiếm
                </h2>

                <div class="flex items-center">
                    <span class="text-sm text-gray-600 mr-2 hidden md:inline">Sắp xếp theo:</span>
                    <select id="sortOptions"
                        class="border border-gray-300 rounded-lg px-2 py-1 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="newest">Mới nhất</option>
                        <option value="price_low">Giá thấp nhất</option>
                        <option value="price_high">Giá cao nhất</option>
                        <option value="area_low">Diện tích nhỏ nhất</option>
                        <option value="area_high">Diện tích lớn nhất</option>
                    </select>
                </div>
            </div>

            @if ($rooms->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                    <!-- Motel Cards -->
                    @foreach ($rooms as $room)
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <div class="relative h-48 sm:h-52">
                                @if ($room->images->count() > 0)
                                    <img src="{{ asset('storage/' . $room->images->first()->path) }}" alt="Phòng trọ"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">Không có hình ảnh</span>
                                    </div>
                                @endif
                                <div
                                    class="absolute top-0 right-0 bg-indigo-600 text-white px-3 py-1 m-2 rounded-md text-sm">
                                    <span class="font-medium">{{ number_format($room->price) }} đ/tháng</span>
                                </div>
                                <div
                                    class="absolute top-0 left-0 {{ $room->status == 'Còn trống' ? 'bg-green-500' : 'bg-red-500' }} text-white px-2 py-1 m-2 rounded-md text-sm">
                                    <span class="font-medium">{{ $room->status }}</span>
                                </div>

                                <!-- Image counter badge -->
                                @if ($room->images->count() > 1)
                                    <div
                                        class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-md flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $room->images->count() }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-base md:text-lg text-gray-800 flex-grow">
                                        {{ $room->room_number }}</h3>
                                    <div class="flex items-center text-yellow-500 ml-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1">
                                            @if ($room->reviews->count() > 0)
                                                {{ number_format($room->average_rating, 1) }}
                                                ({{ $room->reviews->count() }})
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-2 line-clamp-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 mr-1 flex-shrink-0 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $room->building->full_address }}</span>
                                </p>
                                <div class="flex justify-between text-sm text-gray-600 mt-3 mb-3">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                        </svg>
                                        {{ $room->area }}m²
                                    </span>
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $room->max_person }} người
                                    </span>
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($room->created_at)->format('d/m/Y') }}
                                    </span>
                                </div>

                                <!-- Tags -->
                                <div class="flex flex-wrap gap-1 my-2">
                                    @if ($room->has_wifi)
                                        <span
                                            class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full">WiFi</span>
                                    @endif
                                    @if ($room->has_parking)
                                        <span class="bg-green-50 text-green-700 text-xs px-2 py-0.5 rounded-full">Chỗ
                                            đỗ xe</span>
                                    @endif
                                    @if ($room->has_private_wc)
                                        <span class="bg-purple-50 text-purple-700 text-xs px-2 py-0.5 rounded-full">WC
                                            riêng</span>
                                    @endif
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('motel.detail', $room->id) }}"
                                        class="block text-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition text-sm font-medium">Xem
                                        chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    @if ($rooms->lastPage() > 1)
                        <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow">
                            <!-- Previous Page Link -->
                            @if ($rooms->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 cursor-not-allowed text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Trước
                                </span>
                            @else
                                <a href="{{ $rooms->previousPageUrl() }}"
                                    class="px-3 py-1 text-indigo-600 hover:text-indigo-800 transition text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Trước
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            <div class="hidden md:flex items-center space-x-1 mx-2">
                                {{-- "Three Dots" Separator --}}
                                @if ($rooms->currentPage() > 3)
                                    <a href="{{ $rooms->url(1) }}"
                                        class="px-3 py-1 rounded-md hover:bg-indigo-50 text-indigo-600 text-sm">1</a>
                                    @if ($rooms->currentPage() > 4)
                                        <span class="px-2 text-gray-500 text-sm">...</span>
                                    @endif
                                @endif

                                {{-- Array Of Links --}}
                                @foreach (range(max(1, $rooms->currentPage() - 2), min($rooms->lastPage(), $rooms->currentPage() + 2)) as $page)
                                    @if ($page == $rooms->currentPage())
                                        <span
                                            class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $rooms->url($page) }}"
                                            class="px-3 py-1 rounded-md hover:bg-indigo-50 text-indigo-600 text-sm">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- "Three Dots" Separator --}}
                                @if ($rooms->currentPage() < $rooms->lastPage() - 2)
                                    @if ($rooms->currentPage() < $rooms->lastPage() - 3)
                                        <span class="px-2 text-gray-500 text-sm">...</span>
                                    @endif
                                    <a href="{{ $rooms->url($rooms->lastPage()) }}"
                                        class="px-3 py-1 rounded-md hover:bg-indigo-50 text-indigo-600 text-sm">{{ $rooms->lastPage() }}</a>
                                @endif
                            </div>

                            <!-- Mobile Pagination Info -->
                            <span class="md:hidden text-gray-600 mx-2 text-sm">
                                {{ $rooms->currentPage() }} / {{ $rooms->lastPage() }}
                            </span>

                            <!-- Next Page Link -->
                            @if ($rooms->hasMorePages())
                                <a href="{{ $rooms->nextPageUrl() }}"
                                    class="px-3 py-1 text-indigo-600 hover:text-indigo-800 transition text-sm">
                                    Tiếp
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span class="px-3 py-1 text-gray-400 cursor-not-allowed text-sm">
                                    Tiếp
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Pagination Info -->
                    <div class="hidden lg:flex ml-4 text-sm text-gray-600 items-center">
                        Hiển thị {{ $rooms->firstItem() ?? 0 }}-{{ $rooms->lastItem() ?? 0 }} trên tổng số
                        {{ $rooms->total() }} phòng
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 md:p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 md:h-16 md:w-16 mx-auto text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-700 mt-4">Không tìm thấy phòng trọ nào</h3>
                    <p class="text-gray-500 mt-2">Vui lòng thử lại với các tiêu chí tìm kiếm khác</p>
                    <a href="{{ route('motel') }}"
                        class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Xem tất cả phòng trọ
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Add CSS for background pattern in the head section -->
    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Line clamp for text overflow */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Fix z-index issues with header */
        header,
        .navbar,
        nav {
            z-index: 100 !important;
            position: relative;
        }

        .main-content {
            z-index: 10;
            position: relative;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province_id');
            const districtSelect = document.getElementById('district_id');
            const toggleFilterBtn = document.getElementById('toggleFilterBtn');
            const filterForm = document.getElementById('filterForm');
            const filterBtnText = document.getElementById('filterBtnText');

            // Toggle filter visibility on mobile
            toggleFilterBtn.addEventListener('click', function() {
                if (filterForm.classList.contains('hidden')) {
                    filterForm.classList.remove('hidden');
                    filterForm.classList.add('block');
                    filterBtnText.textContent = 'Ẩn bộ lọc';
                } else {
                    filterForm.classList.add('hidden');
                    filterForm.classList.remove('block');
                    filterBtnText.textContent = 'Hiện bộ lọc';
                }
            });

            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;

                // Reset district dropdown
                districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';

                if (provinceId) {
                    // Enable district dropdown
                    districtSelect.disabled = false;
                    districtSelect.classList.remove('cursor-not-allowed', 'opacity-75');

                    // Hiển thị trạng thái loading
                    const loadingOption = document.createElement('option');
                    loadingOption.textContent = 'Đang tải danh sách quận/huyện...';
                    loadingOption.disabled = true;
                    districtSelect.appendChild(loadingOption);
                    districtSelect.value = loadingOption.value;

                    // Fetch districts for the selected province với timeout 3 giây
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 3000);

                    fetch(`/api/districts?province_id=${provinceId}`, {
                            signal: controller.signal
                        })
                        .then(response => {
                            clearTimeout(timeoutId);
                            if (!response.ok) {
                                throw new Error('Không thể tải dữ liệu quận/huyện');
                            }
                            return response.json();
                        })
                        .then(districts => {
                            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                            districts.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district.id;
                                option.textContent = district.name;
                                districtSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Lỗi khi tải danh sách quận/huyện:', error);
                            districtSelect.innerHTML =
                                '<option value="">Có lỗi xảy ra, vui lòng thử lại</option>';
                        });
                } else {
                    // Disable district dropdown if no province is selected
                    districtSelect.disabled = true;
                    districtSelect.classList.add('cursor-not-allowed', 'opacity-75');
                }
            });

            // Sorting functionality
            const sortSelect = document.getElementById('sortOptions');
            sortSelect.addEventListener('change', function() {
                // Add sorting functionality here
                // This would typically redirect to the same page with a sort parameter
                // or re-fetch the data with JavaScript
                console.log('Sort by:', this.value);
            });
        });
    </script>
</x-tenant-layout>
