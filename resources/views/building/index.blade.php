<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách tòa nhà</h3>
                        <div class="card-tools">
                            <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.buildings.create') }}"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên tòa nhà</th>
                                    <th>Địa chỉ</th>
                                    <th>Ngày tạo</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buildings as $building)
                                    <tr>
                                        <td>{{ $building->id }}</td>
                                        <td>{{ $building->name }}</td>
                                        <td>{{ $building->full_address }}</td>
                                        <td>{{ $building->created_at ? $building->created_at->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.buildings.show', $building) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.buildings.edit', $building) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            @if (auth()->user()->hasRole('admin'))
                                                <form action="{{ route('admin.buildings.destroy', $building) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa tòa nhà này?')">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($buildings->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="pagination-info">
                                    <small class="text-muted">
                                        Hiển thị {{ $buildings->firstItem() }} đến {{ $buildings->lastItem() }}
                                        trong tổng số {{ $buildings->total() }} kết quả
                                    </small>
                                </div>
                                <div class="pagination-wrapper">
                                    {{ $buildings->withQueryString()->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .pagination-wrapper .page-link {
            color: #6c757d;
            border-color: #dee2e6;
        }

        .pagination-wrapper .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination-wrapper .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .pagination-info {
            font-size: 0.9rem;
        }
    </style>
</x-admin-layout>
