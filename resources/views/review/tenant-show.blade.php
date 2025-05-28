<x-tenant-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-indigo-600 p-4">
                    <h1 class="text-white text-xl font-bold">{{ __('Chi tiết đánh giá') }}</h1>
                </div>

                <div class="p-6">
                    <!-- Room information -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="font-semibold text-xl text-gray-800">{{ $review->room->room_number }}</h2>
                                <p class="text-gray-600">{{ $review->room->building->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <a href="{{ route('motel.detail', $review->room_id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Quay lại phòng
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Rating and date -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-lg font-medium">{{ $review->rating }}/5</span>
                            </div>
                            <div class="text-gray-500">
                                <time datetime="{{ $review->created_at ? $review->created_at->format('Y-m-d') : '' }}">
                                    {{ $review->created_at ? $review->created_at->format('d/m/Y') : 'N/A' }}
                                </time>
                            </div>
                        </div>
                    </div>

                    <!-- Review comment -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-medium text-gray-900 mb-2">Nhận xét của bạn:</h3>
                        <div class="text-gray-700">
                            {{ $review->comment ?? 'Không có nhận xét' }}
                        </div>
                    </div>

                    <!-- User info -->
                    <div class="flex items-center mb-6">
                        <div class="bg-indigo-100 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $review->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $review->user->email }}</p>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('review.edit', $review->id) }}"
                            class="flex-1 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Chỉnh sửa
                        </a>

                        <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 flex justify-center items-center"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
