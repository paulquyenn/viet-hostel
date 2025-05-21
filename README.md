<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

# TRO-VIET - Ứng dụng quản lý nhà trọ

## Giới thiệu

TRO-VIET là ứng dụng quản lý nhà trọ được phát triển trên nền tảng Laravel, giúp người dùng dễ dàng quản lý các tòa nhà, phòng trọ và thông tin khách thuê. Ứng dụng hỗ trợ phân cấp địa lý theo tỉnh/thành phố, quận/huyện, và phường/xã, đồng thời cung cấp hệ thống đặt phòng, quản lý hợp đồng và đánh giá phòng trọ.

## Tính năng chính

-   Quản lý tòa nhà và phòng trọ
-   Theo dõi tình trạng phòng (còn trống/đã thuê)
-   Quản lý thông tin phòng (diện tích, giá cả, đặt cọc, tiện ích, số người ở tối đa)
-   Quản lý hình ảnh phòng trọ (hỗ trợ tải lên nhiều hình ảnh)
-   Hệ thống đặt phòng trực tuyến
-   Quản lý hợp đồng thuê phòng (với chữ ký điện tử)
-   Hệ thống đánh giá và nhận xét về phòng trọ
-   Phân cấp địa lý (tỉnh/thành, quận/huyện, phường/xã)
-   Quản lý người dùng và phân quyền (sử dụng Spatie Permission)

## Mô hình dữ liệu

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
-   Điểm đánh giá trung bình

### Đặt phòng (Booking)

-   Người dùng đặt phòng
-   Phòng được đặt
-   Ngày chuyển vào dự kiến
-   Thời hạn thuê
-   Ghi chú
-   Trạng thái đặt phòng

### Hợp đồng (Contract)

-   Số hợp đồng
-   Thông tin đặt phòng
-   Người thuê và chủ nhà
-   Ngày bắt đầu và kết thúc
-   Giá thuê hàng tháng
-   Tiền đặt cọc
-   Điều khoản và điều kiện
-   Đường dẫn tệp hợp đồng
-   Chữ ký điện tử

### Đánh giá (Review)

-   Phòng được đánh giá
-   Người dùng đánh giá
-   Điểm đánh giá
-   Nội dung đánh giá

### Vị trí địa lý

-   Tỉnh/Thành phố (Province)
-   Quận/Huyện (District)
-   Phường/Xã (Ward)

## Yêu cầu hệ thống

-   PHP >= 8.2
-   Laravel 12.x
-   MySQL/SQLite
-   Composer
-   Bun (build tool)

## Cài đặt

1. Clone dự án từ repository:

```bash
git clone <repository-url>
cd tro-viet
```

2. Cài đặt các dependencies:

```bash
composer install
bun install
```

3. Tạo file .env và cấu hình database:

```bash
cp .env.example .env
php artisan key:generate
```

4. Cấu hình database trong file .env

5. Chạy migrations và seeders:

```bash
php artisan migrate --seed
```

6. Liên kết storage để lưu trữ hình ảnh:

```bash
php artisan storage:link
```

7. Khởi chạy ứng dụng:

```bash
php artisan serve
bun run dev
```

## Công nghệ sử dụng

### Backend

-   Laravel 12.x - PHP framework
-   Spatie Permission - Quản lý phân quyền
-   Spatie Query Builder - Xây dựng và tối ưu hóa truy vấn

### Frontend

-   Tailwind CSS - Framework CSS
-   Alpine.js - JavaScript framework
-   Dropzone.js - Upload file
-   Signature Pad - Chữ ký điện tử

### Build Tools

-   Vite - Frontend build tool
-   Bun - JavaScript runtime

## Cấu trúc thư mục

```
app/
  Http/
    Controllers/      # Xử lý request
    Middleware/       # Middleware
    Requests/         # Form requests
    Resources/        # API resources
  Models/             # Eloquent models
  Policies/           # Authorization policies
  Providers/          # Service providers
database/
  migrations/         # Database migrations
  seeders/            # Database seeders
  factories/          # Model factories
resources/
  css/                # CSS files
  js/                 # JavaScript files
  views/              # Blade templates
public/
  storage/            # Public storage (uploaded files)
routes/
  web.php             # Web routes
  api.php             # API routes
```

## Tính năng quản trị

-   Quản lý toàn bộ tòa nhà và phòng trọ
-   Quản lý người dùng và phân quyền
-   Xử lý đặt phòng và ký hợp đồng
-   Quản lý đánh giá

## Tính năng người dùng

-   Tìm kiếm phòng trọ theo nhiều tiêu chí
-   Đặt phòng trực tuyến
-   Quản lý hợp đồng thuê phòng
-   Đánh giá và nhận xét về phòng đã thuê

## Bảo mật và quyền hạn

Hệ thống phân quyền dựa trên Spatie Permission với các vai trò chính:

-   Admin: Toàn quyền quản lý hệ thống
-   Chủ nhà: Quản lý tòa nhà, phòng trọ và hợp đồng
-   Người thuê: Đặt phòng, xem hợp đồng và đánh giá

## Giấy phép

MIT License

Dự án được phát hành dưới giấy phép [MIT](https://opensource.org/licenses/MIT).
