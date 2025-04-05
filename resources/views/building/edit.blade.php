<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h3 class="card-title">Cập nhật thông tin tòa nhà</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('building.update', $building->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên tòa nhà</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $building->name) }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="province_id" class="form-label">Tỉnh/Thành phố</label>
                                <select class="form-select @error('province_id') is-invalid @enderror" id="province_id"
                                    name="province_id" required>
                                    <option value="" disabled>Chọn Tỉnh/Thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province_id', $building->province_id) == $province->id ? 'selected' : '' }}>
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
                                    name="district_id" required>
                                    <option value="" disabled>Chọn Quận/Huyện</option>
                                    <!-- Districts will be populated by JS -->
                                </select>
                                @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ward_id" class="form-label">Phường/Xã</label>
                                <select class="form-select @error('ward_id') is-invalid @enderror" id="ward_id"
                                    name="ward_id" required>
                                    <option value="" disabled>Chọn Phường/Xã</option>
                                    <!-- Wards will be populated by JS -->
                                </select>
                                @error('ward_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ chi tiết</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address', $building->address) }}"
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
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Lưu thay đổi
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
        const currentDistrict = @json(old('district_id', $building->district_id));
        const currentWard = @json(old('ward_id', $building->ward_id));

        const provinceSelect = document.getElementById('province_id');
        const districtSelect = document.getElementById('district_id');
        const wardSelect = document.getElementById('ward_id');

        // Function to populate districts dropdown
        function populateDistricts(provinceId, selectedDistrictId = null) {
            districtSelect.innerHTML = '<option value="" disabled>Chọn Quận/Huyện</option>';

            const filteredDistricts = district.filter(d => d.province_id == provinceId);
            filteredDistricts.forEach(d => {
                const option = document.createElement('option');
                option.value = d.id;
                option.textContent = d.name;

                if (selectedDistrictId && d.id == selectedDistrictId) {
                    option.selected = true;
                }

                districtSelect.appendChild(option);
            });

            districtSelect.disabled = filteredDistricts.length === 0;
        }

        // Function to populate wards dropdown
        function populateWards(districtId, selectedWardId = null) {
            wardSelect.innerHTML = '<option value="" disabled>Chọn Phường/Xã</option>';

            const filteredWards = ward.filter(w => w.district_id == districtId);
            filteredWards.forEach(w => {
                const option = document.createElement('option');
                option.value = w.id;
                option.textContent = w.name;

                if (selectedWardId && w.id == selectedWardId) {
                    option.selected = true;
                }

                wardSelect.appendChild(option);
            });

            wardSelect.disabled = filteredWards.length === 0;
        }

        // Event listeners
        provinceSelect.addEventListener('change', function() {
            const selectedProvinceId = this.value;
            wardSelect.innerHTML = '<option value="" disabled selected>Chọn Phường/Xã</option>';
            populateDistricts(selectedProvinceId);
        });

        districtSelect.addEventListener('change', function() {
            const selectedDistrictId = this.value;
            populateWards(selectedDistrictId);
        });

        // Initialize with current values
        document.addEventListener('DOMContentLoaded', function() {
            // First populate districts based on selected province
            if (provinceSelect.value) {
                populateDistricts(provinceSelect.value, currentDistrict);
            }

            // Then populate wards based on selected district
            if (currentDistrict) {
                populateWards(currentDistrict, currentWard);
            }
        });
    </script>
</x-admin-layout>
