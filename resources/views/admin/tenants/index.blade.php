<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title">Quản lý người thuê trọ</h2>
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

                        <!-- Search and Filter Form -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <form method="GET" action="{{ route('admin.tenants.index') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search" class="form-label">Tìm kiếm</label>
                                        <input type="text" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Tên, email hoặc số điện thoại...">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="building_filter" class="form-label">Lọc theo tòa nhà</label>
                                        <select class="form-select" id="building_filter" name="building_filter">
                                            <option value="">Tất cả tòa nhà</option>
                                            @foreach ($buildings as $building)
                                                <option value="{{ $building->id }}"
                                                    {{ request('building_filter') == $building->id ? 'selected' : '' }}>
                                                    {{ $building->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="bi bi-search"></i> Tìm kiếm
                                        </button>
                                        <a href="{{ route('admin.tenants.index') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Đặt lại
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if ($tenants->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-people text-secondary" style="font-size: 3rem;"></i>
                                <h4 class="mt-3">Không có người thuê nào</h4>
                                <p class="text-muted">
                                    @if (request('search') || request('building_filter'))
                                        Không tìm thấy người thuê nào phù hợp với tiêu chí tìm kiếm.
                                    @else
                                        Hiện tại bạn chưa có người thuê nào.
                                    @endif
                                </p>
                            </div>
                        @else
                            <!-- Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">Tổng người thuê</h5>
                                                    <h3>{{ $tenants->total() }}</h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="bi bi-people" style="font-size: 2rem;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">Hợp đồng hiệu lực</h5>
                                                    <h3>{{ $tenants->sum(function ($tenant) {return $tenant->contracts->count();}) }}
                                                    </h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="bi bi-file-earmark-check" style="font-size: 2rem;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">Tòa nhà</h5>
                                                    <h3>{{ $buildings->count() }}</h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="bi bi-building" style="font-size: 2rem;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title">Tổng thu nhập/tháng</h5>
                                                    <h3>{{ number_format(
                                                        $tenants->sum(function ($tenant) {
                                                            return $tenant->contracts->sum('monthly_rent');
                                                        }) / 1000000,
                                                        1,
                                                    ) }}M
                                                    </h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="bi bi-currency-dollar" style="font-size: 2rem;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Thông tin người thuê</th>
                                            <th scope="col">Liên hệ</th>
                                            <th scope="col">Phòng đang thuê</th>
                                            <th scope="col">Giá thuê</th>
                                            <th scope="col">Thời hạn</th>
                                            <th scope="col" class="text-end">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tenants as $tenant)
                                            @foreach ($tenant->contracts as $contract)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                                {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $tenant->name }}</h6>
                                                                <small class="text-muted">ID:
                                                                    {{ $tenant->id }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <i class="bi bi-envelope"></i> {{ $tenant->email }}
                                                        </div>
                                                        @if ($tenant->phone)
                                                            <div class="mt-1">
                                                                <i class="bi bi-telephone"></i> {{ $tenant->phone }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <strong>Phòng {{ $contract->room->room_number }}</strong>
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $contract->room->building->name }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold text-success">
                                                            {{ number_format($contract->monthly_rent) }} VND
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <small>{{ $contract->start_date->format('d/m/Y') }}</small>
                                                        </div>
                                                        <div>
                                                            <small>đến
                                                                {{ $contract->end_date->format('d/m/Y') }}</small>
                                                        </div>
                                                        <span class="badge bg-success">
                                                            {{ $contract->status_text }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.tenants.show', $tenant->id) }}"
                                                                class="btn btn-sm btn-outline-primary"
                                                                title="Xem chi tiết">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                                class="btn btn-sm btn-outline-info"
                                                                title="Xem hợp đồng">
                                                                <i class="bi bi-file-earmark-text"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <p class="text-muted mb-0">
                                        Hiển thị {{ $tenants->firstItem() ?? 0 }} đến {{ $tenants->lastItem() ?? 0 }}
                                        trong tổng số {{ $tenants->total() }} người thuê
                                    </p>
                                </div>
                                <div>
                                    {{ $tenants->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 16px;
            font-weight: 600;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>
</x-admin-layout>
