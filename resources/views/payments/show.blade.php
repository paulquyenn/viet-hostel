<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết thanh toán') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Thông tin thanh toán</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('payments.index') }}"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Quay lại
                            </a>

                            @if ($payment->payment_status === 'pending')
                                @if (auth()->user()->hasRole(['admin', 'landlord']) && $payment->contract->landlord_id === auth()->id())
                                    <a href="{{ route('payments.edit', $payment->id) }}"
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Chỉnh sửa
                                    </a>
                                @endif

                                <button onclick="document.getElementById('mark-paid-modal').classList.remove('hidden');"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Đánh dấu đã thanh toán
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Thông tin chung -->
                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <h4 class="text-base font-semibold mb-4">Thông tin thanh toán</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="mb-2"><span class="font-medium">Mã thanh toán:</span>
                                    {{ $payment->payment_number }}</p>
                                <p class="mb-2"><span class="font-medium">Số tiền:</span>
                                    {{ number_format($payment->amount) }} VND</p>
                                <p class="mb-2"><span class="font-medium">Kỳ thanh toán:</span>
                                    {{ $payment->payment_period_start->format('d/m/Y') }} -
                                    {{ $payment->payment_period_end->format('d/m/Y') }}</p>
                                <p class="mb-2"><span class="font-medium">Ngày đến hạn:</span>
                                    {{ $payment->payment_date->format('d/m/Y') }}</p>
                                <p class="mb-2"><span class="font-medium">Trạng thái:</span>
                                    @if ($payment->payment_status === 'paid')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Đã thanh toán
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Chờ thanh toán
                                        </span>
                                    @endif
                                </p>
                                @if ($payment->payment_status === 'paid')
                                    <p class="mb-2"><span class="font-medium">Ngày thanh toán:</span>
                                        {{ $payment->paid_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-2"><span class="font-medium">Phương thức:</span>
                                        @if ($payment->payment_method === 'cash')
                                            Tiền mặt
                                        @elseif($payment->payment_method === 'bank_transfer')
                                            Chuyển khoản
                                        @else
                                            {{ $payment->payment_method }}
                                        @endif
                                    </p>
                                    <p class="mb-2"><span class="font-medium">Người thanh toán:</span>
                                        {{ $payment->payer->name }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="mb-2"><span class="font-medium">Số hợp đồng:</span>
                                    {{ $payment->contract->contract_number }}</p>
                                <p class="mb-2"><span class="font-medium">Phòng:</span>
                                    {{ $payment->contract->room->room_number }}</p>
                                <p class="mb-2"><span class="font-medium">Địa chỉ:</span>
                                    {{ $payment->contract->room->building->address }}</p>
                                <p class="mb-2"><span class="font-medium">Người thuê:</span>
                                    {{ $payment->contract->tenant->name }}</p>
                                <p class="mb-2"><span class="font-medium">Chủ trọ:</span>
                                    {{ $payment->contract->landlord->name }}</p>
                                <p class="mb-2"><span class="font-medium">Người tạo:</span>
                                    {{ $payment->creator->name }}</p>
                                <p class="mb-2"><span class="font-medium">Ngày tạo:</span>
                                    {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($payment->notes)
                            <div class="mt-4">
                                <h5 class="text-sm font-medium mb-2">Ghi chú:</h5>
                                <div class="bg-white p-3 rounded border whitespace-pre-line">{{ $payment->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal đánh dấu đã thanh toán -->
    <div id="mark-paid-modal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('payments.mark-as-paid', $payment->id) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Xác nhận thanh toán
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Bạn xác nhận đã thanh toán khoản tiền {{ number_format($payment->amount) }} VND
                                        cho thời gian từ
                                        {{ $payment->payment_period_start->format('d/m/Y') }} đến
                                        {{ $payment->payment_period_end->format('d/m/Y') }}?
                                    </p>

                                    <div class="mt-4">
                                        <label for="payment_method"
                                            class="block text-sm font-medium text-gray-700">Phương thức thanh toán <span
                                                class="text-red-500">*</span></label>
                                        <select id="payment_method" name="payment_method" required
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="cash">Tiền mặt</option>
                                            <option value="bank_transfer">Chuyển khoản</option>
                                            <option value="other">Phương thức khác</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Ghi
                                            chú</label>
                                        <textarea id="notes" name="notes" rows="3"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Xác nhận thanh toán
                        </button>
                        <button type="button"
                            onclick="document.getElementById('mark-paid-modal').classList.add('hidden');"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
