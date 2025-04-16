<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thêm phòng mới</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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
                                        <label for="deposit_amount">Tiền đặt cọc (VNĐ)</label>
                                        <input type="number" class="form-control" id="deposit_amount"
                                            name="deposit_amount" value="{{ old('deposit_amount') }}" required>
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

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="images">Hình ảnh phòng</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="images" name="images[]"
                                                multiple accept="image/*">
                                        </div>
                                        <small class="form-text text-muted">Có thể chọn nhiều hình ảnh (JPG,
                                            PNG)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div id="image-preview-container" class="d-flex flex-wrap gap-2 mt-2">
                                        <!-- Image previews will be inserted here by JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="primary_image">Ảnh chính</label>
                                        <select class="form-control" id="primary_image" name="primary_image">
                                            <option value="0">Hình ảnh đầu tiên</option>
                                        </select>
                                        <small class="text-muted">Chọn ảnh chính sẽ hiển thị trên danh sách
                                            phòng</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('room.index') }}" class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-primary">Lưu phòng</button>
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
            const previewContainer = document.getElementById('image-preview-container');
            const primaryImageSelect = document.getElementById('primary_image');

            imageInput.addEventListener('change', function() {
                // Clear previous previews and options
                previewContainer.innerHTML = '';

                // Create default option for primary image
                primaryImageSelect.innerHTML = '';
                primaryImageSelect.options.add(new Option('Hình ảnh đầu tiên', 0));

                // Create previews and options for each file
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];

                    // Create preview element
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'position-relative';

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

                    // Add elements to preview
                    previewDiv.appendChild(img);
                    previewContainer.appendChild(previewDiv);

                    // Add option to select primary image
                    primaryImageSelect.options.add(new Option(`Hình ảnh ${i+1}`, i));
                }
            });
        });
    </script>
</x-admin-layout>
