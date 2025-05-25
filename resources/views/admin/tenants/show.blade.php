<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title">Chi tiết người thuê</h2>
                            <a href="{{ route('admin.tenants.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Thành công!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Tenant Information Card -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-person-circle"></i> Thông tin cá nhân
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-4">
                                            <div
                                                class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                                {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                            </div>
                                            <h4>{{ $tenant->name }}</h4>
                                            <p class="text-muted">ID: {{ $tenant->id }}</p>
                                        </div>

                                        <hr>

                                        <div class="info-group">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Email:</label>
                                                <div class="fw-semibold">
                                                    <i class="bi bi-envelope text-primary"></i> {{ $tenant->email }}
                                                </div>
                                            </div>

                                            @if ($tenant->phone)
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Số điện thoại:</label>
                                                    <div class="fw-semibold">
                                                        <i class="bi bi-telephone text-primary"></i>
                                                        {{ $tenant->phone }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($tenant->address)
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Địa chỉ:</label>
                                                    <div class="fw-semibold">
                                                        <i class="bi bi-geo-alt text-primary"></i>
                                                        {{ $tenant->address }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label class="form-label text-muted">Ngày tham gia:</label>
                                                <div class="fw-semibold">
                                                    <i class="bi bi-calendar text-primary"></i>
                                                    {{ $tenant->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <!-- Active Contracts -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-file-earmark-check text-success"></i> Hợp đồng hiện tại
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($tenant->contracts->where('status', 'active')->isEmpty())
                                            <div class="text-center py-3">
                                                <i class="bi bi-file-earmark-x text-muted" style="font-size: 2rem;"></i>
                                                <p class="text-muted mt-2">Không có hợp đồng hiệu lực nào</p>
                                            </div>
                                        @else
                                            @foreach ($tenant->contracts->where('status', 'active') as $contract)
                                                <div class="border rounded p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="fw-semibold text-primary">
                                                                {{ $contract->contract_number }}</h6>
                                                            <p class="mb-2">
                                                                <strong>Phòng:</strong>
                                                                {{ $contract->room->room_number }}<br>
                                                                <strong>Tòa nhà:</strong>
                                                                {{ $contract->room->building->name }}<br>
                                                                <strong>Địa chỉ:</strong>
                                                                {{ $contract->room->building->address }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-2">
                                                                <strong>Giá thuê:</strong>
                                                                <span
                                                                    class="text-success fw-semibold">{{ number_format($contract->monthly_rent) }}
                                                                    VND/tháng</span>
                                                            </p>
                                                            <p class="mb-2">
                                                                <strong>Thời hạn:</strong>
                                                                {{ $contract->start_date->format('d/m/Y') }} -
                                                                {{ $contract->end_date->format('d/m/Y') }}
                                                            </p>
                                                            <p class="mb-2">
                                                                <strong>Trạng thái:</strong>
                                                                <span
                                                                    class="badge bg-success">{{ $contract->status_text }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end mt-2">
                                                        <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                            class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="bi bi-eye"></i> Xem chi tiết
                                                        </a>
                                                        @if ($contract->file_path)
                                                            <a href="{{ route('admin.contracts.download', $contract->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="bi bi-download"></i> Tải hợp đồng
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contract History -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-clock-history"></i> Lịch sử hợp đồng
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($tenant->contracts->isEmpty())
                                            <div class="text-center py-3">
                                                <i class="bi bi-file-earmark text-muted" style="font-size: 2rem;"></i>
                                                <p class="text-muted mt-2">Chưa có hợp đồng nào</p>
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã hợp đồng</th>
                                                            <th>Phòng</th>
                                                            <th>Thời hạn</th>
                                                            <th>Giá thuê</th>
                                                            <th>Trạng thái</th>
                                                            <th>Ngày tạo</th>
                                                            <th class="text-end">Thao tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tenant->contracts as $contract)
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ $contract->contract_number }}</strong>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <strong>Phòng
                                                                            {{ $contract->room->room_number }}</strong>
                                                                    </div>
                                                                    <small
                                                                        class="text-muted">{{ $contract->room->building->name }}</small>
                                                                </td>
                                                                <td>
                                                                    <div>{{ $contract->start_date->format('d/m/Y') }}
                                                                    </div>
                                                                    <div>{{ $contract->end_date->format('d/m/Y') }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="fw-semibold">{{ number_format($contract->monthly_rent) }}
                                                                        VND</span>
                                                                </td>
                                                                <td>
                                                                    @if ($contract->status == 'active')
                                                                        <span
                                                                            class="badge bg-success">{{ $contract->status_text }}</span>
                                                                    @elseif($contract->status == 'pending')
                                                                        <span
                                                                            class="badge bg-warning">{{ $contract->status_text }}</span>
                                                                    @elseif($contract->status == 'expired')
                                                                        <span
                                                                            class="badge bg-secondary">{{ $contract->status_text }}</span>
                                                                    @elseif($contract->status == 'terminated')
                                                                        <span
                                                                            class="badge bg-danger">{{ $contract->status_text }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $contract->created_at->format('d/m/Y H:i') }}
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking History -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-calendar-check"></i> Lịch sử đặt phòng
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($tenant->bookings->isEmpty())
                                            <div class="text-center py-3">
                                                <i class="bi bi-calendar text-muted" style="font-size: 2rem;"></i>
                                                <p class="text-muted mt-2">Chưa có đơn đặt phòng nào</p>
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Phòng</th>
                                                            <th>Ngày muốn dọn vào</th>
                                                            <th>Thời hạn thuê</th>
                                                            <th>Trạng thái</th>
                                                            <th>Ngày đặt</th>
                                                            <th class="text-end">Thao tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tenant->bookings as $booking)
                                                            <tr>
                                                                <td>
                                                                    <div>
                                                                        <strong>Phòng
                                                                            {{ $booking->room->room_number }}</strong>
                                                                    </div>
                                                                    <small
                                                                        class="text-muted">{{ $booking->room->building->name }}</small>
                                                                </td>
                                                                <td>
                                                                    {{ $booking->desired_move_date->format('d/m/Y') }}
                                                                </td>
                                                                <td>
                                                                    {{ $booking->duration }} tháng
                                                                </td>
                                                                <td>
                                                                    @if ($booking->status == 'pending')
                                                                        <span class="badge bg-warning">Chờ duyệt</span>
                                                                    @elseif($booking->status == 'approved')
                                                                        <span class="badge bg-success">Đã duyệt</span>
                                                                    @elseif($booking->status == 'rejected')
                                                                        <span class="badge bg-danger">Đã từ chối</span>
                                                                    @elseif($booking->status == 'cancelled')
                                                                        <span class="badge bg-secondary">Đã hủy</span>
                                                                    @elseif($booking->status == 'completed')
                                                                        <span class="badge bg-info">Hoàn thành</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $booking->created_at->format('d/m/Y H:i') }}
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-lg {
            width: 80px;
            height: 80px;
            font-size: 24px;
            font-weight: 700;
        }

        .info-group .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .border-primary {
            border-color: #0d6efd !important;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
    </style>
</x-admin-layout>
