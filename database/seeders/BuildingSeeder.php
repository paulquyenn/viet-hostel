<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get province, district, ward, and user IDs dynamically
        $ngheAnProvince = DB::table('provinces')->where('name', 'Nghệ An')->first();
        $vinhDistrict = DB::table('districts')->where('name', 'Thành phố Vinh')->first();
        $adminUser = DB::table('users')->where('email', 'admin@gmail.com')->first();

        if (!$ngheAnProvince || !$vinhDistrict || !$adminUser) {
            throw new \Exception('Required province, district, or user not found. Please run ProviceSeeder, DistrictSeeder, and UserSeeder first.');
        }

        // Get specific wards we need for the buildings
        $wards = DB::table('wards')
            ->where('district_id', $vinhDistrict->id)
            ->whereIn('name', [
                'Phường Lê Lợi',
                'Phường Hưng Bình',
                'Phường Quang Trung',
                'Phường Trung Đô',
                'Phường Hưng Bình'
            ])
            ->get()
            ->keyBy('name');

        if ($wards->count() < 4) {
            throw new \Exception('Required wards not found. Please run WardSeeder first.');
        }

        $list = [
            [
                'name' => 'Khu trọ sinh viên Hưng Phúc',
                'address' => '123 Lê Lợi',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Lê Lợi']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Đại học Vinh',
                'address' => '456 Nguyễn Thị Minh Khai',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ An Khang',
                'address' => '123 Quang Trung',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Quang Trung']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Hòa Bình',
                'address' => '321 Trần Phú',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Trung Đô']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Thành Công',
                'address' => '123 Nguyễn Văn Cừ',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Phương Nam',
                'address' => '789 Lê Hồng Phong',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Lê Lợi']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Minh Châu',
                'address' => '567 Phan Bội Châu',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Quang Trung']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Thanh Xuân',
                'address' => '234 Nguyễn Thái Học',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Phước An',
                'address' => '345 Lý Thường Kiệt',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Trung Đô']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Tân Tiến',
                'address' => '678 Hai Bà Trưng',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Lê Lợi']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Bình Minh',
                'address' => '890 Trần Hưng Đạo',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Hoàng Gia',
                'address' => '111 Đinh Tiên Hoàng',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Quang Trung']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Vạn Phúc',
                'address' => '222 Ngô Quyền',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Trung Đô']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Đông Phương',
                'address' => '333 Lê Duẩn',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Lê Lợi']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Nam Kỳ',
                'address' => '444 Nguyễn Du',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Phú Quý',
                'address' => '555 Võ Thị Sáu',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Quang Trung']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Hạnh Phúc',
                'address' => '666 Trần Quý Cáp',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Trung Đô']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Kim Liên',
                'address' => '777 Nguyễn Chí Thanh',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Lê Lợi']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Khu trọ Thiên An',
                'address' => '888 Lê Thánh Tông',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $adminUser->id,
            ],
            [
                'name' => 'Nhà trọ Bảo Long',
                'address' => '999 Nguyễn Trãi',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Quang Trung']->id,
                'user_id' => $adminUser->id,
            ]
        ];

        foreach ($list as $item) {
            if (!DB::table('buildings')
                ->where('name', $item['name'])
                ->where('address', $item['address'])
                ->where('province_id', $item['province_id'])
                ->where('district_id', $item['district_id'])
                ->where('ward_id', $item['ward_id'])
                ->where('user_id', $item['user_id'])
                ->exists()) {
                DB::table('buildings')->insert($item);
            }
        }
    }
}
