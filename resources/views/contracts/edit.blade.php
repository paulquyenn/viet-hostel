<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa hợp đồng') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Chỉnh sửa hợp đồng</h3>
                        <a href="{{ route('contracts.show', $contract->id) }}"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Quay lại
                        </a>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <h4 class="text-base font-semibold mb-4">Thông tin hợp đồng</h4>
                        <form action="{{ route('contracts.update', $contract->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="edit">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="bg-white p-4 rounded border mb-4">
                                        <p><span class="font-medium">Số hợp đồng:</span>
                                            {{ $contract->contract_number }}</p>
                                        <p><span class="font-medium">Phòng:</span> {{ $contract->room->building->name }}
                                            - Phòng {{ $contract->room->room_number }}</p>
                                        <p><span class="font-medium">Chủ trọ:</span> {{ $contract->landlord->name }}</p>
                                        <p><span class="font-medium">Người thuê:</span> {{ $contract->tenant->name }}
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt
                                            đầu <span class="text-red-500">*</span></label>
                                        <input type="date" name="start_date" id="start_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="{{ $contract->start_date->format('Y-m-d') }}">
                                        @error('start_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết
                                            thúc <span class="text-red-500">*</span></label>
                                        <input type="date" name="end_date" id="end_date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="{{ $contract->end_date->format('Y-m-d') }}">
                                        @error('end_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-4">
                                        <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Giá
                                            thuê hàng tháng (VNĐ) <span class="text-red-500">*</span></label>
                                        <input type="number" name="monthly_rent" id="monthly_rent"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="{{ $contract->monthly_rent }}">
                                        @error('monthly_rent')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="deposit" class="block text-sm font-medium text-gray-700">Tiền đặt
                                            cọc (VNĐ) <span class="text-red-500">*</span></label>
                                        <input type="number" name="deposit" id="deposit"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                            required value="{{ $contract->deposit }}">
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
                                            required value="{{ $contract->payment_day }}">
                                        @error('payment_day')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="document" class="block text-sm font-medium text-gray-700">Tài liệu
                                            hợp đồng mới (nếu có)</label>
                                        <input type="file" name="document" id="document" class="mt-1 block w-full"
                                            accept=".pdf,.doc,.docx">
                                        @if ($contract->document_path)
                                            <p class="text-xs text-gray-500 mt-1">
                                                Tài liệu hiện tại: <a
                                                    href="{{ Storage::url($contract->document_path) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-900">Xem tài liệu</a>
                                            </p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">Chỉ tải lên nếu muốn thay đổi tài liệu
                                            hiện tại</p>
                                        @error('document')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="terms_and_conditions"
                                            class="block text-sm font-medium text-gray-700">Điều khoản và điều
                                            kiện</label>
                                        <textarea name="terms_and_conditions" id="terms_and_conditions" rows="5"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">{{ $contract->terms_and_conditions }}</textarea>
                                        @error('terms_and_conditions')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Cập nhật hợp đồng
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
