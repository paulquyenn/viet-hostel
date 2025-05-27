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
        // Get district IDs dynamically
        $districts = DB::table('districts')->whereIn('name', [
            'Thành phố Vinh',
            'Thị xã Hoàng Mai',
            'Huyện Diễn Châu',
            'Huyện Nghi Lộc'
        ])->get()->keyBy('name');

        if ($districts->count() < 4) {
            throw new \Exception('Required districts not found. Please run DistrictSeeder first.');
        }

        $wards = [
            // Wards for Thành phố Vinh
            ['name' => 'Phường Bến Thủy', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Nghi Phong', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Cửa Nam', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Đội Cung', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Đông Vĩnh', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Hà Huy Tập', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Hồng Sơn', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Hưng Bình', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Hưng Chính', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Hưng Dũng', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Hưng Phúc', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Lê Lợi', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Lê Mao', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Nghi Hải', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Nghi Hòa', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Nghi Hương', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Nghi Tân', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Nghi Thu', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Nghi Thủy', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Quán Bàu', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Quang Trung', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Thu Thủy', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Trường Thi', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Trung Đô', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Phường Vinh Tân', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Hưng Đông', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Hưng Hòa', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Hưng Lộc', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Nghi Ân', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Nghi Đức', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Nghi Kim', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Nghi Liên', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Nghi Phú', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],
            ['name' => 'Xã Phúc Đồng', 'code' => null, 'district_id' => $districts['Thành phố Vinh']->id],

            // Wards for Thị xã Hoàng Mai
            ['name' => 'Phường Quỳnh Thiện', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Phường Quỳnh Dị', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Phường Mai Hùng', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Phường Quỳnh Xuân', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Phường Quỳnh Phương', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Xã Quỳnh Lập', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Xã Quỳnh Liên', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Xã Quỳnh Vinh', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Xã Quỳnh Lộc', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],
            ['name' => 'Xã Quỳnh Trang', 'code' => null, 'district_id' => $districts['Thị xã Hoàng Mai']->id],

            // Wards for Huyện Diễn Châu
            ['name' => 'Thị trấn Diễn Châu', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn An', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Bích', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Cát', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Đoài', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Đồng', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Hải', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Hạnh', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Hoa', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Hoàng', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Hùng', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Kim', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Kỷ', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Lâm', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Liên', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Lộc', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Lợi', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Mỹ', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Ngọc', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Nguyên', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Phong', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Phú', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Phúc', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Quảng', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Tân', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Thái', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Thành', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Tháp', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Thịnh', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Thọ', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Trung', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Trường', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Vạn', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Xuân', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],
            ['name' => 'Xã Diễn Yên', 'code' => null, 'district_id' => $districts['Huyện Diễn Châu']->id],

            // Wards for Huyện Nghi Lộc
            ['name' => 'Thị trấn Quán Hành', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Diên Hoa', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Khánh Hợp', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Công Bắc', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Công Nam', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Đồng', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Hưng', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Kiều', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Lâm', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Long', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Mỹ', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Phương', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Quang', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Thạch', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Thiết', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Thuận', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Tiến', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Trung', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Vạn', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Văn', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Xá', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Nghi Yên', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],
            ['name' => 'Xã Thịnh Trường', 'code' => null, 'district_id' => $districts['Huyện Nghi Lộc']->id],

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
