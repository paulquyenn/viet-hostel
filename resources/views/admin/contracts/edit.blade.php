<x-admin-layout>
    <div class="py-4">
        <div class="container">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Chỉnh sửa hợp đồng</h1>
                        <a href="{{ route('admin.contracts.index') }}"
                            class="btn btn-outline-secondary d-flex align-items-center">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            Quay lại
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <strong>Thành công!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <strong>Lỗi!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="bg-light p-4 rounded">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <h3 class="h5 fw-semibold mb-3">Thông tin hợp đồng</h3>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <dl class="row mb-0">
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Mã hợp đồng</dt>
                                                <dd class="mb-0">{{ $contract->contract_number }}</dd>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Ngày tạo</dt>
                                                <dd class="mb-0">{{ $contract->created_at->format('d/m/Y H:i') }}</dd>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Trạng thái</dt>
                                                <dd class="mb-0">
                                                    @if ($contract->status == 'pending')
                                                        <span class="badge bg-warning text-dark">
                                                            {{ $contract->status_text }}
                                                        </span>
                                                    @elseif($contract->status == 'active')
                                                        <span class="badge bg-success">
                                                            {{ $contract->status_text }}
                                                        </span>
                                                    @elseif($contract->status == 'expired')
                                                        <span class="badge bg-secondary">
                                                            {{ $contract->status_text }}
                                                        </span>
                                                    @elseif($contract->status == 'terminated')
                                                        <span class="badge bg-danger">
                                                            {{ $contract->status_text }}
                                                        </span>
                                                    @endif
                                                </dd>
                                            </div>
                                            @if ($contract->isSigned())
                                                <div class="col-sm-12 mb-3">
                                                    <dt class="text-muted small">Đã ký ngày</dt>
                                                    <dd class="mb-0">{{ $contract->signed_at->format('d/m/Y H:i') }}
                                                    </dd>
                                                </div>
                                            @endif
                                        </dl>
                                    </div>
                                </div>

                                <h3 class="h5 fw-semibold mb-3">Thông tin người thuê và phòng</h3>
                                <div class="card">
                                    <div class="card-body">
                                        <dl class="row mb-0">
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Người thuê</dt>
                                                <dd class="mb-0">{{ $contract->tenant->name }}</dd>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Liên hệ</dt>
                                                <dd class="mb-0">
                                                    {{ $contract->tenant->email }} <br>
                                                    {{ $contract->tenant->phone ?? 'Không có' }}
                                                </dd>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Phòng</dt>
                                                <dd class="mb-0">Phòng {{ $contract->room->room_number }},
                                                    {{ $contract->room->building->name }}</dd>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <dt class="text-muted small">Địa chỉ</dt>
                                                <dd class="mb-0">
                                                    {{ $contract->room->building->address }},
                                                    {{ $contract->room->building->ward->name }},
                                                    {{ $contract->room->building->district->name }},
                                                    {{ $contract->room->building->province->name }}
                                                </dd>
                                            </div>
                                            @if ($contract->booking)
                                                <div class="col-sm-12">
                                                    <dt class="text-muted small">Đơn đặt phòng liên quan</dt>
                                                    <dd class="mb-0">
                                                        <a href="{{ route('admin.bookings.show', $contract->booking->id) }}"
                                                            class="text-primary">
                                                            Xem đơn đặt phòng #{{ $contract->booking->id }}
                                                        </a>
                                                    </dd>
                                                </div>
                                            @endif
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="h5 fw-semibold mb-3">Cập nhật hợp đồng</h3>

                                @if (!$contract->isSigned())
                                    <form method="POST" action="{{ route('admin.contracts.update', $contract->id) }}"
                                        enctype="multipart/form-data" class="card card-body">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="start_date" class="form-label">
                                                        Ngày bắt đầu <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" name="start_date" id="start_date"
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        value="{{ $contract->start_date->format('Y-m-d') }}" required>
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="end_date" class="form-label">
                                                        Ngày kết thúc <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" name="end_date" id="end_date"
                                                        class="form-control @error('end_date') is-invalid @enderror"
                                                        value="{{ $contract->end_date->format('Y-m-d') }}" required>
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="monthly_rent" class="form-label">
                                                        Giá thuê hàng tháng (VND) <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" name="monthly_rent" id="monthly_rent"
                                                        class="form-control @error('monthly_rent') is-invalid @enderror"
                                                        value="{{ $contract->monthly_rent }}" required>
                                                    @error('monthly_rent')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="deposit_amount" class="form-label">
                                                        Tiền đặt cọc (VND) <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" name="deposit_amount" id="deposit_amount"
                                                        class="form-control @error('deposit_amount') is-invalid @enderror"
                                                        value="{{ $contract->deposit_amount }}" required>
                                                    @error('deposit_amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="terms_and_conditions" class="form-label">
                                                    Điều khoản và điều kiện <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="terms_and_conditions" id="terms_and_conditions" rows="10"
                                                    class="form-control @error('terms_and_conditions') is-invalid @enderror" required>{{ $contract->terms_and_conditions }}</textarea>
                                                @error('terms_and_conditions')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="contract_file" class="form-label">
                                                    File hợp đồng mới (optional)
                                                </label>
                                                <input type="file" name="contract_file" id="contract_file"
                                                    class="form-control @error('contract_file') is-invalid @enderror"
                                                    accept=".pdf,.doc,.docx">
                                                <div class="form-text">Chấp nhận file PDF, DOC, DOCX (max: 10MB)</div>
                                                @error('contract_file')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            @if ($contract->file_path)
                                                <div class="mb-3">
                                                    <p class="form-label mb-2">File hiện tại:</p>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-file-earmark me-2 text-secondary"></i>
                                                        <a href="{{ route('tenant.contracts.download', $contract->id) }}"
                                                            class="text-primary">
                                                            Tải xuống file hiện tại
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                    </svg>
                                                    Cập nhật hợp đồng
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                                            </div>
                                            <div>
                                                <h4 class="alert-heading h6">Hợp đồng đã được ký</h4>
                                                <p class="mb-3">Hợp đồng đã được ký nên không thể chỉnh sửa. Nếu cần
                                                    thay đổi, vui lòng chấm dứt hợp đồng hiện tại và tạo hợp đồng mới.
                                                </p>
                                                <div>
                                                    <a href="{{ route('tenant.contracts.download', $contract->id) }}"
                                                        class="btn btn-outline-warning btn-sm me-2">
                                                        Tải xuống hợp đồng
                                                    </a>

                                                    @if ($contract->status == 'active')
                                                        <form method="POST"
                                                            action="{{ route('admin.contracts.terminate', $contract->id) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Bạn có chắc chắn muốn chấm dứt hợp đồng này?')">
                                                                Chấm dứt hợp đồng
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h4 class="h6 fw-semibold mb-3">Chi tiết hợp đồng hiện tại</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <dl class="row mb-0">
                                                    <div class="col-sm-12 mb-3">
                                                        <dt class="text-muted small">Ngày bắt đầu - kết thúc</dt>
                                                        <dd class="mb-0">
                                                            {{ $contract->start_date->format('d/m/Y') }} -
                                                            {{ $contract->end_date->format('d/m/Y') }}</dd>
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <dt class="text-muted small">Thời hạn</dt>
                                                        <dd class="mb-0">{{ $contract->duration_in_months }} tháng
                                                        </dd>
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <dt class="text-muted small">Giá thuê hàng tháng</dt>
                                                        <dd class="mb-0">
                                                            {{ number_format($contract->monthly_rent) }} VND/tháng</dd>
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <dt class="text-muted small">Đặt cọc</dt>
                                                        <dd class="mb-0">
                                                            {{ number_format($contract->deposit_amount) }} VND</dd>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <dt class="text-muted small">Điều khoản và điều kiện</dt>
                                                        <dd class="mb-0" style="white-space: pre-line">
                                                            {{ $contract->terms_and_conditions }}</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
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
