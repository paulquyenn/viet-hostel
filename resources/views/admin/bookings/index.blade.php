<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Quản lý đơn đặt phòng</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Thành công!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Lỗi!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($bookings->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-file-earmark-x fs-1 text-secondary"></i>
                                <h5 class="mt-3">Không có đơn đặt phòng nào</h5>
                                <p class="text-muted">Hiện tại không có đơn đặt phòng nào.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Người đặt</th>
                                            <th scope="col">Phòng</th>
                                            <th scope="col">Ngày dự kiến chuyển vào</th>
                                            <th scope="col">Thời hạn (tháng)</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col" class="text-end">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->id }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $booking->user->name }}</div>
                                                    <div class="text-muted small">{{ $booking->user->email }}</div>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">Phòng {{ $booking->room->room_number }}</div>
                                                    <div class="text-muted small">{{ $booking->room->building->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $booking->desired_move_date->format('d/m/Y') }}</td>
                                                <td>{{ $booking->duration }}</td>
                                                <td>
                                                    @if ($booking->status == 'pending')
                                                        <span class="badge bg-warning text-dark">
                                                            {{ $booking->status_text }}
                                                        </span>
                                                    @elseif($booking->status == 'approved')
                                                        <span class="badge bg-success">
                                                            {{ $booking->status_text }}
                                                        </span>
                                                    @elseif($booking->status == 'rejected')
                                                        <span class="badge bg-danger">
                                                            {{ $booking->status_text }}
                                                        </span>
                                                    @elseif($booking->status == 'cancelled')
                                                        <span class="badge bg-secondary">
                                                            {{ $booking->status_text }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-eye"></i> Chi tiết
                                                    </a>

                                                    @if ($booking->status == 'pending')
                                                        <form method="POST"
                                                            action="{{ route('admin.bookings.approve', $booking->id) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                onclick="return confirm('Bạn có chắc chắn muốn duyệt đơn đặt phòng này?')">
                                                                <i class="bi bi-check-lg"></i> Duyệt
                                                            </button>
                                                        </form>

                                                        <form method="POST"
                                                            action="{{ route('admin.bookings.reject', $booking->id) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Bạn có chắc chắn muốn từ chối đơn đặt phòng này?')">
                                                                <i class="bi bi-x-lg"></i> Từ chối
                                                            </button>
                                                        </form>
                                                    @elseif($booking->status == 'approved' && !$booking->contract)
                                                        <a href="{{ route('admin.contracts.create', $booking->id) }}"
                                                            class="btn btn-sm btn-success">
                                                            <i class="bi bi-file-earmark-text"></i> Tạo hợp đồng
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $bookings->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
