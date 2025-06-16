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

                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $booking->id }}">
                                                            <i class="bi bi-x-lg"></i> Từ chối
                                                        </button>

                                                        <!-- Reject Modal -->
                                                        <div class="modal fade" id="rejectModal{{ $booking->id }}"
                                                            tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Từ chối đơn đặt phòng
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('admin.bookings.reject', $booking->id) }}">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="reject_reason{{ $booking->id }}"
                                                                                    class="form-label">Lý do từ chối
                                                                                    <span
                                                                                        class="text-danger">*</span></label>
                                                                                <textarea class="form-control" id="reject_reason{{ $booking->id }}" name="reject_reason" rows="4"
                                                                                    placeholder="Nhập lý do từ chối đơn đặt phòng..." required></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Hủy</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Từ chối
                                                                                đơn</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
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
