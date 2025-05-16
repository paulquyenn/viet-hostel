<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form action="{{ route('contracts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
            <select id="status" name="status"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Tất cả</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ ký</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Hết hạn</option>
                <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Đã chấm dứt
                </option>
            </select>
        </div>

        <div>
            <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Khoảng thời gian</label>
            <select id="date_range" name="date_range"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Tất cả</option>
                <option value="active" {{ request('date_range') === 'active' ? 'selected' : '' }}>Đang hiệu lực</option>
                <option value="expired" {{ request('date_range') === 'expired' ? 'selected' : '' }}>Đã hết hạn</option>
                <option value="expiring_soon" {{ request('date_range') === 'expiring_soon' ? 'selected' : '' }}>Sắp hết
                    hạn (30 ngày)</option>
                <option value="created_this_month"
                    {{ request('date_range') === 'created_this_month' ? 'selected' : '' }}>Tạo trong tháng này</option>
            </select>
        </div>

        @if (auth()->user()->hasRole(['admin', 'landlord']))
            <div>
                <label for="tenant" class="block text-sm font-medium text-gray-700 mb-1">Người thuê</label>
                <input type="text" id="tenant" name="tenant" value="{{ request('tenant') }}"
                    placeholder="Tên người thuê"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
        @endif

        @if (auth()->user()->hasRole('admin'))
            <div>
                <label for="landlord" class="block text-sm font-medium text-gray-700 mb-1">Chủ trọ</label>
                <input type="text" id="landlord" name="landlord" value="{{ request('landlord') }}"
                    placeholder="Tên chủ trọ"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
        @endif

        <div
            class="{{ auth()->user()->hasRole('admin') ? 'md:col-span-4' : (auth()->user()->hasRole('landlord') ? 'md:col-span-3' : 'md:col-span-2') }} flex justify-end items-end space-x-2">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Lọc
            </button>
            <a href="{{ route('contracts.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                Đặt lại
            </a>
        </div>
    </form>
</div>
