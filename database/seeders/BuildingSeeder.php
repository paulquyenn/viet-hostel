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
        $landlordUser = DB::table('users')->where('email', 'landlord@gmail.com')->first();

        if (!$ngheAnProvince || !$vinhDistrict || !$landlordUser) {
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
                'user_id' => $landlordUser->id,
            ],
            [
                'name' => 'Nhà trọ Đại học Vinh',
                'address' => '456 Nguyễn Thị Minh Khai',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $landlordUser->id,
            ],
            [
                'name' => 'Khu trọ An Khang',
                'address' => '123 Quang Trung',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Quang Trung']->id,
                'user_id' => $landlordUser->id,
            ],
            [
                'name' => 'Nhà trọ Hòa Bình',
                'address' => '321 Trần Phú',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Trung Đô']->id,
                'user_id' => $landlordUser->id,
            ],
            [
                'name' => 'Khu trọ Thành Công',
                'address' => '123 Nguyễn Văn Cừ',
                'province_id' => $ngheAnProvince->id,
                'district_id' => $vinhDistrict->id,
                'ward_id' => $wards['Phường Hưng Bình']->id,
                'user_id' => $landlordUser->id,
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
