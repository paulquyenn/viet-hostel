<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết phòng {{ $room->room_number }}</h5>
                        <div>
                            <a href="{{ route('room.edit', $room) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Sửa
                            </a>
                            <a href="{{ route('room.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div id="carouselRoom" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach ($room->images as $key => $image)
                                            <button type="button" data-bs-target="#carouselRoom"
                                                data-bs-slide-to="{{ $key }}"
                                                class="{{ $key == 0 ? 'active' : '' }}"></button>
                                        @endforeach
                                    </div>

                                    <div class="carousel-inner">
                                        @forelse($room->images as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100"
                                                    alt="Room Image" style="max-height: 500px; object-fit: contain;">
                                                @if ($image->is_primary)
                                                    <div class="carousel-caption">
                                                        <span class="badge bg-success">Ảnh chính</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="carousel-item active">
                                                <div class="d-flex align-items-center justify-content-center bg-light"
                                                    style="height: 300px;">
                                                    <p class="text-muted">Không có hình ảnh</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>

                                    @if ($room->images->count() > 1)
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselRoom" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Trước</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselRoom" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Sau</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5>Thông tin cơ bản</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Tòa nhà</th>
                                        <td>{{ $room->building->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số phòng</th>
                                        <td>{{ $room->room_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diện tích</th>
                                        <td>{{ number_format($room->area, 1) }} m²</td>
                                    </tr>
                                    <tr>
                                        <th>Giá thuê</th>
                                        <td>{{ number_format($room->price) }} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <th>Tiền đặt cọc</th>
                                        <td>{{ number_format($room->deposit_amount) }} VNĐ</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Thông tin khác</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Trạng thái</th>
                                        <td>
                                            @if ($room->status == 0)
                                                <span class="badge bg-success">Trống</span>
                                            @elseif($room->status == 1)
                                                <span class="badge bg-primary">Đã thuê</span>
                                            @else
                                                <span class="badge bg-warning">Đang bảo trì</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Số người tối đa</th>
                                        <td>{{ $room->max_person }} người</td>
                                    </tr>
                                    <tr>
                                        <th>Tiện ích</th>
                                        <td>{{ $room->utilities ?? 'Không có' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $room->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cập nhật lần cuối</th>
                                        <td>{{ $room->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Mô tả</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {!! nl2br(e($room->description ?? 'Không có mô tả')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phần đánh giá -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Đánh giá phòng ({{ $room->reviews->count() }})</h5>
                                    <a href="{{ route('review.create', ['room_id' => $room->id]) }}"
                                        class="btn btn-primary">
                                        <i class="bi bi-star"></i> Thêm đánh giá
                                    </a>
                                </div>

                                @if ($room->reviews->count() > 0)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="me-3">
                                                    <h4>{{ number_format($room->average_rating, 1) }}</h4>
                                                    <div>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($room->average_rating))
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star text-secondary"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <small>{{ $room->reviews->count() }} đánh giá</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($room->reviews as $review)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6>{{ $review->user->name }}</h6>
                                                        <div>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $review->rating)
                                                                    <i class="bi bi-star-fill text-warning"></i>
                                                                @else
                                                                    <i class="bi bi-star text-secondary"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                                    </div>

                                                    @if (auth()->id() === $review->user_id || auth()->user()->hasRole('admin'))
                                                        <div>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-light dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenuButton{{ $review->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi bi-three-dots-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton{{ $review->id }}">
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('review.edit', $review->id) }}">
                                                                            <i class="bi bi-pencil"></i> Chỉnh sửa
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('review.destroy', $review->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item text-danger"
                                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                                                <i class="bi bi-trash"></i> Xóa
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="mt-3">
                                                    {{ $review->comment ?? 'Không có nhận xét' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        Chưa có đánh giá nào cho phòng này. Hãy là người đầu tiên đánh giá!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
