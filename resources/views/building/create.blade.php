<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h3 class="card-title">Thêm tòa nhà mới</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('building.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên tòa nhà</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="province_id" class="form-label">Tỉnh/Thành phố</label>
                                <select class="form-select @error('province_id') is-invalid @enderror" id="province_id"
                                    name="province_id" required>
                                    <option value="" selected disabled>Chọn Tỉnh/Thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="district_id" class="form-label">Quận/Huyện</label>
                                <select class="form-select @error('district_id') is-invalid @enderror" id="district_id"
                                    name="district_id" required disabled>
                                    <option value="" selected disabled>Chọn Quận/Huyện</option>
                                </select>
                                @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ward_id" class="form-label">Phường/Xã</label>
                                <select class="form-select @error('ward_id') is-invalid @enderror" id="ward_id"
                                    name="ward_id" required disabled>
                                    <option value="" selected disabled>Chọn Phường/Xã</option>
                                </select>
                                @error('ward_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ chi tiết</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address') }}"
                                        placeholder="Số nhà, tên đường, thôn/xóm..." required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('building.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-building-add"></i> Tạo tòa nhà
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const province = @json($provinces);
        const district = @json($districts);
        const ward = @json($wards);

        const provinceSelect = document.getElementById('province_id');
        const districtSelect = document.getElementById('district_id');
        const wardSelect = document.getElementById('ward_id');

        provinceSelect.addEventListener('change', function() {
            const selectedProvinceId = this.value;
            districtSelect.innerHTML = '<option value="" selected disabled>Chọn Quận/Huyện</option>';
            wardSelect.innerHTML = '<option value="" selected disabled>Chọn Phường/Xã</option>';
            districtSelect.disabled = false;

            const filteredDistricts = district.filter(d => d.province_id == selectedProvinceId);
            filteredDistricts.forEach(d => {
                const option = document.createElement('option');
                option.value = d.id;
                option.textContent = d.name;
                districtSelect.appendChild(option);
            });
        });

        districtSelect.addEventListener('change', function() {
            const selectedDistrictId = this.value;
            wardSelect.innerHTML = '<option value="" selected disabled>Chọn Phường/Xã</option>';
            wardSelect.disabled = false;

            const filteredWards = ward.filter(w => w.district_id == selectedDistrictId);
            filteredWards.forEach(w => {
                const option = document.createElement('option');
                option.value = w.id;
                option.textContent = w.name;
                wardSelect.appendChild(option);
            });
        });
    </script>
</x-admin-layout>
