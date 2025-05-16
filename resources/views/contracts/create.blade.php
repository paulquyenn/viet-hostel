<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo hợp đồng thuê phòng') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Tạo hợp đồng mới</h3>
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Quay lại
                        </a>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <h4 class="text-base font-semibold mb-4">Thông tin hợp đồng</h4>
                        <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
                            <input type="hidden" name="landlord_id" value="{{ $landlord->id }}">
                            @if (isset($rentalRequest))
                                <input type="hidden" name="rental_request_id" value="{{ $rentalRequest->id }}">
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h5 class="font-medium mb-3">Thông tin phòng</h5>
                                    <div class="bg-white p-4 rounded border mb-4">
                                        <p><span class="font-medium">Tòa nhà:</span> {{ $room->building->name }}</p>
                                        <p><span class="font-medium">Phòng số:</span> {{ $room->room_number }}</p>
                                        <p><span class="font-medium">Diện tích:</span> {{ $room->area }}m²</p>
                                        <p><span class="font-medium">Địa chỉ:</span> {{ $room->building->address }},
                                            {{ $room->building->ward->name }}, {{ $room->building->district->name }},
                                            {{ $room->building->province->name }}</p>
                                    </div>

                                    <h5 class="font-medium mb-3">Thông tin các bên</h5>
                                    <div class="bg-white p-4 rounded border mb-4">
                                        <p><span class="font-medium">Chủ trọ:</span> {{ $landlord->name }}</p>
                                        <p><span class="font-medium">Email:</span> {{ $landlord->email }}</p>
                                        @if ($landlord->phone)
                                            <p><span class="font-medium">Số điện thoại:</span> {{ $landlord->phone }}
                                            </p>
                                        @endif
                                        <hr class="my-2">
                                        <p><span class="font-medium">Người thuê:</span> {{ $tenant->name }}</p>
                                        <p><span class="font-medium">Email:</span> {{ $tenant->email }}</p>
                                        @if ($tenant->phone)
                                            <p><span class="font-medium">Số điện thoại:</span> {{ $tenant->phone }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-4">
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt
                                            đầu <span class="text-red-500">*</span></label>
                                        <input type="date" name="start_date" id="start_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required
                                            value="{{ isset($rentalRequest) ? $rentalRequest->requested_from_date->format('Y-m-d') : date('Y-m-d') }}"
                                            min="{{ date('Y-m-d') }}">
                                        @error('start_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết
                                            thúc <span class="text-red-500">*</span></label>
                                        <input type="date" name="end_date" id="end_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required
                                            value="{{ isset($rentalRequest) && $rentalRequest->requested_to_date ? $rentalRequest->requested_to_date->format('Y-m-d') : date('Y-m-d', strtotime('+6 months')) }}"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        @error('end_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Giá
                                            thuê hàng tháng (VNĐ) <span class="text-red-500">*</span></label>
                                        <input type="number" name="monthly_rent" id="monthly_rent"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="{{ $room->price }}">
                                        @error('monthly_rent')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="deposit" class="block text-sm font-medium text-gray-700">Tiền đặt
                                            cọc (VNĐ) <span class="text-red-500">*</span></label>
                                        <input type="number" name="deposit" id="deposit"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="{{ $room->deposit }}">
                                        @error('deposit')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="payment_day" class="block text-sm font-medium text-gray-700">Ngày
                                            thanh toán hàng tháng <span class="text-red-500">*</span></label>
                                        <input type="number" name="payment_day" id="payment_day" min="1"
                                            max="31"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="1">
                                        <p class="text-xs text-gray-500 mt-1">Ngày trong tháng mà người thuê cần trả
                                            tiền thuê (1-31)</p>
                                        @error('payment_day')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="document" class="block text-sm font-medium text-gray-700">Tài liệu
                                            hợp đồng (nếu có)</label>
                                        <input type="file" name="document" id="document"
                                            class="mt-1 block w-full" accept=".pdf,.doc,.docx">
                                        <p class="text-xs text-gray-500 mt-1">Tải lên file hợp đồng đã soạn sẵn (nếu
                                            có). Chấp nhận file PDF, DOC, DOCX, tối đa 10MB</p>
                                        @error('document')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="terms_and_conditions"
                                            class="block text-sm font-medium text-gray-700">Điều khoản và điều
                                            kiện</label>
                                        <textarea name="terms_and_conditions" id="terms_and_conditions" rows="5"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">1. Người thuê đồng ý giữ phòng trong tình trạng sạch sẽ và ngăn nắp.
2. Người thuê không được tự ý sửa chữa, cải tạo phòng khi chưa có sự đồng ý của chủ trọ.
3. Tiền điện, nước và các dịch vụ khác (nếu có) sẽ được tính riêng và thanh toán vào cuối tháng.
4. Nếu muốn chấm dứt hợp đồng trước thời hạn, bên muốn chấm dứt phải thông báo trước ít nhất 30 ngày.
5. Tiền đặt cọc sẽ được hoàn trả sau khi kết thúc hợp đồng và kiểm tra tình trạng phòng, trừ đi các khoản phí phát sinh (nếu có).</textarea>
                                        @error('terms_and_conditions')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Tạo hợp đồng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            startDateInput.addEventListener('change', function() {
                if (endDateInput.value && new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                    endDateInput.value = '';
                }
                endDateInput.min = new Date(new Date(startDateInput.value).getTime() + 86400000)
                    .toISOString().split('T')[0];
            });
        });
    </script>
</x-app-layout>
