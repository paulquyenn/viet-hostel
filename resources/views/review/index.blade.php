<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>{{ __('Danh sách đánh giá') }}</div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($reviews->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Phòng</th>
                                            <th>Tòa nhà</th>
                                            <th>Người đánh giá</th>
                                            <th>Đánh giá</th>
                                            <th>Bình luận</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('motel.detail', $review->room_id) }}">
                                                        {{ $review->room->room_number }}
                                                    </a>
                                                </td>
                                                <td>{{ $review->room->building->name ?? 'N/A' }}</td>
                                                <td>{{ $review->user->name }}</td>
                                                <td>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="fa fa-star text-warning"></i>
                                                        @else
                                                            <i class="fa fa-star text-secondary"></i>
                                                        @endif
                                                    @endfor
                                                    ({{ $review->rating }}/5)
                                                </td>
                                                <td>{{ \Illuminate\Support\Str::limit($review->comment, 50) }}</td>
                                                <td>{{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('review.show', $review->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if (auth()->id() === $review->user_id || auth()->user()->hasRole('admin'))
                                                            <a href="{{ route('review.edit', $review->id) }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('review.destroy', $review->id) }}"
                                                                method="POST" style="display:inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $reviews->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Chưa có đánh giá nào.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
