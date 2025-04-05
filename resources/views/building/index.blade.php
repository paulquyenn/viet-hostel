<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách tòa nhà</h3>
                        <div class="card-tools">
                            <a href="{{ route('building.create') }}" class="btn btn-primary btn-sm">
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
                                        <td>{{ $building->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('building.edit', $building) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('building.destroy', $building) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tòa nhà này?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- @if ($buildings->hasPages())
                            <div class="mt-4">
                                {{ $buildings->links() }}
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
