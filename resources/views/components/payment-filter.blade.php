<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form action="{{ route('payments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
            <select id="status" name="status"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Tất cả</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
            </select>
        </div>

        <div>
            <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Khoảng thời gian</label>
            <select id="date_range" name="date_range"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Tất cả</option>
                <option value="current_month" {{ request('date_range') === 'current_month' ? 'selected' : '' }}>Tháng
                    hiện tại</option>
                <option value="overdue" {{ request('date_range') === 'overdue' ? 'selected' : '' }}>Quá hạn</option>
                <option value="upcoming" {{ request('date_range') === 'upcoming' ? 'selected' : '' }}>Sắp đến hạn (30
                    ngày)</option>
            </select>
        </div>

        <div>
            <label for="contract_id" class="block text-sm font-medium text-gray-700 mb-1">Hợp đồng</label>
            <select id="contract_id" name="contract_id"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Tất cả</option>
                @foreach ($contracts ?? [] as $contract)
                    <option value="{{ $contract->id }}" {{ request('contract_id') == $contract->id ? 'selected' : '' }}>
                        {{ $contract->contract_number }} - {{ $contract->room->room_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end items-end space-x-2">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Lọc
            </button>
            <a href="{{ route('payments.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                Đặt lại
            </a>
        </div>
    </form>
</div>
