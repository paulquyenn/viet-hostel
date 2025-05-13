<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>{{ __('Chi tiết đánh giá') }}</div>
                        <div>
                            <a href="{{ route('review.index') }}" class="btn btn-sm btn-secondary">
                                {{ __('Quay lại') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 font-weight-bold">{{ __('Phòng:') }}</div>
                            <div class="col-md-8">
                                <a href="{{ route('room.show', $review->room_id) }}">
                                    {{ $review->room->room_number }}
                                    @if ($review->room->building)
                                        - {{ $review->room->building->name }}
                                    @endif
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 font-weight-bold">{{ __('Người đánh giá:') }}</div>
                            <div class="col-md-8">{{ $review->user->name }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 font-weight-bold">{{ __('Đánh giá:') }}</div>
                            <div class="col-md-8">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fa fa-star text-warning"></i>
                                    @else
                                        <i class="fa fa-star text-secondary"></i>
                                    @endif
                                @endfor
                                ({{ $review->rating }}/5)
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 font-weight-bold">{{ __('Bình luận:') }}</div>
                            <div class="col-md-8">
                                @if ($review->comment)
                                    {{ $review->comment }}
                                @else
                                    <em>Không có bình luận</em>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 font-weight-bold">{{ __('Ngày đánh giá:') }}</div>
                            <div class="col-md-8">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 font-weight-bold">{{ __('Cập nhật lần cuối:') }}</div>
                            <div class="col-md-8">{{ $review->updated_at->format('d/m/Y H:i') }}</div>
                        </div>

                        @if (auth()->id() === $review->user_id || auth()->user()->hasRole('admin'))
                            <hr>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('review.edit', $review->id) }}" class="btn btn-primary me-2">
                                    <i class="fa fa-edit"></i> {{ __('Chỉnh sửa') }}
                                </a>
                                <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                        <i class="fa fa-trash"></i> {{ __('Xóa') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
