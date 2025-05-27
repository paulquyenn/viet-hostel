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
        $list = [
            [
                'name' => 'Khu trọ sinh viên Hưng Phúc',
                'address' => '123 Lê Lợi',
                'province_id' => 1,
                'district_id' => 1,
                'ward_id' => 12,
                'user_id' => 1,
            ],
            [
                'name' => 'Nhà trọ Đại học Vinh',
                'address' => '456 Nguyễn Thị Minh Khai',
                'province_id' => 1,
                'district_id' => 1,
                'ward_id' => 8,
                'user_id' => 1,
            ],
            [
                'name' => 'Khu trọ An Khang',
                'address' => '123 Quang Trung',
                'province_id' => 1,
                'district_id' => 1,
                'ward_id' => 3,
                'user_id' => 1,
            ],
            [
                'name' => 'Nhà trọ Hòa Bình',
                'address' => '321 Trần Phú',
                'province_id' => 1,
                'district_id' => 1,
                'ward_id' => 23,
                'user_id' => 1,
            ],
            [
                'name' => 'Khu trọ Thành Công',
                'address' => '123 Nguyễn Văn Cừ',
                'province_id' => 1,
                'district_id' => 1,
                'ward_id' => 8,
                'user_id' => 1,
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
