<x-admin-layout>
    <div class="py-4">
        <div class="container">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Chi tiết hợp đồng</h1>
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

                    <!-- Header with contract number and status -->
                    <div
                        class="bg-light rounded-top p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom mb-4">
                        <div>
                            <h2 class="h4 fw-bold">Hợp đồng số: {{ $contract->contract_number }}</h2>
                            <p class="text-muted mb-0">Ngày tạo: {{ $contract->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <div class="d-flex align-items-center">
                                <span class="small me-2">Trạng thái:</span>
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
                            </div>
                        </div>
                    </div>

                    <div class="p-3">
                        <!-- Contract details -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <h3 class="h5 fw-semibold mb-3">Thông tin phòng</h3>
                                <div class="bg-light p-3 rounded border">
                                    <dl class="row g-3 mb-0">
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Số phòng</dt>
                                            <dd class="mb-0">{{ $contract->room->room_number }}</dd>
                                        </div>
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Khu trọ</dt>
                                            <dd class="mb-0">{{ $contract->room->building->name }}</dd>
                                        </div>
                                        <div class="col-12">
                                            <dt class="text-muted small">Địa chỉ</dt>
                                            <dd class="mb-0">
                                                {{ $contract->room->building->address }},
                                                {{ $contract->room->building->ward->name }},
                                                {{ $contract->room->building->district->name }},
                                                {{ $contract->room->building->province->name }}
                                            </dd>
                                        </div>
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Giá phòng tiêu chuẩn</dt>
                                            <dd class="mb-0 fw-semibold">{{ number_format($contract->room->price) }}
                                                VND/tháng</dd>
                                        </div>
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Đặt cọc tiêu chuẩn</dt>
                                            <dd class="mb-0 fw-semibold">{{ number_format($contract->room->deposit) }}
                                                VND</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="h5 fw-semibold mb-3">Thông tin người thuê</h3>
                                <div class="bg-light p-3 rounded border">
                                    <dl class="row g-3 mb-0">
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Họ tên</dt>
                                            <dd class="mb-0">{{ $contract->tenant->name }}</dd>
                                        </div>
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Email</dt>
                                            <dd class="mb-0">{{ $contract->tenant->email }}</dd>
                                        </div>
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Số điện thoại</dt>
                                            <dd class="mb-0">{{ $contract->tenant->phone ?? 'Không có' }}</dd>
                                        </div>
                                        <div class="col-sm-6">
                                            <dt class="text-muted small">Địa chỉ</dt>
                                            <dd class="mb-0">{{ $contract->tenant->address ?? 'Không có' }}</dd>
                                        </div>
                                        @if ($contract->booking)
                                            <div class="col-12">
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

                        <!-- Contract financial details -->
                        <div class="mb-4">
                            <h3 class="h5 fw-semibold mb-3 pb-2 border-bottom">Chi tiết hợp đồng</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <div class="bg-light p-3 rounded border">
                                        <dl class="row g-3 mb-0">
                                            <div class="col-12">
                                                <dt class="text-muted small">Giá thuê hàng tháng</dt>
                                                <dd class="mb-0 fw-semibold">
                                                    {{ number_format($contract->monthly_rent) }} VND/tháng</dd>
                                            </div>
                                            <div class="col-12">
                                                <dt class="text-muted small">Tiền đặt cọc</dt>
                                                <dd class="mb-0 fw-semibold">
                                                    {{ number_format($contract->deposit_amount) }} VND</dd>
                                            </div>
                                            <div class="col-12">
                                                <dt class="text-muted small">Thời hạn hợp đồng</dt>
                                                <dd class="mb-0">Từ
                                                    {{ $contract->start_date->format('d/m/Y') }} đến
                                                    {{ $contract->end_date->format('d/m/Y') }}
                                                    ({{ $contract->duration_in_months }} tháng)</dd>
                                            </div>
                                            @if ($contract->isSigned())
                                                <div class="col-12">
                                                    <dt class="text-muted small">Ngày ký hợp đồng</dt>
                                                    <dd class="mb-0">{{ $contract->signed_at->format('d/m/Y H:i') }}
                                                    </dd>
                                                </div>
                                            @endif
                                        </dl>
                                    </div>
                                </div>

                                @if ($contract->isSigned() && $contract->signature_path)
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded border">
                                            <dt class="text-muted small mb-2">Chữ ký người thuê</dt>
                                            <div class="mt-1 text-center">
                                                <img src="{{ Storage::url($contract->signature_path) }}"
                                                    alt="Chữ ký người thuê" class="img-fluid"
                                                    style="max-height: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <h3 class="h5 fw-semibold mb-3 pb-2 border-bottom">Điều khoản và điều kiện</h3>
                            <div class="bg-light p-3 rounded border">
                                <p class="mb-0" style="white-space: pre-line">{{ $contract->terms_and_conditions }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div
                            class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 gap-3">
                            <div>
                                @if ($contract->file_path)
                                    <a href="{{ route('admin.contracts.download', $contract->id) }}"
                                        class="btn btn-primary d-inline-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16" class="me-2">
                                            <path
                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path
                                                d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                        </svg>
                                        Tải xuống hợp đồng
                                    </a>
                                @endif
                            </div>
                            <div>
                                @if ($contract->status == 'pending' && !$contract->isSigned())
                                    <a href="{{ route('admin.contracts.edit', $contract->id) }}"
                                        class="btn btn-primary d-inline-flex align-items-center me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16" class="me-2">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                        Chỉnh sửa
                                    </a>
                                    <button id="openSignModal"
                                        class="btn btn-success d-inline-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16" class="me-2">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>
                                        Ký hợp đồng
                                    </button>
                                @elseif($contract->status == 'active')
                                    <form action="{{ route('admin.contracts.terminate', $contract->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Bạn có chắc chắn muốn chấm dứt hợp đồng này?')"
                                            class="btn btn-danger d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" class="me-2">
                                                <path
                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                            </svg>
                                            Chấm dứt hợp đồng
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Signature Modal -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signatureModalLabel">Ký hợp đồng</h5>
                    <button type="button" class="btn-close" id="closeSignModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3 text-muted small">
                        Bằng việc ký tên dưới đây, bạn với vai trò là chủ trọ xác nhận hợp đồng này.
                    </p>

                    <div class="mb-3">
                        <label class="form-label">Chữ ký của bạn:</label>
                        <div class="signature-pad border rounded">
                            <canvas id="signature-pad" class="signature-canvas"></canvas>
                        </div>
                        <div class="mt-2">
                            <button id="clear-signature" type="button" class="btn btn-sm btn-outline-secondary">
                                Xóa chữ ký
                            </button>
                        </div>
                    </div>

                    <form id="contract-sign-form" method="POST"
                        action="{{ route('admin.contracts.sign', $contract->id) }}">
                        @csrf
                        <input type="hidden" name="signature_data" id="signature_data">
                        <div class="d-flex justify-content-end">
                            <button id="cancelSignModal" type="button" class="btn btn-outline-secondary me-2"
                                data-bs-dismiss="modal">
                                Hủy
                            </button>
                            <button type="submit" class="btn btn-success">
                                Xác nhận ký hợp đồng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Signature Pad JS -->
    <link rel="stylesheet" href="{{ asset('assets/css/signature-pad.css') }}">
    <script src="{{ asset('node_modules/signature_pad/dist/signature_pad.min.js') }}"></script>
    <script src="{{ asset('assets/js/signature-pad.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup for signature modal
            const modal = document.getElementById('signatureModal');
            const openBtn = document.getElementById('openSignModal');
            const closeBtn = document.getElementById('closeSignModal');
            const cancelBtn = document.getElementById('cancelSignModal');

            // Ensure signature pad is initialized when modal opens
            if (modal) {
                modal.addEventListener('shown.bs.modal', function() {
                    if (window.signaturePad) {
                        window.signaturePad.clear();
                        resizeCanvas(); // Make sure canvas is properly sized
                    }
                });
            }

            if (openBtn) {
                openBtn.addEventListener('click', function() {
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    bsModal.hide();
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    bsModal.hide();
                });
            }
        });
    </script>
</x-admin-layout>
