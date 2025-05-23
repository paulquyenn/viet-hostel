<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title">Chi tiết đơn đặt phòng</h5>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>
                                Quay lại
                            </a>
                        </div>

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

                        <div class="bg-light rounded p-4 mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="fw-bold mb-3">Thông tin người đặt</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4 text-muted">Họ tên</dt>
                                        <dd class="col-sm-8">{{ $booking->user->name }}</dd>

                                        <dt class="col-sm-4 text-muted">Email</dt>
                                        <dd class="col-sm-8">{{ $booking->user->email }}</dd>

                                        <dt class="col-sm-4 text-muted">Số điện thoại</dt>
                                        <dd class="col-sm-8">{{ $booking->user->phone ?? 'Chưa cung cấp' }}</dd>

                                        <dt class="col-sm-4 text-muted">Địa chỉ</dt>
                                        <dd class="col-sm-8">{{ $booking->user->address ?? 'Chưa cung cấp' }}</dd>
                                    </dl>

                                    <h5 class="fw-bold mt-4 mb-3">Thông tin đặt phòng</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4 text-muted">Mã đặt phòng</dt>
                                        <dd class="col-sm-8">{{ $booking->id }}</dd>

                                        <dt class="col-sm-4 text-muted">Ngày đặt</dt>
                                        <dd class="col-sm-8">{{ $booking->created_at->format('d/m/Y H:i') }}</dd>

                                        <dt class="col-sm-4 text-muted">Ngày dự kiến chuyển vào</dt>
                                        <dd class="col-sm-8">{{ $booking->desired_move_date->format('d/m/Y') }}</dd>

                                        <dt class="col-sm-4 text-muted">Thời hạn thuê</dt>
                                        <dd class="col-sm-8">{{ $booking->duration }} tháng</dd>

                                        <dt class="col-sm-4 text-muted">Trạng thái</dt>
                                        <dd class="col-sm-8">
                                            @if ($booking->status == 'pending')
                                                <span
                                                    class="badge bg-warning text-dark">{{ $booking->status_text }}</span>
                                            @elseif($booking->status == 'approved')
                                                <span class="badge bg-success">{{ $booking->status_text }}</span>
                                            @elseif($booking->status == 'rejected')
                                                <span class="badge bg-danger">{{ $booking->status_text }}</span>
                                            @elseif($booking->status == 'cancelled')
                                                <span class="badge bg-secondary">{{ $booking->status_text }}</span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-3">Thông tin phòng</h5>
                                    <dl class="row">
                                        <dt class="col-sm-4 text-muted">Số phòng</dt>
                                        <dd class="col-sm-8">{{ $booking->room->room_number }}</dd>

                                        <dt class="col-sm-4 text-muted">Khu trọ</dt>
                                        <dd class="col-sm-8">{{ $booking->room->building->name }}</dd>

                                        <dt class="col-sm-4 text-muted">Địa chỉ</dt>
                                        <dd class="col-sm-8">
                                            {{ $booking->room->building->address }},
                                            {{ $booking->room->building->ward->name }},
                                            {{ $booking->room->building->district->name }},
                                            {{ $booking->room->building->province->name }}
                                        </dd>

                                        <dt class="col-sm-4 text-muted">Giá phòng</dt>
                                        <dd class="col-sm-8">{{ number_format($booking->room->price) }} VND/tháng</dd>

                                        <dt class="col-sm-4 text-muted">Diện tích</dt>
                                        <dd class="col-sm-8">{{ $booking->room->area }} m<sup>2</sup></dd>
                                    </dl>
                                </div>
                            </div>

                            @if ($booking->note)
                                <div class="mt-4">
                                    <h5 class="fw-bold mb-2">Ghi chú từ người đặt</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text">{{ $booking->note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Hiển thị thông tin hợp đồng nếu có -->
                        @if ($booking->contract)
                            <div class="card mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Thông tin hợp đồng</h5>
                                    <a href="{{ route('admin.contracts.edit', $booking->contract->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Chỉnh sửa hợp đồng
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light" style="width: 30%">Mã hợp đồng</th>
                                                    <td>{{ $booking->contract->contract_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Trạng thái hợp đồng</th>
                                                    <td>
                                                        @if ($booking->contract->status == 'pending')
                                                            <span
                                                                class="badge bg-warning text-dark">{{ $booking->contract->status_text }}</span>
                                                        @elseif($booking->contract->status == 'active')
                                                            <span
                                                                class="badge bg-success">{{ $booking->contract->status_text }}</span>
                                                        @elseif($booking->contract->status == 'expired')
                                                            <span
                                                                class="badge bg-secondary">{{ $booking->contract->status_text }}</span>
                                                        @elseif($booking->contract->status == 'terminated')
                                                            <span
                                                                class="badge bg-danger">{{ $booking->contract->status_text }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Thời hạn hợp đồng</th>
                                                    <td>
                                                        {{ $booking->contract->start_date->format('d/m/Y') }} -
                                                        {{ $booking->contract->end_date->format('d/m/Y') }}
                                                        ({{ $booking->contract->duration_in_months }} tháng)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Giá thuê hàng tháng</th>
                                                    <td>{{ number_format($booking->contract->monthly_rent) }} VND</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Tiền đặt cọc</th>
                                                    <td>{{ number_format($booking->contract->deposit_amount) }} VND
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">File hợp đồng</th>
                                                    <td>
                                                        @if ($booking->contract->file_path)
                                                            <a href="{{ route('admin.contracts.download', $booking->contract->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-download"></i> Tải xuống
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Chưa có file</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>

                            @if ($booking->status == 'pending')
                                <div class="d-flex gap-2">
                                    <form method="POST" action="{{ route('admin.bookings.reject', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn từ chối đơn đặt phòng này?')">
                                            <i class="bi bi-x-lg me-1"></i> Từ chối
                                        </button>
                                    </form>

                                    <form method="POST"
                                        action="{{ route('admin.bookings.approve', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Bạn có chắc chắn muốn duyệt đơn đặt phòng này?')">
                                            <i class="bi bi-check-lg me-1"></i> Duyệt đơn
                                        </button>
                                    </form>
                                </div>
                            @elseif($booking->status == 'approved' && !$booking->contract)
                                <a href="{{ route('admin.contracts.create', $booking->id) }}"
                                    class="btn btn-primary">
                                    <i class="bi bi-file-earmark-text me-1"></i> Tạo hợp đồng
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin-layout>
