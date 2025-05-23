<x-tenant-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Chi tiết hợp đồng</h1>
                        <a href="{{ route('tenant.contracts.index') }}"
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

                    <!-- Header with contract number and status -->
                    <div
                        class="bg-gray-50 rounded-t-xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-200">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Hợp đồng số: {{ $contract->contract_number }}
                            </h2>
                            <p class="text-gray-600 mt-1">Ngày tạo: {{ $contract->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="inline-flex items-center">
                                <span class="text-sm mr-2">Trạng thái:</span>
                                @if ($contract->status == 'pending')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        {{ $contract->status_text }}
                                    </span>
                                @elseif($contract->status == 'tenant_approved')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $contract->status_text }}
                                    </span>
                                @elseif($contract->status == 'active')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        {{ $contract->status_text }}
                                    </span>
                                @elseif($contract->status == 'expired')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        {{ $contract->status_text }}
                                    </span>
                                @elseif($contract->status == 'terminated')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        {{ $contract->status_text }}
                                    </span>
                                @endif
                            </div>
                            @if ($contract->isSigned())
                                <div class="mt-2 text-sm text-gray-600">Đã ký ngày:
                                    {{ $contract->signed_at->format('d/m/Y H:i') }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Contract Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Thông
                                    tin phòng</h3>
                                <dl class="grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Số phòng</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $contract->room->room_number }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Diện tích</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $contract->room->area }}
                                            m<sup>2</sup></dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Khu trọ</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $contract->room->building->name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Địa chỉ</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $contract->room->building->address }},
                                            {{ $contract->room->building->ward->name }},
                                            {{ $contract->room->building->district->name }},
                                            {{ $contract->room->building->province->name }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Thông
                                    tin hợp đồng</h3>
                                <dl class="grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Giá thuê</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                                            {{ number_format($contract->monthly_rent) }} VND/tháng</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Tiền đặt cọc</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                                            {{ number_format($contract->deposit_amount) }} VND</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Thời hạn hợp đồng</dt>
                                        <dd class="mt-1 text-sm text-gray-900">Từ
                                            {{ $contract->start_date->format('d/m/Y') }} đến
                                            {{ $contract->end_date->format('d/m/Y') }}
                                            ({{ $contract->duration_in_months }} tháng)</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Chủ trọ</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $contract->landlord->name }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Liên hệ</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $contract->landlord->phone ?? 'Không có' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Điều
                                khoản và điều kiện</h3>
                            <div class="prose prose-sm max-w-none text-gray-700">
                                <div class="bg-white p-4 rounded-md border border-gray-200">
                                    <p class="whitespace-pre-line">{{ $contract->terms_and_conditions }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-8">
                            <div>
                                @if ($contract->file_path)
                                    <a href="{{ route('tenant.contracts.download', $contract->id) }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Tải xuống hợp đồng
                                    </a>
                                @endif
                            </div>
                            <div>
                                @if ($contract->status == 'pending' && !$contract->isSigned())
                                    <button id="openSignModal"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Xác nhận hợp đồng
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="signatureModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Xác nhận hợp đồng</h3>
                    <button id="closeSignModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="mb-4 text-sm text-gray-600">
                    Bằng việc xác nhận, bạn đồng ý với tất cả điều khoản và điều kiện của hợp đồng thuê phòng này.
                </p>

                <form id="contract-sign-form" method="POST"
                    action="{{ route('tenant.contracts.sign', $contract->id) }}">
                    @csrf
                    <div class="flex justify-end">
                        <button id="cancelSignModal" type="button"
                            class="mr-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Hủy
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Xác nhận hợp đồng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('signatureModal');
            const openBtn = document.getElementById('openSignModal');
            const closeBtn = document.getElementById('closeSignModal');
            const cancelBtn = document.getElementById('cancelSignModal');

            if (openBtn) {
                openBtn.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }
        });
    </script>
</x-tenant-layout>
