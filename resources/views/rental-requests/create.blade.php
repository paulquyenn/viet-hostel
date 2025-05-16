<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đăng ký thuê phòng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Tạo yêu cầu thuê phòng</h3>
                        <a href="{{ route('motel.detail', $room->id) }}"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Quay lại
                        </a>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-base font-semibold mb-2">Thông tin phòng</h4>
                                <p><span class="font-medium">Tòa nhà:</span> {{ $room->building->name }}</p>
                                <p><span class="font-medium">Phòng số:</span> {{ $room->room_number }}</p>
                                <p><span class="font-medium">Diện tích:</span> {{ $room->area }}m²</p>
                                <p><span class="font-medium">Giá thuê:</span> {{ number_format($room->price) }}
                                    VNĐ/tháng</p>
                                <p><span class="font-medium">Tiền cọc:</span> {{ number_format($room->deposit) }} VNĐ
                                </p>
                                <p><span class="font-medium">Địa chỉ:</span> {{ $room->building->address }},
                                    {{ $room->building->ward->name }}, {{ $room->building->district->name }},
                                    {{ $room->building->province->name }}</p>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold mb-2">Thông tin yêu cầu</h4>
                                <form action="{{ route('rental-requests.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                                    <div class="mb-4">
                                        <label for="requested_from_date"
                                            class="block text-sm font-medium text-gray-700">Ngày muốn thuê <span
                                                class="text-red-500">*</span></label>
                                        <input type="date" name="requested_from_date" id="requested_from_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required min="{{ date('Y-m-d') }}">
                                        @error('requested_from_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="requested_to_date"
                                            class="block text-sm font-medium text-gray-700">Dự kiến kết thúc</label>
                                        <input type="date" name="requested_to_date" id="requested_to_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        <p class="text-xs text-gray-500 mt-1">Không bắt buộc, để trống nếu chưa xác định
                                            thời gian kết thúc</p>
                                        @error('requested_to_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="message" class="block text-sm font-medium text-gray-700">Nội dung
                                            yêu cầu</label>
                                        <textarea name="message" id="message" rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            placeholder="Nhập thông tin bổ sung hoặc yêu cầu cụ thể của bạn..."></textarea>
                                        @error('message')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Gửi yêu cầu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fromDateInput = document.getElementById('requested_from_date');
            const toDateInput = document.getElementById('requested_to_date');

            fromDateInput.addEventListener('change', function() {
                if (toDateInput.value && new Date(toDateInput.value) <= new Date(fromDateInput.value)) {
                    toDateInput.value = '';
                }
                toDateInput.min = new Date(new Date(fromDateInput.value).getTime() + 86400000).toISOString()
                    .split('T')[0];
            });
        });
    </script>
</x-app-layout>
