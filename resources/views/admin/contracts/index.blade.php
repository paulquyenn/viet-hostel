<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title">Quản lý hợp đồng</h2>
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

                        @if ($contracts->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-file-earmark-text text-secondary" style="font-size: 3rem;"></i>
                                <h4 class="mt-3">Không có hợp đồng nào</h4>
                                <p class="text-muted">Hiện tại không có hợp đồng nào được tạo.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Mã hợp đồng</th>
                                            <th scope="col">Người thuê</th>
                                            <th scope="col">Phòng</th>
                                            <th scope="col">Thời hạn</th>
                                            <th scope="col">Giá thuê</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col" class="text-end">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contracts as $contract)
                                            <tr>
                                                <td>
                                                    <div>
                                                        {{ $contract->contract_number }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $contract->created_at ? $contract->created_at->format('d/m/Y') : 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        {{ $contract->tenant->name }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $contract->tenant->email }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        Phòng {{ $contract->room->room_number }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $contract->room->building->name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        {{ $contract->start_date->format('d/m/Y') }} -
                                                        {{ $contract->end_date->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $contract->duration_in_months }} tháng
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ number_format($contract->monthly_rent) }} VND/tháng
                                                </td>
                                                <td>
                                                    @if ($contract->status == 'pending')
                                                        <span class="badge bg-warning text-dark">
                                                            Chờ người thuê xác nhận
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
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i> Xem
                                                        </a>

                                                        <a href="{{ route('admin.contracts.edit', $contract->id) }}"
                                                            class="btn btn-sm btn-outline-secondary">
                                                            <i class="bi bi-pencil"></i> Sửa
                                                        </a>

                                                        @if ($contract->file_path)
                                                            <a href="{{ route('admin.contracts.download', $contract->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="bi bi-download"></i> Tải xuống
                                                            </a>
                                                        @endif
                                                    </div>

                                                    <div class="mt-2">
                                                        @if ($contract->status == 'pending' && !$contract->isSigned())
                                                            <form method="POST"
                                                                action="{{ route('admin.contracts.sign', $contract->id) }}"
                                                                class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-primary"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn xác nhận hợp đồng này?')">
                                                                    <i class="bi bi-check-circle"></i> Xác nhận hợp đồng
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($contract->status == 'active')
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#terminateModal{{ $contract->id }}">
                                                                <i class="bi bi-x-circle"></i> Chấm dứt
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-center">
                                {{ $contracts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Chấm dứt hợp đồng cho từng hợp đồng -->
    @foreach ($contracts as $contract)
        @if ($contract->status == 'active')
            <div class="modal fade" id="terminateModal{{ $contract->id }}" tabindex="-1"
                aria-labelledby="terminateModalLabel{{ $contract->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="terminateModalLabel{{ $contract->id }}">Chấm dứt hợp đồng
                                #{{ $contract->contract_number }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form
                            action="{{ Auth::user()->hasRole('admin') ? route('admin.contracts.terminate', $contract->id) : route('landlord.contracts.terminate', $contract->id) }}"
                            method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Bạn có chắc chắn muốn chấm dứt hợp đồng này? Hành động này không thể hoàn tác.
                                </div>
                                <div class="mb-3">
                                    <label for="termination_reason{{ $contract->id }}" class="form-label">Lý do chấm
                                        dứt <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="termination_reason{{ $contract->id }}" name="termination_reason" rows="4"
                                        placeholder="Nhập lý do chấm dứt hợp đồng..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-danger">Chấm dứt hợp đồng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</x-admin-layout>
