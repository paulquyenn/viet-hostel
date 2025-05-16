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
-   Quản lý yêu cầu thuê phòng và hợp đồng
-   Theo dõi thanh toán tiền thuê phòng
-   Hệ thống thông báo cho người dùng

## Quản lý yêu cầu thuê phòng và hợp đồng

### Quy trình thuê phòng

1. Khách thuê tìm kiếm và chọn phòng trọ phù hợp
2. Người thuê gửi yêu cầu thuê phòng (RentalRequest)
3. Chủ trọ xem xét và phê duyệt yêu cầu
4. Hệ thống tạo hợp đồng (Contract) dựa trên yêu cầu được chấp nhận
5. Cả người thuê và chủ trọ ký hợp đồng (ký điện tử)
6. Khi hợp đồng được kích hoạt, trạng thái phòng tự động cập nhật thành "Đã thuê"
7. Hệ thống tạo các khoản thanh toán định kỳ theo hợp đồng

### Quản lý thanh toán

-   Tự động tạo các khoản thanh toán hàng tháng dựa trên ngày thanh toán trong hợp đồng
-   Gửi thông báo cho người thuê trước khi đến hạn thanh toán (3 ngày và 1 ngày)
-   Gửi thông báo khi khoản thanh toán quá hạn
-   Theo dõi và quản lý trạng thái thanh toán

### Quản lý hợp đồng

-   Tự động cập nhật trạng thái hợp đồng hết hạn
-   Cập nhật trạng thái phòng khi hợp đồng hết hạn
-   Hỗ trợ gia hạn hợp đồng
-   Lọc và tìm kiếm hợp đồng theo nhiều tiêu chí

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

### Yêu cầu thuê phòng (RentalRequest)

-   Người thuê
-   Phòng được yêu cầu
-   Ngày bắt đầu và kết thúc dự kiến
-   Tin nhắn/Ghi chú
-   Trạng thái (đang chờ, chấp nhận, từ chối)
-   Lý do từ chối (nếu có)

### Hợp đồng (Contract)

-   Mã hợp đồng
-   Phòng trọ
-   Người thuê
-   Chủ trọ
-   Yêu cầu thuê liên quan (nếu có)
-   Ngày bắt đầu và kết thúc
-   Tiền thuê hàng tháng
-   Tiền đặt cọc
-   Ngày thanh toán hàng tháng
-   Điều khoản và điều kiện
-   Trạng thái (chờ ký, đang hoạt động, hết hạn, chấm dứt)
-   Lý do chấm dứt (nếu có)
-   Thông tin ký kết (thời gian, trạng thái)

### Thanh toán (Payment)

-   Hợp đồng liên quan
-   Số tiền
-   Kỳ thanh toán (từ ngày đến ngày)
-   Ngày đến hạn
-   Phương thức thanh toán
-   Trạng thái (chờ thanh toán, đã thanh toán)
-   Thời gian thanh toán
-   Người tạo khoản thanh toán
-   Người thanh toán

### Vị trí địa lý

-   Tỉnh/Thành phố (Province)
-   Quận/Huyện (District)
-   Phường/Xã (Ward)

## Các lệnh tự động

Hệ thống sử dụng các lệnh tự động (commands) để thực hiện các tác vụ định kỳ:

1. `app:update-expired-contracts` - Kiểm tra và cập nhật trạng thái các hợp đồng đã hết hạn (chạy hàng ngày lúc 00:00)
2. `app:check-upcoming-payments` - Kiểm tra và gửi thông báo cho các khoản thanh toán sắp đến hạn (chạy hàng ngày lúc 08:00)

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
