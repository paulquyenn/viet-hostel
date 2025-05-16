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
                                                        {{ $contract->created_at->format('d/m/Y') }}
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
                                                            <a href="{{ route('tenant.contracts.download', $contract->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="bi bi-download"></i> Tải xuống
                                                            </a>
                                                        @endif
                                                    </div>

                                                    <div class="mt-2">
                                                        @if ($contract->status == 'pending' && !$contract->isSigned())
                                                            <form method="POST"
                                                                action="{{ route('tenant.contracts.sign', $contract->id) }}"
                                                                class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-primary"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn ký hợp đồng này?')">
                                                                    <i class="bi bi-pen"></i> Ký hợp đồng
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($contract->status == 'active')
                                                            <form method="POST"
                                                                action="{{ route('admin.contracts.terminate', $contract->id) }}"
                                                                class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn chấm dứt hợp đồng này?')">
                                                                    <i class="bi bi-x-circle"></i> Chấm dứt
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

                            <div class="mt-4 d-flex justify-content-center">
                                {{ $contracts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
