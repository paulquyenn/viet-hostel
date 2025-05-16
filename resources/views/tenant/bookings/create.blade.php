<x-tenant-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Đặt phòng</h1>
                        <a href="{{ route('motel.detail', $room->id) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            Quay lại
                        </a>
                    </div>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Lỗi!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông tin phòng</h2>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Số phòng</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $room->room_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Khu trọ</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $room->building->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Địa chỉ</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $room->building->address }},
                                            {{ $room->building->ward->name }},
                                            {{ $room->building->district->name }},
                                            {{ $room->building->province->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Giá phòng</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ number_format($room->price) }}
                                            VND/tháng</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Đặt cọc</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ number_format($room->deposit) }} VND
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Diện tích</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $room->area }} m<sup>2</sup></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông tin đặt phòng</h2>
                                <form method="POST" action="{{ route('tenant.bookings.store', $room->id) }}">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label for="desired_move_date"
                                                class="block text-sm font-medium text-gray-700">Ngày dự kiến chuyển vào
                                                <span class="text-red-600">*</span></label>
                                            <input type="date" name="desired_move_date" id="desired_move_date"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                            @error('desired_move_date')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="duration" class="block text-sm font-medium text-gray-700">Thời
                                                hạn thuê (tháng) <span class="text-red-600">*</span></label>
                                            <input type="number" name="duration" id="duration"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                min="1" max="36" value="6" required>
                                            <p class="text-xs text-gray-500 mt-1">Thời hạn thuê từ 1-36 tháng</p>
                                            @error('duration')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="note" class="block text-sm font-medium text-gray-700">Ghi
                                                chú</label>
                                            <textarea name="note" id="note" rows="4"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                placeholder="Nhập các yêu cầu bổ sung hoặc thông tin khác (nếu có)"></textarea>
                                            @error('note')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="pt-4">
                                            <button type="submit"
                                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Đặt phòng
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quy trình đặt phòng</h2>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <ol class="relative border-l border-gray-200">
                                <li class="mb-6 ml-6">
                                    <span
                                        class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Đặt phòng</h3>
                                    <p class="text-sm text-gray-500">Điền thông tin và gửi yêu cầu đặt phòng</p>
                                </li>
                                <li class="mb-6 ml-6">
                                    <span
                                        class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Xác nhận</h3>
                                    <p class="text-sm text-gray-500">Chủ trọ xác nhận yêu cầu đặt phòng của bạn</p>
                                </li>
                                <li class="mb-6 ml-6">
                                    <span
                                        class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Ký hợp đồng</h3>
                                    <p class="text-sm text-gray-500">Xem xét và ký hợp đồng thuê phòng</p>
                                </li>
                                <li class="ml-6">
                                    <span
                                        class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Chuyển vào</h3>
                                    <p class="text-sm text-gray-500">Nhận phòng và chuyển vào ở</p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
