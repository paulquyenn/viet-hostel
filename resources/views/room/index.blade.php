<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách phòng</h3>
                        <div class="card-tools">
                            <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.create') }}"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Thêm phòng mới
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tòa nhà</th>
                                        <th>Số phòng</th>
                                        <th>Diện tích</th>
                                        <th>Giá thuê</th>
                                        <th>Tiền cọc</th>
                                        <th>Trạng thái</th>
                                        <th>Sức chứa (hiện tại/tối đa)</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rooms as $room)
                                        <tr>
                                            <td>{{ $room->id }}</td>
                                            <td>{{ $room->building->name ?? 'N/A' }}</td>
                                            <td>{{ $room->room_number }}</td>
                                            <td>{{ number_format($room->area, 1) }} m²</td>
                                            <td>{{ number_format($room->price) }} đ</td>
                                            <td>{{ number_format($room->deposit) }} đ</td>
                                            <td>
                                                @if ($room->status === 'available')
                                                    <span class="badge bg-success">{{ $room->status_text }}</span>
                                                @elseif ($room->has_available_space)
                                                    <span class="badge bg-warning">{{ $room->status_text }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $room->status_text }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $room->current_tenants_count }}/{{ $room->max_person }}
                                                @if ($room->has_available_space)
                                                    <small class="text-success">(còn
                                                        {{ $room->available_spots }})</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.show', $room) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.edit', $room) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <form action="{{ route('admin.rooms.destroy', $room) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Bạn có chắc muốn xóa phòng này?')">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Không có phòng nào</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $rooms->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
