<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý thanh toán') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Danh sách thanh toán</h3>
                        @if (auth()->user()->hasRole(['admin', 'landlord']))
                            <a href="{{ route('contracts.index') }}"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Chọn hợp đồng để tạo thanh toán
                            </a>
                        @endif
                    </div>

                    <!-- Thống kê -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="text-sm font-medium text-blue-800 mb-1">Tổng giá trị</h4>
                            <p class="text-xl font-bold text-blue-900">{{ number_format($stats['total']) }} VND</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="text-sm font-medium text-green-800 mb-1">Đã thanh toán</h4>
                            <p class="text-xl font-bold text-green-900">{{ number_format($stats['paid']) }} VND</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h4 class="text-sm font-medium text-yellow-800 mb-1">Chờ thanh toán</h4>
                            <p class="text-xl font-bold text-yellow-900">{{ number_format($stats['pending']) }} VND</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="text-sm font-medium text-red-800 mb-1">Quá hạn</h4>
                            <p class="text-xl font-bold text-red-900">{{ number_format($stats['overdue']) }} VND</p>
                        </div>
                    </div>

                    <x-payment-filter />

                    @if ($payments->isEmpty())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                            role="alert">
                            <p>Không có khoản thanh toán nào.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mã thanh toán
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Hợp đồng/Phòng
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            @if (auth()->user()->hasRole(['admin', 'landlord']))
                                                Người thuê
                                            @else
                                                Chủ trọ
                                            @endif
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kỳ thanh toán
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Số tiền
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ngày thanh toán
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Trạng thái
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $payment->payment_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div>
                                                    <span class="font-medium">Hợp đồng:</span>
                                                    {{ $payment->contract->contract_number }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">Phòng:</span>
                                                    {{ $payment->contract->room->room_number }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if (auth()->user()->hasRole(['admin', 'landlord']))
                                                    {{ $payment->contract->tenant->name }}
                                                @else
                                                    {{ $payment->contract->landlord->name }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $payment->payment_period_start->format('d/m/Y') }} -
                                                {{ $payment->payment_period_end->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($payment->amount) }} VND
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $payment->payment_date->format('d/m/Y') }}
                                                @if ($payment->payment_status === 'pending' && $payment->payment_date->isPast())
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                        Quá hạn
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
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
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('payments.show', $payment->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    Chi tiết
                                                </a>

                                                @if ($payment->payment_status === 'pending')
                                                    @if (auth()->user()->hasRole(['admin', 'landlord']) && $payment->contract->landlord_id === auth()->id())
                                                        <a href="{{ route('payments.edit', $payment->id) }}"
                                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                                            Sửa
                                                        </a>
                                                    @endif

                                                    <a href="#" class="text-green-600 hover:text-green-900"
                                                        onclick="event.preventDefault(); document.getElementById('mark-paid-modal-{{ $payment->id }}').classList.remove('hidden');">
                                                        Đánh dấu đã thanh toán
                                                    </a>

                                                    <!-- Modal đánh dấu đã thanh toán -->
                                                    <div id="mark-paid-modal-{{ $payment->id }}"
                                                        class="hidden fixed z-10 inset-0 overflow-y-auto"
                                                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                        <div
                                                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                                                aria-hidden="true"></div>

                                                            <span
                                                                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                aria-hidden="true">&#8203;</span>

                                                            <div
                                                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                <form
                                                                    action="{{ route('payments.mark-as-paid', $payment->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                        <div class="sm:flex sm:items-start">
                                                                            <div
                                                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                                <svg class="h-6 w-6 text-green-600"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke="currentColor"
                                                                                    aria-hidden="true">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M5 13l4 4L19 7" />
                                                                                </svg>
                                                                            </div>
                                                                            <div
                                                                                class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                                                    id="modal-title">
                                                                                    Xác nhận thanh toán
                                                                                </h3>
                                                                                <div class="mt-2">
                                                                                    <p class="text-sm text-gray-500">
                                                                                        Bạn xác nhận đã thanh toán khoản
                                                                                        tiền
                                                                                        {{ number_format($payment->amount) }}
                                                                                        VND cho thời gian từ
                                                                                        {{ $payment->payment_period_start->format('d/m/Y') }}
                                                                                        đến
                                                                                        {{ $payment->payment_period_end->format('d/m/Y') }}?
                                                                                    </p>

                                                                                    <div class="mt-4">
                                                                                        <label
                                                                                            for="payment_method_{{ $payment->id }}"
                                                                                            class="block text-sm font-medium text-gray-700">Phương
                                                                                            thức thanh toán <span
                                                                                                class="text-red-500">*</span></label>
                                                                                        <select
                                                                                            id="payment_method_{{ $payment->id }}"
                                                                                            name="payment_method"
                                                                                            required
                                                                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                                            <option value="cash">Tiền
                                                                                                mặt</option>
                                                                                            <option
                                                                                                value="bank_transfer">
                                                                                                Chuyển khoản</option>
                                                                                            <option value="other">
                                                                                                Phương thức khác
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="mt-4">
                                                                                        <label
                                                                                            for="notes_{{ $payment->id }}"
                                                                                            class="block text-sm font-medium text-gray-700">Ghi
                                                                                            chú</label>
                                                                                        <textarea id="notes_{{ $payment->id }}" name="notes" rows="3"
                                                                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                        <button type="submit"
                                                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Xác nhận thanh toán
                                                                        </button>
                                                                        <button type="button"
                                                                            onclick="document.getElementById('mark-paid-modal-{{ $payment->id }}').classList.add('hidden');"
                                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Hủy
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
