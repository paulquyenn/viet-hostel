<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý hệ thống') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quản lý hợp đồng</h3>

                    <div id="update-status-card" class="bg-white border rounded-lg shadow-sm p-6 mb-6">
                        <h4 class="text-base font-medium mb-4">Cập nhật trạng thái hợp đồng</h4>
                        <p class="mb-4">Công cụ này sẽ kiểm tra và cập nhật trạng thái của các hợp đồng đã hết hạn.
                        </p>

                        <div id="update-status-result" class="mb-4 hidden">
                            <div id="success-message"
                                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative hidden">
                                <span id="success-message-text"></span>
                            </div>
                            <div id="error-message"
                                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative hidden">
                                <span id="error-message-text"></span>
                            </div>
                        </div>

                        <button id="update-contracts-button"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cập nhật trạng thái hợp đồng
                        </button>
                    </div>

                    <div class="bg-white border rounded-lg shadow-sm p-6">
                        <h4 class="text-base font-medium mb-4">Thống kê hợp đồng</h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <div class="text-sm font-medium text-gray-500">Hợp đồng đang hoạt động</div>
                                <div class="mt-1 text-2xl font-bold text-indigo-600">{{ $activeContractsCount }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <div class="text-sm font-medium text-gray-500">Hợp đồng hết hạn</div>
                                <div class="mt-1 text-2xl font-bold text-gray-600">{{ $expiredContractsCount }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <div class="text-sm font-medium text-gray-500">Hợp đồng đã chấm dứt</div>
                                <div class="mt-1 text-2xl font-bold text-red-600">{{ $terminatedContractsCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('update-contracts-button').addEventListener('click', function() {
            // Hiển thị trạng thái đang tải
            this.disabled = true;
            this.innerHTML =
                '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Đang xử lý...';

            // Gửi yêu cầu cập nhật
            fetch('{{ route('contracts.update-expired') }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('update-status-result').classList.remove('hidden');

                    if (data.success) {
                        document.getElementById('success-message').classList.remove('hidden');
                        document.getElementById('error-message').classList.add('hidden');
                        document.getElementById('success-message-text').textContent = data.message;
                    } else {
                        document.getElementById('success-message').classList.add('hidden');
                        document.getElementById('error-message').classList.remove('hidden');
                        document.getElementById('error-message-text').textContent = data.message;
                    }

                    // Khôi phục nút
                    this.disabled = false;
                    this.textContent = 'Cập nhật trạng thái hợp đồng';

                    // Cập nhật lại trang sau 2 giây
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                })
                .catch(error => {
                    document.getElementById('update-status-result').classList.remove('hidden');
                    document.getElementById('success-message').classList.add('hidden');
                    document.getElementById('error-message').classList.remove('hidden');
                    document.getElementById('error-message-text').textContent =
                        'Đã xảy ra lỗi khi cập nhật trạng thái hợp đồng.';

                    // Khôi phục nút
                    this.disabled = false;
                    this.textContent = 'Cập nhật trạng thái hợp đồng';
                });
        });
    </script>
</x-app-layout>
