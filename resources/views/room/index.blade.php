{{-- filepath: resources/views/room/index.blade.php --}}
<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách phòng</h3>
                        <div class="card-tools">
                            <a href="{{ route('room.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Thêm phòng mới
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Tòa nhà</th>
                                        <th>Số phòng</th>
                                        <th>Diện tích</th>
                                        <th>Giá thuê</th>
                                        <th>Tiền cọc</th>
                                        <th>Trạng thái</th>
                                        <th>Người tối đa</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rooms as $room)
                                        <tr>
                                            <td>{{ $room->id }}</td>
                                            <td>
                                                @if ($room->primaryImage)
                                                    <img src="{{ asset('storage/' . $room->primaryImage->image_path) }}"
                                                        alt="Room {{ $room->room_number }}" class="img-thumbnail"
                                                        style="max-width: 100px;">
                                                @else
                                                    <span class="text-muted">Không có ảnh</span>
                                                @endif
                                            </td>
                                            <td>{{ $room->building->name ?? 'N/A' }}</td>
                                            <td>{{ $room->room_number }}</td>
                                            <td>{{ number_format($room->area, 1) }} m²</td>
                                            <td>{{ number_format($room->price) }} đ</td>
                                            <td>{{ number_format($room->deposit) }} đ</td>
                                            <td>
                                                @if ($room->status == 0)
                                                    <span class="badge bg-success">Trống</span>
                                                @elseif($room->status == 1)
                                                    <span class="badge bg-primary">Đã thuê</span>
                                                @else
                                                    <span class="badge bg-warning">Đang bảo trì</span>
                                                @endif
                                            </td>
                                            <td>{{ $room->max_person }}</td>
                                            <td>
                                                <a href="{{ route('room.show', $room) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                <a href="{{ route('room.edit', $room) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('room.destroy', $room) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc muốn xóa phòng này?')">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
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
