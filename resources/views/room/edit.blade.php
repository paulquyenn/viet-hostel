<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Chỉnh sửa phòng #{{ $room->room_number }}</h5>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="building_id">Tòa nhà</label>
                                        <select class="form-control" id="building_id" name="building_id" required>
                                            <option value="">Chọn tòa nhà</option>
                                            @foreach ($buildings as $building)
                                                <option value="{{ $building->id }}"
                                                    {{ old('building_id', $room->building_id) == $building->id ? 'selected' : '' }}>
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
                                            value="{{ old('room_number', $room->room_number) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="area">Diện tích (m²)</label>
                                        <input type="number" step="0.1" class="form-control" id="area"
                                            name="area" value="{{ old('area', $room->area) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Giá thuê (VNĐ)</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            value="{{ old('price', $room->price) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="deposit_amount">Tiền đặt cọc (VNĐ)</label>
                                        <input type="number" class="form-control" id="deposit_amount"
                                            name="deposit_amount"
                                            value="{{ old('deposit_amount', $room->deposit_amount) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <select class="form-control" id="status" name="status" required>
                                            @foreach ($statuses as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('status', $room->status) == $key ? 'selected' : '' }}>
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
                                            value="{{ old('max_person', $room->max_person) }}" min="1" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="utilities">Tiện ích</label>
                                        <textarea class="form-control" id="utilities" name="utilities" rows="2">{{ old('utilities', $room->utilities) }}</textarea>
                                        <small class="form-text text-muted">Nhập các tiện ích có trong phòng</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $room->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Images -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label>Hình ảnh hiện tại</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        @if ($room->images->count() > 0)
                                            @foreach ($room->images as $image)
                                                <div class="position-relative border p-2 rounded">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                        alt="Room Image" class="img-thumbnail"
                                                        style="width: 150px; height: 150px; object-fit: cover;">
                                                    <div class="mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="primary_image" value="{{ $image->id }}"
                                                                id="primary_{{ $image->id }}"
                                                                {{ $image->is_primary ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="primary_{{ $image->id }}">
                                                                Ảnh chính
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="delete_images[]" value="{{ $image->id }}"
                                                                id="delete_{{ $image->id }}">
                                                            <label class="form-check-label"
                                                                for="delete_{{ $image->id }}">
                                                                Xóa
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Chưa có hình ảnh nào</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Upload new images -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="images">Thêm hình ảnh mới</label>
                                        <input type="file" class="form-control" id="images" name="images[]"
                                            multiple accept="image/*">
                                        <small class="form-text text-muted">Có thể chọn nhiều hình ảnh (JPG,
                                            PNG)</small>
                                    </div>
                                    <div id="new-image-preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('images');
            const previewContainer = document.getElementById('new-image-preview');

            imageInput.addEventListener('change', function() {
                // Clear previous previews
                previewContainer.innerHTML = '';

                // Create previews for each file
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];

                    // Create preview element
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'position-relative border p-2 rounded';

                    const img = document.createElement('img');
                    img.className = 'img-thumbnail';
                    img.style.width = '150px';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';

                    // Read the file and set the source
                    const reader = new FileReader();
                    reader.onload = (function(image) {
                        return function(e) {
                            image.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);

                    // Add image to preview div
                    previewDiv.appendChild(img);

                    // Add preview to container
                    previewContainer.appendChild(previewDiv);
                }
            });
        });
    </script>
</x-admin-layout>
