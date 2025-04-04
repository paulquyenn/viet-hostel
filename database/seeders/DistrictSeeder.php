<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['name' => 'Thành phố Vinh', 'code' => null, 'province_id' => 1],
            ['name' => 'Thị xã Hoàng Mai', 'code' => null, 'province_id' => 1],
            ['name' => 'Thị xã Thái Hòa', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Diễn Châu', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Yên Thành', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Quỳnh Lưu', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Thanh Chương', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Nghi Lộc', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Đô Lương', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Nam Đàn', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Tân Kỳ', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Nghĩa Đàn', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Quỳ Hợp', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Hưng Nguyên', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Anh Sơn', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Kỳ Sơn', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Tương Dương', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Con Cuông', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Quế Phong', 'code' => null, 'province_id' => 1],
            ['name' => 'Huyện Quỳ Châu', 'code' => null, 'province_id' => 1],
        ];

        foreach ($districts as $district) {
            if (!DB::table('districts')
                ->where('name', $district['name'])
                ->where('code', $district['code'])
                ->where('province_id', $district['province_id'])
                ->exists()) {
                DB::table('districts')->insert($district);
            }
        }
    }
}
