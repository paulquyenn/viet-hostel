<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết hợp đồng') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Thông tin hợp đồng</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('contracts.index') }}"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Quay lại danh sách
                            </a>
                            @if ((auth()->id() === $contract->landlord_id || auth()->user()->hasRole('admin')) && !$contract->isFullySigned())
                                <a href="{{ route('contracts.edit', $contract->id) }}"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Chỉnh sửa
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-base font-semibold">Thông tin cơ bản</h4>
                            <div>
                                @if ($contract->status == 'active')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Đang hiệu lực
                                    </span>
                                @elseif($contract->status == 'pending')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Chờ ký
                                    </span>
                                @elseif($contract->status == 'expired')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Hết hạn
                                    </span>
                                @elseif($contract->status == 'terminated')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Đã chấm dứt
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p><span class="font-medium">Số hợp đồng:</span> {{ $contract->contract_number }}</p>
                                <p><span class="font-medium">Thời hạn:</span>
                                    {{ $contract->start_date->format('d/m/Y') }} -
                                    {{ $contract->end_date->format('d/m/Y') }}</p>
                                <p><span class="font-medium">Giá thuê hàng tháng:</span>
                                    {{ number_format($contract->monthly_rent) }} VNĐ</p>
                                <p><span class="font-medium">Tiền đặt cọc:</span>
                                    {{ number_format($contract->deposit) }} VNĐ</p>
                                <p><span class="font-medium">Ngày thanh toán hàng tháng:</span> Ngày
                                    {{ $contract->payment_day }} hàng tháng</p>
                            </div>
                            <div>
                                <p><span class="font-medium">Ngày tạo:</span>
                                    {{ $contract->created_at->format('d/m/Y H:i') }}</p>
                                <p><span class="font-medium">Trạng thái chữ ký:</span>
                                    @if ($contract->tenant_signed)
                                        <span class="text-green-600">Người thuê đã ký
                                            ({{ $contract->tenant_signed_at->format('d/m/Y') }})</span>
                                    @else
                                        <span class="text-red-600">Người thuê chưa ký</span>
                                    @endif
                                    |
                                    @if ($contract->landlord_signed)
                                        <span class="text-green-600">Chủ trọ đã ký
                                            ({{ $contract->landlord_signed_at->format('d/m/Y') }})</span>
                                    @else
                                        <span class="text-red-600">Chủ trọ chưa ký</span>
                                    @endif
                                </p>
                                @if ($contract->document_path)
                                    <p><span class="font-medium">Tài liệu hợp đồng:</span>
                                        <a href="{{ Storage::url($contract->document_path) }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900">Xem tài liệu</a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h4 class="text-base font-semibold mb-2">Thông tin phòng</h4>
                            <p><span class="font-medium">Tòa nhà:</span> {{ $contract->room->building->name }}</p>
                            <p><span class="font-medium">Phòng số:</span> {{ $contract->room->room_number }}</p>
                            <p><span class="font-medium">Diện tích:</span> {{ $contract->room->area }}m²</p>
                            <p><span class="font-medium">Địa chỉ:</span> {{ $contract->room->building->address }},
                                {{ $contract->room->building->ward->name }},
                                {{ $contract->room->building->district->name }},
                                {{ $contract->room->building->province->name }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h4 class="text-base font-semibold mb-2">Thông tin các bên</h4>
                            <div>
                                <h5 class="font-medium">Chủ trọ:</h5>
                                <p>{{ $contract->landlord->name }}</p>
                                <p>Email: {{ $contract->landlord->email }}</p>
                                @if ($contract->landlord->phone)
                                    <p>Số điện thoại: {{ $contract->landlord->phone }}</p>
                                @endif
                            </div>
                            <hr class="my-2">
                            <div>
                                <h5 class="font-medium">Người thuê:</h5>
                                <p>{{ $contract->tenant->name }}</p>
                                <p>Email: {{ $contract->tenant->email }}</p>
                                @if ($contract->tenant->phone)
                                    <p>Số điện thoại: {{ $contract->tenant->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <h4 class="text-base font-semibold mb-2">Điều khoản và điều kiện</h4>
                        <div class="bg-white p-3 rounded border whitespace-pre-line">
                            {{ $contract->terms_and_conditions }}
                        </div>
                    </div>

                    @if ($contract->status === 'terminated' && $contract->termination_reason)
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-6">
                            <h4 class="text-base font-semibold mb-2 text-red-600">Lý do chấm dứt hợp đồng</h4>
                            <div class="bg-white p-3 rounded border whitespace-pre-line">
                                {{ $contract->termination_reason }}
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mt-8">
                        @if (
                            $contract->isActive() &&
                                (auth()->id() === $contract->landlord_id ||
                                    auth()->id() === $contract->tenant_id ||
                                    auth()->user()->hasRole('admin')))
                            <button type="button" onclick="showTerminateModal()"
                                class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Chấm dứt hợp đồng
                            </button>
                        @endif

                        @if (auth()->id() === $contract->tenant_id && !$contract->tenant_signed)
                            <form action="{{ route('contracts.update', $contract->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="sign">
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    onclick="return confirm('Bạn có chắc muốn ký hợp đồng này?')">
                                    Ký hợp đồng (người thuê)
                                </button>
                            </form>
                        @endif

                        @if (auth()->id() === $contract->landlord_id && !$contract->landlord_signed)
                            <form action="{{ route('contracts.update', $contract->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="sign">
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    onclick="return confirm('Bạn có chắc muốn ký hợp đồng này?')">
                                    Ký hợp đồng (chủ trọ)
                                </button>
                            </form>
                        @endif

                        @if ((auth()->id() === $contract->landlord_id || auth()->user()->hasRole('admin')) && !$contract->isFullySigned())
                            <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                                class="ml-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Bạn có chắc muốn xóa hợp đồng này?')">
                                    Xóa hợp đồng
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chấm dứt hợp đồng -->
    <div id="terminateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Chấm dứt hợp đồng</h3>
                <div class="mt-2 px-7 py-3">
                    <form action="{{ route('contracts.terminate', $contract->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="termination_reason" class="block text-sm font-medium text-gray-700 text-left">Lý
                                do chấm dứt</label>
                            <textarea id="termination_reason" name="termination_reason" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                required></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="closeTerminateModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm mr-3">
                                Hủy
                            </button>
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                Chấm dứt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTerminateModal() {
            document.getElementById('terminateModal').classList.remove('hidden');
        }

        function closeTerminateModal() {
            document.getElementById('terminateModal').classList.add('hidden');
        }
    </script>

    <!-- Thêm phần thanh toán -->
    @if ($contract->status === 'active')
        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Thanh toán tiền thuê</h3>
                    @if (auth()->user()->hasRole(['admin', 'landlord']) && auth()->id() === $contract->landlord_id)
                        <form action="{{ route('contracts.generate-monthly-payment', $contract->id) }}"
                            method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tạo thanh toán mới
                            </button>
                        </form>
                    @endif
                </div>

                @if ($contract->payments->isEmpty())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                        role="alert">
                        <p>Chưa có khoản thanh toán nào cho hợp đồng này.</p>
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
                                @foreach ($contract->payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $payment->payment_number }}
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
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
</x-app-layout>
