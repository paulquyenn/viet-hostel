<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hợp đồng thuê phòng') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Danh sách hợp đồng</h3>
                        @if (auth()->user()->hasRole(['admin', 'landlord']))
                            <a href="{{ route('contracts.create') }}"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tạo hợp đồng mới
                            </a>
                        @endif
                    </div>

                    <x-contract-filter />

                    @if ($contracts->isEmpty())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                            role="alert">
                            <p>Không có hợp đồng nào.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Số hợp đồng
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Phòng
                                        </th>
                                        @if (auth()->user()->hasRole(['admin', 'landlord']))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Người thuê
                                            </th>
                                        @endif
                                        @if (auth()->user()->hasRole(['admin', 'tenant']))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Chủ trọ
                                            </th>
                                        @endif
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Thời hạn
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Trạng thái
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($contracts as $contract)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $contract->contract_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $contract->room->building->name }} - Phòng
                                                    {{ $contract->room->room_number }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ number_format($contract->monthly_rent) }} VNĐ/tháng
                                                </div>
                                            </td>
                                            @if (auth()->user()->hasRole(['admin', 'landlord']))
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $contract->tenant->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $contract->tenant->email }}
                                                    </div>
                                                </td>
                                            @endif
                                            @if (auth()->user()->hasRole(['admin', 'tenant']))
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $contract->landlord->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $contract->landlord->email }}
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $contract->start_date->format('d/m/Y') }} -
                                                    {{ $contract->end_date->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($contract->status == 'active')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Đang hiệu lực
                                                    </span>
                                                @elseif($contract->status == 'pending')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Chờ ký
                                                    </span>
                                                @elseif($contract->status == 'expired')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Hết hạn
                                                    </span>
                                                @elseif($contract->status == 'terminated')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Đã chấm dứt
                                                    </span>
                                                @endif
                                                <div class="text-xs text-gray-500 mt-1">
                                                    @if ($contract->tenant_signed)
                                                        <span class="text-green-600">Người thuê đã ký</span>
                                                    @else
                                                        <span class="text-red-600">Người thuê chưa ký</span>
                                                    @endif
                                                    |
                                                    @if ($contract->landlord_signed)
                                                        <span class="text-green-600">Chủ trọ đã ký</span>
                                                    @else
                                                        <span class="text-red-600">Chủ trọ chưa ký</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('contracts.show', $contract->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Chi tiết</a>

                                                @if (!$contract->isFullySigned())
                                                    @if (auth()->id() === $contract->tenant_id && !$contract->tenant_signed)
                                                        <form action="{{ route('contracts.update', $contract->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="action" value="sign">
                                                            <button type="submit"
                                                                class="text-green-600 hover:text-green-900"
                                                                onclick="return confirm('Bạn có chắc muốn ký hợp đồng này?')">Ký
                                                                hợp đồng</button>
                                                        </form>
                                                    @endif

                                                    @if (auth()->id() === $contract->landlord_id && !$contract->landlord_signed)
                                                        <form action="{{ route('contracts.update', $contract->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="action" value="sign">
                                                            <button type="submit"
                                                                class="text-green-600 hover:text-green-900"
                                                                onclick="return confirm('Bạn có chắc muốn ký hợp đồng này?')">Ký
                                                                hợp đồng</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $contracts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
