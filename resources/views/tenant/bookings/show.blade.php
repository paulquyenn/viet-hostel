<x-tenant-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Chi tiết đặt phòng</h1>
                        <a href="{{ route('tenant.bookings.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            Quay lại
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Thành công!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

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
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông tin đặt phòng</h2>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Mã đặt phòng</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Ngày đặt</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Ngày dự kiến chuyển vào</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $booking->desired_move_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Thời hạn thuê</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->duration }} tháng</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Trạng thái</p>
                                        <p class="mt-1">
                                            @if ($booking->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $booking->status_text }}
                                                </span>
                                            @elseif($booking->status == 'approved')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $booking->status_text }}
                                                </span>
                                            @elseif($booking->status == 'rejected')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $booking->status_text }}
                                                </span>
                                            @elseif($booking->status == 'cancelled')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $booking->status_text }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông tin phòng</h2>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Số phòng</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->room->room_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Khu trọ</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->room->building->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Địa chỉ</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $booking->room->building->address }},
                                            {{ $booking->room->building->ward->name }},
                                            {{ $booking->room->building->district->name }},
                                            {{ $booking->room->building->province->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Giá phòng</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ number_format($booking->room->price) }} VND/tháng</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Diện tích</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->room->area }} m<sup>2</sup>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($booking->note)
                            <div class="mt-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-2">Ghi chú</h2>
                                <div class="bg-white p-4 rounded-md border border-gray-200">
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $booking->note }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Hiển thị thông tin hợp đồng nếu có -->
                    @if ($booking->contract)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Thông tin hợp đồng
                                </h3>
                            </div>
                            <div class="border-t border-gray-200">
                                <dl>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Mã hợp đồng</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $booking->contract->contract_number }}</dd>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Trạng thái hợp đồng</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if ($booking->contract->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $booking->contract->status_text }}
                                                </span>
                                            @elseif($booking->contract->status == 'active')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $booking->contract->status_text }}
                                                </span>
                                            @elseif($booking->contract->status == 'expired')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $booking->contract->status_text }}
                                                </span>
                                            @elseif($booking->contract->status == 'terminated')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $booking->contract->status_text }}
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Thời hạn hợp đồng</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $booking->contract->start_date->format('d/m/Y') }} -
                                            {{ $booking->contract->end_date->format('d/m/Y') }}
                                            ({{ $booking->contract->duration_in_months }} tháng)
                                        </dd>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Giá thuê hàng tháng</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ number_format($booking->contract->monthly_rent) }} VND</dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Tiền đặt cọc</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ number_format($booking->contract->deposit_amount) }} VND</dd>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Hành động</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <a href="{{ route('tenant.contracts.show', $booking->contract->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Xem chi tiết hợp đồng
                                            </a>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('tenant.bookings.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Quay lại
                        </a>

                        @if ($booking->status == 'pending')
                            <form method="POST" action="{{ route('tenant.bookings.cancel', $booking->id) }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt phòng này?')">
                                    Hủy đặt phòng
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
