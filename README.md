<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

# TRO-VIET - Ứng dụng quản lý nhà trọ

## Giới thiệu

TRO-VIET là ứng dụng quản lý nhà trọ được phát triển trên nền tảng Laravel, giúp người dùng dễ dàng quản lý các tòa nhà, phòng trọ và thông tin khách thuê. Ứng dụng hỗ trợ phân cấp địa lý theo tỉnh/thành phố, quận/huyện, và phường/xã, giúp việc tìm kiếm và quản lý trở nên thuận tiện hơn.

## Tính năng chính

-   Quản lý tòa nhà và phòng trọ
-   Theo dõi tình trạng phòng (còn trống/đã thuê)
-   Quản lý thông tin phòng (diện tích, giá cả, đặt cọc, tiện ích)
-   Quản lý hình ảnh phòng trọ
-   Phân cấp địa lý (tỉnh/thành, quận/huyện, phường/xã)
-   Quản lý người dùng và phân quyền

## Cấu trúc cơ sở dữ liệu

### Tòa nhà (Building)

-   Tên tòa nhà
-   Địa chỉ
-   Thông tin vị trí (phường/xã, quận/huyện, tỉnh/thành)
-   Chủ sở hữu (người dùng)

### Phòng trọ (Room)

-   Số phòng
-   Diện tích (m²)
-   Giá thuê
-   Tiền đặt cọc
-   Trạng thái (còn trống/đã thuê)
-   Số người ở tối đa
-   Tiện ích
-   Mô tả
-   Hình ảnh phòng trọ

### Vị trí địa lý

-   Tỉnh/Thành phố (Province)
-   Quận/Huyện (District)
-   Phường/Xã (Ward)

## Yêu cầu hệ thống

-   PHP >= 8.1
-   Laravel 12.x
-   MySQL
-   Composer
-   Bun

## Cài đặt

1. Clone dự án từ repository:

```
git clone <repository-url>
cd tro-viet
```

2. Cài đặt các dependencies:

```
composer install
bun install
```

3. Tạo file .env và cấu hình database:

```
cp .env.example .env
php artisan key:generate
```

4. Cấu hình database trong file .env

5. Chạy migrations và seeders:

```
php artisan migrate --seed
```

6. Khởi chạy ứng dụng:

```
php artisan serve
bun run dev
```

## Phát triển

Dự án sử dụng các công nghệ:

-   Laravel (Backend)
-   Tailwind CSS (Frontend styling)
-   Bootstrap 5.x (Frontend styling admin)
-   Vite (Frontend build tool)

## Giấy phép

Dự án được phát hành dưới giấy phép [MIT](https://opensource.org/licenses/MIT).
