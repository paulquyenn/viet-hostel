<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thêm phòng mới</h5>
                    </div>

                    <div class="card-body">
                        <x-room-image :route="route('image.store')" :name="'room_id'" :id="$room_id['id'] ?? null" />
                        <form
                            action="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="image_ids" id="image_ids">
                            <script>
                                // Mảng lưu trữ ID ảnh đã tải lên
                                let uploadedImageIds = [];

                                document.addEventListener('DOMContentLoaded', function() {
                                    // Lắng nghe sự kiện khi ảnh được tải lên thành công
                                    document.addEventListener('imagesUploaded', function(event) {
                                        // Thêm ID ảnh mới vào mảng
                                        if (event.detail && event.detail.imageIds) {
                                            uploadedImageIds = uploadedImageIds.concat(event.detail.imageIds);
                                            // Cập nhật input ẩn
                                            document.getElementById('image_ids').value = JSON.stringify(uploadedImageIds);
                                            console.log('Uploaded image IDs updated:', uploadedImageIds);
                                        }
                                    });

                                    // Cập nhật input ẩn khi form được gửi
                                    const form = document.querySelector(
                                        'form[action="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.store') }}"]'
                                        );
                                    form.addEventListener('submit', function() {
                                        // Lấy giá trị từ input ẩn trong dropzone nếu có
                                        const dropzoneInput = document.getElementById('uploaded_image_ids');
                                        if (dropzoneInput && dropzoneInput.value) {
                                            try {
                                                const dropzoneImageIds = JSON.parse(dropzoneInput.value);
                                                // Hợp nhất với ID đã thu thập
                                                uploadedImageIds = [...new Set([...uploadedImageIds, ...dropzoneImageIds])];
                                            } catch (e) {
                                                console.error('Error parsing dropzone image IDs:', e);
                                            }
                                        }

                                        document.getElementById('image_ids').value = JSON.stringify(uploadedImageIds);
                                        console.log('Final image IDs:', uploadedImageIds);
                                    });
                                });
                            </script>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="building_id">Tòa nhà</label>
                                        <select class="form-control" id="building_id" name="building_id" required>
                                            <option value="">Chọn tòa nhà</option>
                                            @foreach ($buildings as $building)
                                                <option value="{{ $building->id }}"
                                                    {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                                    {{ $building->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="room_number">Số phòng</label>
                                        <input type="text" class="form-control" id="room_number" name="room_number"
                                            value="{{ old('room_number') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="area">Diện tích (m²)</label>
                                        <input type="number" step="0.1" class="form-control" id="area"
                                            name="area" value="{{ old('area') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Giá thuê (VNĐ)</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            value="{{ old('price') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="deposit">Tiền đặt cọc (VNĐ)</label>
                                        <input type="number" class="form-control" id="deposit" name="deposit"
                                            value="{{ old('deposit') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <select class="form-control" id="status" name="status" required>
                                            @foreach ($status as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('status') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_person">Số người tối đa</label>
                                        <input type="number" class="form-control" id="max_person" name="max_person"
                                            value="{{ old('max_person', 1) }}" min="1" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="utilities">Tiện ích</label>
                                        <textarea class="form-control" id="utilities" name="utilities" rows="2">{{ old('utilities') }}</textarea>
                                        <small class="form-text text-muted">Nhập các tiện ích có trong phòng</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route((auth()->user()->hasRole('admin') ? 'admin' : 'landlord') . '.rooms.index') }}"
                                    class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-primary">Lưu phòng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-admin-layout>
