<x-tenant-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-indigo-600 p-4">
                    <h1 class="text-white text-xl font-bold">{{ __('Viết đánh giá mới') }}</h1>
                </div>

                <div class="p-6">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('review.store') }}">
                        @csrf

                        @if (!isset($room))
                            <div class="mb-6">
                                <label for="room_id"
                                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Chọn phòng') }}</label>
                                <select id="room_id"
                                    class="w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('room_id') border-red-500 @enderror"
                                    name="room_id" required>
                                    <option value="">-- Chọn phòng --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_number }} - {{ $room->building->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div class="mb-6">
                                <div class="flex items-center bg-indigo-50 p-4 rounded-lg">
                                    <div>
                                        <h2 class="font-semibold text-gray-900">{{ $room->room_number }}</h2>
                                        <p class="text-sm text-gray-600">{{ $room->building->name ?? 'N/A' }}</p>
                                    </div>
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                </div>
                            </div>
                        @endif

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Đánh giá') }}</label>
                            <div class="flex items-center space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div>
                                        <input type="radio" name="rating" id="rating{{ $i }}"
                                            value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}
                                            class="hidden peer" required>
                                        <label for="rating{{ $i }}" class="cursor-pointer block p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-8 w-8 peer-checked:text-yellow-400 text-gray-300"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>

                                        </label>
                                    </div>
                                @endfor
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Chọn từ 1 đến 5 sao</div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="comment"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Nhận xét của bạn') }}</label>
                            <textarea id="comment"
                                class="w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('comment') border-red-500 @enderror"
                                name="comment" rows="5" placeholder="Hãy chia sẻ trải nghiệm của bạn về phòng trọ này...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ url()->previous() }}"
                                class="py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Hủy') }}
                            </a>
                            <button type="submit"
                                class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Gửi đánh giá') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Highlight stars on hover
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('[id^="rating"]');

            stars.forEach((star, index) => {
                star.addEventListener('change', function() {
                    const currentRating = this.value;

                    stars.forEach((s, i) => {
                        const starLabel = s.nextElementSibling.querySelector('svg');
                        if (i < currentRating) {
                            starLabel.classList.add('text-yellow-400');
                            starLabel.classList.remove('text-gray-300');
                        } else {
                            starLabel.classList.remove('text-yellow-400');
                            starLabel.classList.add('text-gray-300');
                        }
                    });
                });
            });
        });
    </script>
</x-tenant-layout>
