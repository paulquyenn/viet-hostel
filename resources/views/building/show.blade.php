<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Chi tiết tòa nhà: {{ $building->name }}</h3>
                            <div class="card-tools">
                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.buildings.index') }}"
                                    class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.buildings.edit', $building) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Chỉnh sửa
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Building Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-building"></i> Thông tin tòa nhà
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="30%">ID:</th>
                                                <td>{{ $building->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tên tòa nhà:</th>
                                                <td><strong>{{ $building->name }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Địa chỉ:</th>
                                                <td>{{ $building->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phường/Xã:</th>
                                                <td>{{ $building->ward->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Quận/Huyện:</th>
                                                <td>{{ $building->district->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tỉnh/Thành phố:</th>
                                                <td>{{ $building->province->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Địa chỉ đầy đủ:</th>
                                                <td>{{ $building->full_address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ngày tạo:</th>
                                                <td>{{ $building->created_at ? $building->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cập nhật lần cuối:</th>
                                                <td>{{ $building->updated_at ? $building->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-bar-chart"></i> Thống kê
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border rounded p-3 mb-3">
                                                    <h3 class="text-primary mb-1">{{ $building->rooms->count() }}</h3>
                                                    <p class="text-muted mb-0">Tổng số phòng</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="border rounded p-3 mb-3">
                                                    <h3 class="text-success mb-1">
                                                        {{ $building->rooms->where('status', 'available')->count() }}
                                                    </h3>
                                                    <p class="text-muted mb-0">Phòng trống</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border rounded p-3">
                                                    <h3 class="text-warning mb-1">
                                                        {{ $building->rooms->where('status', 'occupied')->count() }}
                                                    </h3>
                                                    <p class="text-muted mb-0">Phòng đã thuê</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="border rounded p-3">
                                                    <h3 class="text-info mb-1">
                                                        {{ $building->rooms->isNotEmpty() ? number_format($building->rooms->avg('price'), 0) : 0 }}
                                                        VND</h3>
                                                    <p class="text-muted mb-0">Giá trung bình</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rooms List -->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-door-open"></i> Danh sách phòng
                                    </h5>
                                    <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.create', ['building_id' => $building->id]) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="bi bi-plus-circle"></i> Thêm phòng mới
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($building->rooms->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="bi bi-door-closed text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="text-muted mt-3">Chưa có phòng nào</h5>
                                        <p class="text-muted">Hãy thêm phòng đầu tiên cho tòa nhà này</p>
                                        <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.create', ['building_id' => $building->id]) }}"
                                            class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Thêm phòng
                                        </a>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Số phòng</th>
                                                    <th>Diện tích</th>
                                                    <th>Giá thuê</th>
                                                    <th>Tiền cọc</th>
                                                    <th>Sức chứa</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($building->rooms as $room)
                                                    <tr>
                                                        <td><strong>{{ $room->room_number }}</strong></td>
                                                        <td>{{ $room->area }} m²</td>
                                                        <td class="text-success">
                                                            <strong>{{ number_format($room->price, 0) }} VND</strong>
                                                        </td>
                                                        <td>{{ number_format($room->deposit, 0) }} VND</td>
                                                        <td>{{ $room->max_person }} người</td>
                                                        <td>
                                                            @if ($room->status === 'available')
                                                                <span class="badge bg-success">Trống</span>
                                                            @else
                                                                <span class="badge bg-warning">Đã thuê</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.show', $room) }}"
                                                                    class="btn btn-info" title="Xem chi tiết">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.edit', $room) }}"
                                                                    class="btn btn-warning" title="Chỉnh sửa">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                @if (auth()->user()->hasRole('admin'))
                                                                    <form
                                                                        action="{{ route('admin.rooms.destroy', $room) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger"
                                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')"
                                                                            title="Xóa">
                                                                            <i class="bi bi-trash"></i>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
