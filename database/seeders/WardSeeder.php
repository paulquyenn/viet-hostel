<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = [
            // Wards for Thành phố Vinh (district_id = 1) - Updated
            ['name' => 'Phường Bến Thủy', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Phong', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Cửa Nam', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Đội Cung', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Đông Vĩnh', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Hà Huy Tập', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Hồng Sơn', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Hưng Bình', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Hưng Chính', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Hưng Dũng', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Hưng Phúc', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Lê Lợi', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Lê Mao', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Nghi Hải', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Nghi Hòa', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Nghi Hương', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Nghi Tân', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Nghi Thu', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Nghi Thủy', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Quán Bàu', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Quang Trung', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Thu Thủy', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Trường Thi', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Trung Đô', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Vinh Tân', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Hưng Đông', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Hưng Hòa', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Hưng Lộc', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Ân', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Đức', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Kim', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Liên', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Phú', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Phúc Đồng', 'code' => null, 'district_id' => 1],

            // Wards for Thị xã Hoàng Mai (assuming district_id = 2)
            ['name' => 'Phường Quỳnh Thiện', 'code' => null, 'district_id' => 2],
            ['name' => 'Phường Quỳnh Dị', 'code' => null, 'district_id' => 2],
            ['name' => 'Phường Mai Hùng', 'code' => null, 'district_id' => 2],
            ['name' => 'Phường Quỳnh Xuân', 'code' => null, 'district_id' => 2],
            ['name' => 'Phường Quỳnh Phương', 'code' => null, 'district_id' => 2],
            ['name' => 'Xã Quỳnh Lập', 'code' => null, 'district_id' => 2],
            ['name' => 'Xã Quỳnh Liên', 'code' => null, 'district_id' => 2],
            ['name' => 'Xã Quỳnh Vinh', 'code' => null, 'district_id' => 2],
            ['name' => 'Xã Quỳnh Lộc', 'code' => null, 'district_id' => 2],
            ['name' => 'Xã Quỳnh Trang', 'code' => null, 'district_id' => 2],

            // Wards for Huyện Diễn Châu (assuming district_id = 4)
            ['name' => 'Thị trấn Diễn Châu', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn An', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Bích', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Cát', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Đoài', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Đồng', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Hải', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Hạnh', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Hoa', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Hoàng', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Hùng', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Kim', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Kỷ', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Lâm', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Liên', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Lộc', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Lợi', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Mỹ', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Ngọc', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Nguyên', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Phong', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Phú', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Phúc', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Quảng', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Tân', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Thái', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Thành', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Tháp', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Thịnh', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Thọ', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Trung', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Trường', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Vạn', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Xuân', 'code' => null, 'district_id' => 4],
            ['name' => 'Xã Diễn Yên', 'code' => null, 'district_id' => 4],

            // Wards for Huyện Nghi Lộc (assuming district_id = 8)
            ['name' => 'Thị trấn Quán Hành', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Diên Hoa', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Khánh Hợp', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Công Bắc', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Công Nam', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Đồng', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Hưng', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Kiều', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Lâm', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Long', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Mỹ', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Phương', 'code' => null, 'district_id' => 8],

            ['name' => 'Xã Nghi Quang', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Thạch', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Thiết', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Thuận', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Tiến', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Trung', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Vạn', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Văn', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Xá', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Nghi Yên', 'code' => null, 'district_id' => 8],
            ['name' => 'Xã Thịnh Trường', 'code' => null, 'district_id' => 8],

            // Add other wards for other districts here, following the pattern:
            // ['name' => 'Ward Name', 'code' => null, 'district_id' => X],
            // Ensure X is the correct foreign key for the district.
        ];

        foreach ($wards as $ward) {
            // Check if the ward already exists to avoid duplicates
            if (!DB::table('wards')
                ->where('name', $ward['name'])
                ->where('district_id', $ward['district_id'])
                ->exists()) {
                DB::table('wards')->insert($ward);
            }
        }
    }
}
