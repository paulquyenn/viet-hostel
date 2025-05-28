<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h3 class="card-title">Chỉnh sửa người dùng</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Trường Họ và tên -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trường Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trường Mật khẩu -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu (để trống nếu không thay đổi)</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trường Xác nhận mật khẩu -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <!-- Trường Số điện thoại -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trường Địa chỉ -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address', $user->address) }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Vai trò</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" required>
                                    <option value="" disabled>Chọn vai trò</option>
                                    <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Quản trị
                                        viên</option>
                                    <option value="landlord" {{ $user->hasRole('landlord') ? 'selected' : '' }}>Chủ trọ
                                    </option>
                                    <option value="tenant" {{ $user->hasRole('tenant') ? 'selected' : '' }}>Người thuê
                                        trọ</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nút điều hướng -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Cập nhật người dùng
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
