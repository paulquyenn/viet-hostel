<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách người dùng</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Vai trò</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item['roles']->count() > 0 ? $item['roles'][0]->name : 'Không có vai trò' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $item) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $item) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($user->hasPages())
                            <div class="mt-4">
                                {{ $user->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
