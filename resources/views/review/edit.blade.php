<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Chỉnh sửa đánh giá') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('review.update', $review->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <h5>Phòng: {{ $room->room_number }} - {{ $room->building->name ?? 'N/A' }}</h5>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Đánh giá') }}</label>
                                <div class="rating-stars">
                                    <div class="d-flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="rating"
                                                    id="rating{{ $i }}" value="{{ $i }}"
                                                    {{ old('rating', $review->rating) == $i ? 'checked' : '' }}
                                                    required>
                                                <label class="form-check-label" for="rating{{ $i }}">
                                                    {{ $i }} <i class="fa fa-star text-warning"></i>
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                @error('rating')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">{{ __('Nhận xét') }}</label>
                                <textarea id="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" rows="5">{{ old('comment', $review->comment) }}</textarea>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cập nhật đánh giá') }}
                                </button>
                                <a href="{{ route('review.show', $review->id) }}" class="btn btn-secondary">
                                    {{ __('Hủy') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
