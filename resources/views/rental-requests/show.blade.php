<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết yêu cầu thuê phòng') }}
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
                        <h3 class="text-lg font-medium text-gray-900">Thông tin yêu cầu thuê</h3>
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Quay lại
                        </a>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-base font-semibold mb-2">Thông tin phòng</h4>
                                <p><span class="font-medium">Tòa nhà:</span> {{ $rentalRequest->room->building->name }}
                                </p>
                                <p><span class="font-medium">Phòng số:</span> {{ $rentalRequest->room->room_number }}
                                </p>
                                <p><span class="font-medium">Diện tích:</span> {{ $rentalRequest->room->area }}m²</p>
                                <p><span class="font-medium">Giá thuê:</span>
                                    {{ number_format($rentalRequest->room->price) }} VNĐ/tháng</p>
                                <p><span class="font-medium">Tiền cọc:</span>
                                    {{ number_format($rentalRequest->room->deposit) }} VNĐ</p>
                                <p><span class="font-medium">Địa chỉ:</span>
                                    {{ $rentalRequest->room->building->address }},
                                    {{ $rentalRequest->room->building->ward->name }},
                                    {{ $rentalRequest->room->building->district->name }},
                                    {{ $rentalRequest->room->building->province->name }}</p>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold mb-2">Thông tin người thuê</h4>
                                <p><span class="font-medium">Họ tên:</span> {{ $rentalRequest->user->name }}</p>
                                <p><span class="font-medium">Email:</span> {{ $rentalRequest->user->email }}</p>
                                @if ($rentalRequest->user->phone)
                                    <p><span class="font-medium">Số điện thoại:</span>
                                        {{ $rentalRequest->user->phone }}</p>
                                @endif
                                @if ($rentalRequest->user->address)
                                    <p><span class="font-medium">Địa chỉ hiện tại:</span>
                                        {{ $rentalRequest->user->address }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                        <h4 class="text-base font-semibold mb-2">Chi tiết yêu cầu</h4>
                        <p><span class="font-medium">Ngày muốn thuê:</span>
                            {{ $rentalRequest->requested_from_date->format('d/m/Y') }}</p>
                        @if ($rentalRequest->requested_to_date)
                            <p><span class="font-medium">Dự kiến kết thúc:</span>
                                {{ $rentalRequest->requested_to_date->format('d/m/Y') }}</p>
                        @endif
                        <p><span class="font-medium">Trạng thái:</span>
                            @if ($rentalRequest->status == 'pending')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Đang xử lý
                                </span>
                            @elseif($rentalRequest->status == 'approved')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Đã chấp nhận
                                </span>
                            @elseif($rentalRequest->status == 'rejected')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Từ chối
                                </span>
                            @elseif($rentalRequest->status == 'cancelled')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Đã hủy
                                </span>
                            @endif
                        </p>
                        <p><span class="font-medium">Ngày yêu cầu:</span>
                            {{ $rentalRequest->created_at->format('d/m/Y H:i') }}</p>

                        @if ($rentalRequest->message)
                            <div class="mt-3">
                                <h5 class="font-medium">Nội dung yêu cầu:</h5>
                                <div class="mt-1 p-2 bg-white rounded border">
                                    {{ $rentalRequest->message }}
                                </div>
                            </div>
                        @endif

                        @if ($rentalRequest->status === 'rejected' && $rentalRequest->rejection_reason)
                            <div class="mt-3">
                                <h5 class="font-medium text-red-600">Lý do từ chối:</h5>
                                <div class="mt-1 p-2 bg-white rounded border border-red-200">
                                    {{ $rentalRequest->rejection_reason }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mt-8">
                        @if (auth()->id() === $rentalRequest->user_id && $rentalRequest->status === 'pending')
                            <form action="{{ route('rental-requests.destroy', $rentalRequest->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Bạn có chắc muốn hủy yêu cầu thuê này?')">
                                    Hủy yêu cầu
                                </button>
                            </form>
                        @endif

                        @if ((auth()->user()->hasRole('landlord') || auth()->user()->hasRole('admin')) && $rentalRequest->status === 'pending')
                            <div class="flex space-x-3">
                                <form action="{{ route('rental-requests.update', $rentalRequest->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit"
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                        onclick="return confirm('Bạn có chắc muốn chấp nhận yêu cầu thuê này?')">
                                        Chấp nhận
                                    </button>
                                </form>
                                <button type="button" onclick="showRejectModal()"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Từ chối
                                </button>
                            </div>
                        @endif

                        @if (
                            (auth()->user()->hasRole('landlord') || auth()->user()->hasRole('admin')) &&
                                $rentalRequest->status === 'approved' &&
                                !$rentalRequest->contract)
                            <div>
                                <a href="{{ route('contracts.create', ['rental_request_id' => $rentalRequest->id]) }}"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Tạo hợp đồng
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal từ chối yêu cầu -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Từ chối yêu cầu thuê</h3>
                <div class="mt-2 px-7 py-3">
                    <form action="{{ route('rental-requests.update', $rentalRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">

                        <div class="mb-4">
                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 text-left">Lý
                                do từ chối</label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                required></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="closeRejectModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm mr-3">
                                Hủy
                            </button>
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                Từ chối
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
