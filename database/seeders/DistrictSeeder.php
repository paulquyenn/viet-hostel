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
        // Get the Nghệ An province ID dynamically
        $ngheAnProvince = DB::table('provinces')->where('name', 'Nghệ An')->first();

        if (!$ngheAnProvince) {
            throw new \Exception('Nghệ An province not found. Please run ProviceSeeder first.');
        }

        $districts = [
            ['name' => 'Thành phố Vinh', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Thị xã Hoàng Mai', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Thị xã Thái Hòa', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Diễn Châu', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Yên Thành', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Quỳnh Lưu', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Thanh Chương', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Nghi Lộc', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Đô Lương', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Nam Đàn', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Tân Kỳ', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Nghĩa Đàn', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Quỳ Hợp', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Hưng Nguyên', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Anh Sơn', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Kỳ Sơn', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Tương Dương', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Con Cuông', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Quế Phong', 'code' => null, 'province_id' => $ngheAnProvince->id],
            ['name' => 'Huyện Quỳ Châu', 'code' => null, 'province_id' => $ngheAnProvince->id],
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
