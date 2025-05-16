<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thông báo') }}
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Tất cả thông báo</h3>
                        @if ($notifications->where('read_at', null)->count() > 0)
                            <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Đánh dấu tất cả là đã đọc
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($notifications->isEmpty())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                            role="alert">
                            <p>Bạn không có thông báo nào.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-200">
                            @foreach ($notifications as $notification)
                                <div class="py-4 {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            @if (isset($notification->data['status_change']))
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
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
                                                <a href="{{ url(isset($notification->data['url']) ? $notification->data['url'] : '#') }}"
                                                    class="text-sm text-blue-600 hover:text-blue-800 mr-4">
                                                    Xem chi tiết
                                                </a>

                                                <div class="flex space-x-4">
                                                    @if (!$notification->read_at)
                                                        <form
                                                            action="{{ route('notifications.mark-as-read', $notification->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-sm text-gray-600 hover:text-gray-800">
                                                                Đánh dấu đã đọc
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form
                                                        action="{{ route('notifications.destroy', $notification->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-sm text-red-600 hover:text-red-800">
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
