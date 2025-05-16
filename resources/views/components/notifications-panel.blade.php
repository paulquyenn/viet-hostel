<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Thông báo mới</h3>

        @if ($notifications->isEmpty())
            <div class="text-gray-500 text-center py-4">
                Bạn không có thông báo nào.
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach ($notifications as $notification)
                    <div class="py-3 {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                @if (isset($notification->data['status_change']))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $notification->data['title'] }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500">
                                    {{ $notification->data['message'] }}
                                </p>
                                <div class="mt-2 flex">
                                    <a href="{{ isset($notification->data['url']) ? $notification->data['url'] : '#' }}"
                                        class="text-sm text-blue-600 hover:text-blue-800 mr-4">
                                        Xem chi tiết
                                    </a>
                                    @if (!$notification->read_at)
                                        <form action="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">
                                                Đánh dấu đã đọc
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex justify-center">
                <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Xem tất cả thông báo
                </a>
            </div>
        @endif
    </div>
</div>
