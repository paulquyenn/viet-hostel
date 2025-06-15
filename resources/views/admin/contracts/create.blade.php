<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title">Tạo hợp đồng</h2>
                            <a href="{{ route('admin.bookings.index') }}"
                                class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="bi bi-arrow-left me-2"></i>
                                Quay lại
                            </a>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <strong>Lỗi!</strong> {{ session('error') }}
                            </div>
                        @endif

                        <div class="bg-light p-4 rounded">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h4 class="mb-3">Thông tin đặt phòng</h4>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">Người đặt</dt>
                                                <dd class="col-sm-8">{{ $booking->user->name }}</dd>

                                                <dt class="col-sm-4">Phòng</dt>
                                                <dd class="col-sm-8">Phòng {{ $booking->room->room_number }} -
                                                    {{ $booking->room->building->name }}</dd>

                                                <dt class="col-sm-4">Ngày dự kiến chuyển vào</dt>
                                                <dd class="col-sm-8">{{ $booking->desired_move_date->format('d/m/Y') }}
                                                </dd>

                                                <dt class="col-sm-4">Thời hạn thuê dự kiến</dt>
                                                <dd class="col-sm-8">{{ $booking->duration }} tháng</dd>
                                            </dl>
                                        </div>
                                    </div>

                                    <h4 class="mb-3">Thông tin phòng</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">Số phòng</dt>
                                                <dd class="col-sm-8">{{ $booking->room->room_number }}</dd>

                                                <dt class="col-sm-4">Khu trọ</dt>
                                                <dd class="col-sm-8">{{ $booking->room->building->name }}</dd>

                                                <dt class="col-sm-4">Địa chỉ</dt>
                                                <dd class="col-sm-8">
                                                    {{ $booking->room->building->address }},
                                                    {{ $booking->room->building->ward->name }},
                                                    {{ $booking->room->building->district->name }},
                                                    {{ $booking->room->building->province->name }}
                                                </dd>

                                                <dt class="col-sm-4">Giá phòng tiêu chuẩn</dt>
                                                <dd class="col-sm-8">{{ number_format($booking->room->price) }}
                                                    VND/tháng</dd>

                                                <dt class="col-sm-4">Đặt cọc tiêu chuẩn</dt>
                                                <dd class="col-sm-8">{{ number_format($booking->room->deposit) }} VND
                                                </dd>

                                                <dt class="col-sm-4">Sức chứa</dt>
                                                <dd class="col-sm-8">
                                                    {{ $booking->room->current_tenant_count }}/{{ $booking->room->max_person }}
                                                    người
                                                    @if ($booking->room->has_available_space)
                                                        <span class="badge bg-success">Còn
                                                            {{ $booking->room->available_spots }} chỗ</span>
                                                    @else
                                                        <span class="badge bg-warning">Đã đầy</span>
                                                    @endif
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4 class="mb-3">Thông tin hợp đồng</h4>
                                    <form method="POST" action="{{ route('admin.contracts.store') }}"
                                        enctype="multipart/form-data" class="card card-body">
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                        <input type="hidden" name="room_id" value="{{ $booking->room->id }}">
                                        <input type="hidden" name="tenant_id" value="{{ $booking->user->id }}">
                                        <input type="hidden" name="landlord_id" value="{{ auth()->id() }}">

                                        <div class="mb-4">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="start_date" class="form-label">
                                                        Ngày bắt đầu <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" name="start_date" id="start_date"
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        value="{{ $startDate }}" required>
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
                                                        value="{{ $endDate }}" required>
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
                                                        value="{{ $booking->room->price ?? 0 }}" required>
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
                                                        value="{{ $booking->room->deposit }}" required>
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
                                                    class="form-control @error('terms_and_conditions') is-invalid @enderror" required>1. Thời hạn thuê phòng: {{ $booking->duration ?? 12 }} tháng, từ ngày {{ date('d/m/Y', strtotime($startDate)) }} đến ngày {{ date('d/m/Y', strtotime($endDate)) }}

2. Giá thuê: {{ number_format($booking->room->price ?? 0) }} VND/tháng, thanh toán vào ngày 05 hàng tháng

3. Tiền đặt cọc: {{ number_format($booking->room->deposit ?? 0) }} VND

4. Điều kiện thanh toán: Tiền nhà được thanh toán đầy đủ vào đầu mỗi tháng không muộn hơn ngày 05

5. Trách nhiệm bên thuê:
   - Giữ gìn vệ sinh trong và ngoài phòng
   - Không gây ồn ào sau 22:00
   - Không được tự ý sửa chữa, cải tạo phòng khi chưa được sự đồng ý của chủ nhà
   - Không sử dụng phòng vào mục đích phi pháp
   - Chịu trách nhiệm với mọi hư hỏng do mình gây ra

6. Trách nhiệm bên cho thuê:
   - Đảm bảo cung cấp phòng ở đúng như mô tả
   - Bảo dưỡng các thiết bị trong phòng định kỳ
   - Giải quyết các sự cố kỹ thuật trong thời gian sớm nhất

7. Chấm dứt hợp đồng:
   - Nếu bên thuê muốn chấm dứt hợp đồng trước thời hạn, phải thông báo trước ít nhất 30 ngày và sẽ mất tiền đặt cọc
   - Nếu bên cho thuê muốn chấm dứt hợp đồng trước thời hạn, phải thông báo trước ít nhất 30 ngày và hoàn trả tiền đặt cọc</textarea>
                                                @error('terms_and_conditions')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="contract_file" class="form-label">
                                                    File hợp đồng (optional)
                                                </label>
                                                <input type="file" name="contract_file" id="contract_file"
                                                    class="form-control @error('contract_file') is-invalid @enderror"
                                                    accept=".pdf,.doc,.docx">
                                                <div class="form-text">Chấp nhận file PDF, DOC, DOCX (max: 10MB)</div>
                                                @error('contract_file')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    Tạo hợp đồng
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin-layout>
