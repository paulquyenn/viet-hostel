<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['name' => 'Nghệ An', 'code' => null],
            ['name' => 'Hà Nội', 'code' => null],
            ['name' => 'Hồ Chí Minh', 'code' => null],
            ['name' => 'Đà Nẵng', 'code' => null],
            ['name' => 'Hải Phòng', 'code' => null],
            ['name' => 'Cần Thơ', 'code' => null],
            ['name' => 'An Giang', 'code' => null],
            ['name' => 'Bà Rịa - Vũng Tàu', 'code' => null],
            ['name' => 'Bắc Giang', 'code' => null],
            ['name' => 'Bắc Kạn', 'code' => null],
            ['name' => 'Bạc Liêu', 'code' => null],
            ['name' => 'Bắc Ninh', 'code' => null],
            ['name' => 'Bến Tre', 'code' => null],
            ['name' => 'Bình Định', 'code' => null],
            ['name' => 'Bình Dương', 'code' => null],
            ['name' => 'Bình Phước', 'code' => null],
            ['name' => 'Bình Thuận', 'code' => null],
            ['name' => 'Cà Mau', 'code' => null],
            ['name' => 'Cao Bằng', 'code' => null],
            ['name' => 'Đắk Lắk', 'code' => null],
            ['name' => 'Đắk Nông', 'code' => null],
            ['name' => 'Điện Biên', 'code' => null],
            ['name' => 'Đồng Nai', 'code' => null],
            ['name' => 'Đồng Tháp', 'code' => null],
            ['name' => 'Gia Lai', 'code' => null],
            ['name' => 'Hà Giang', 'code' => null],
            ['name' => 'Hà Nam', 'code' => null],
            ['name' => 'Hà Tĩnh', 'code' => null],
            ['name' => 'Hải Dương', 'code' => null],
            ['name' => 'Hậu Giang', 'code' => null],
            ['name' => 'Hòa Bình', 'code' => null],
            ['name' => 'Hưng Yên', 'code' => null],
            ['name' => 'Khánh Hòa', 'code' => null],
            ['name' => 'Kiên Giang', 'code' => null],
            ['name' => 'Kon Tum', 'code' => null],
            ['name' => 'Lai Châu', 'code' => null],
            ['name' => 'Lâm Đồng', 'code' => null],
            ['name' => 'Lạng Sơn', 'code' => null],
            ['name' => 'Lào Cai', 'code' => null],
            ['name' => 'Long An', 'code' => null],
            ['name' => 'Nam Định', 'code' => null],
            ['name' => 'Ninh Bình', 'code' => null],
            ['name' => 'Ninh Thuận', 'code' => null],
            ['name' => 'Phú Thọ', 'code' => null],
            ['name' => 'Phú Yên', 'code' => null],
            ['name' => 'Quảng Bình', 'code' => null],
            ['name' => 'Quảng Nam', 'code' => null],
            ['name' => 'Quảng Ngãi', 'code' => null],
            ['name' => 'Quảng Ninh', 'code' => null],
            ['name' => 'Quảng Trị', 'code' => null],
            ['name' => 'Sóc Trăng', 'code' => null],
            ['name' => 'Sơn La', 'code' => null],
            ['name' => 'Tây Ninh', 'code' => null],
            ['name' => 'Thái Bình', 'code' => null],
            ['name' => 'Thái Nguyên', 'code' => null],
            ['name' => 'Thanh Hóa', 'code' => null],
            ['name' => 'Thừa Thiên Huế', 'code' => null],
            ['name' => 'Tiền Giang', 'code' => null],
            ['name' => 'Trà Vinh', 'code' => null],
            ['name' => 'Tuyên Quang', 'code' => null],
            ['name' => 'Vĩnh Long', 'code' => null],
            ['name' => 'Vĩnh Phúc', 'code' => null],
            ['name' => 'Yên Bái', 'code' => null]
        ];

        foreach ($provinces as $province) {
            if(!DB::table('provinces')
            ->where('name', $province['name'])
            ->where('code', $province['code'])
            ->exists()) {
                DB::table('provinces')->insert($province);
            };
        }
    }
}
