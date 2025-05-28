# TRO-VIET - Hệ thống quản lý nhà trọ thông minh

<p align="center">
  <img src="https://via.placeholder.com/400x100/4154f1/ffffff?text=TRO+VIET" width="400" alt="TRO-VIET Logo">
</p>

<p align="center">
  <strong>Nền tảng kết nối không gian sống lý tưởng</strong><br>
  Hệ thống quản lý nhà trọ toàn diện với giao diện hiện đại và tính năng đa dạng
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-ff2d20?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777bb4?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.4-06b6d4?style=for-the-badge&logo=tailwindcss" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.14-8bc34a?style=for-the-badge&logo=alpine.js" alt="Alpine.js">
  <img src="https://img.shields.io/badge/Vite-6.2-646cff?style=for-the-badge&logo=vite" alt="Vite">
</p>

---

## 📖 Giới thiệu

**TRO-VIET** là một hệ thống quản lý nhà trọ thông minh được phát triển trên nền tảng Laravel framework. Ứng dụng cung cấp giải pháp toàn diện cho việc quản lý tòa nhà, phòng trọ, khách thuê và các hoạt động kinh doanh cho thuê phòng trọ.

### 🎯 Mục tiêu

-   Số hóa quy trình quản lý nhà trọ
-   Tạo nền tảng kết nối chủ trọ và người thuê
-   Cung cấp công cụ quản lý hiệu quả và minh bạch
-   Hỗ trợ quyết định kinh doanh dựa trên dữ liệu

---

## ✨ Tính năng chính

### 🏢 **Quản lý Tòa nhà & Phòng trọ**

-   ✅ Quản lý thông tin tòa nhà (tên, địa chỉ, vị trí địa lý)
-   ✅ Quản lý chi tiết phòng trọ (diện tích, giá cả, tiện ích)
-   ✅ Theo dõi trạng thái phòng realtime (trống/đã thuê/bảo trì)
-   ✅ Hỗ trợ phòng ở ghép với quản lý số lượng người/phòng
-   ✅ Quản lý hình ảnh phòng với drag & drop upload

### 👥 **Hệ thống Người dùng & Phân quyền**

-   ✅ **Admin**: Quản trị toàn hệ thống
-   ✅ **Landlord (Chủ trọ)**: Quản lý tòa nhà và phòng trọ
-   ✅ **Tenant (Người thuê)**: Tìm kiếm và đặt phòng
-   ✅ Phân quyền chi tiết với Spatie Permission
-   ✅ Middleware bảo mật cho từng route

### 📅 **Hệ thống Đặt phòng & Hợp đồng**

-   ✅ Đặt phòng trực tuyến với workflow duyệt
-   ✅ Tạo hợp đồng điện tử tự động
-   ✅ Quản lý chữ ký điện tử
-   ✅ Theo dõi trạng thái hợp đồng (pending/active/expired/terminated)
-   ✅ Xuất file PDF hợp đồng

### ⭐ **Hệ thống Đánh giá & Phản hồi**

-   ✅ Đánh giá phòng trọ (1-5 sao)
-   ✅ Bình luận và chia sẻ trải nghiệm
-   ✅ Tính toán điểm đánh giá trung bình
-   ✅ Hiển thị review từ người thuê thực tế

### 📊 **Dashboard & Báo cáo**

-   ✅ Dashboard admin với thống kê tổng quan
-   ✅ Biểu đồ và metrics realtime
-   ✅ Báo cáo doanh thu và hiệu suất
-   ✅ Quản lý người thuê hiện tại

### 🗺️ **Hệ thống Địa lý**

-   ✅ Phân cấp địa lý 3 cấp: Tỉnh/Thành phố → Quận/Huyện → Phường/Xã
-   ✅ API endpoint cho dropdown địa lý động
-   ✅ Tìm kiếm theo vị trí địa lý

---

## 🏗️ Kiến trúc hệ thống

### **Backend Architecture**

```
├── 🔧 Laravel 12.0 Framework
├── 🛡️ Authentication & Authorization (Spatie Permission)
├── 🗄️ Database Layer (SQLite/MySQL)
├── 📡 RESTful API Endpoints
├── 🎯 MVC Pattern Implementation
└── 📋 Request Validation & Resources
```

### **Frontend Architecture**

```
├── 🎨 TailwindCSS 3.4 (Utility-first CSS)
├── ⚡ Alpine.js 3.14 (Lightweight JS framework)
├── 📱 Responsive Design (Mobile-first)
├── 🔄 Vite 6.2 (Fast build tool)
├── 🖼️ Dropzone.js (File uploads)
└── 📊 Chart.js (Data visualization)
```

---

## 🗃️ Cấu trúc Database

### **Bảng chính**

#### 🏢 **Buildings** (Tòa nhà)

```sql
- id, name, address
- province_id, district_id, ward_id
- user_id (chủ sở hữu)
- timestamps
```

#### 🚪 **Rooms** (Phòng trọ)

```sql
- id, room_number, area, price, deposit
- status (available/occupied), max_person
- utilities, description, building_id
- timestamps
```

#### 👤 **Users** (Người dùng)

```sql
- id, name, email, password
- phone, address
- email_verified_at, remember_token
- timestamps
```

#### 📋 **Bookings** (Đặt phòng)

```sql
- id, user_id, room_id
- desired_move_date, duration, note
- status (pending/approved/rejected/cancelled)
- timestamps
```

#### 📄 **Contracts** (Hợp đồng)

```sql
- id, contract_number, booking_id
- room_id, tenant_id, landlord_id
- start_date, end_date, monthly_rent, deposit_amount
- terms_and_conditions, status, file_path
- signature_path, signed_at, timestamps
```

#### ⭐ **Reviews** (Đánh giá)

```sql
- id, room_id, user_id
- rating (1-5), comment
- timestamps
```

#### 🖼️ **Images & Room_Images** (Hình ảnh)

```sql
Images: id, path, name, size, type, isMain
Room_Images: room_id, image_id (pivot table)
```

### **Hệ thống Địa lý**

```sql
Provinces: id, name, code
Districts: id, name, code, province_id
Wards: id, name, code, district_id
```

### **Hệ thống Phân quyền (Spatie Permission)**

```sql
Roles: id, name, guard_name
Permissions: id, name, guard_name
Model_has_roles: model_id, role_id, model_type
Role_has_permissions: role_id, permission_id
```

---

## 🚀 Cài đặt và Triển khai

### **Yêu cầu hệ thống**

-   **PHP** >= 8.2
-   **Composer** >= 2.0
-   **Node.js** >= 18.0
-   **NPM/Yarn** >= 8.0
-   **Database**: SQLite/MySQL/PostgreSQL

### **Bước 1: Clone project**

```bash
git clone https://github.com/your-repo/tro-viet.git
cd tro-viet
```

### **Bước 2: Cài đặt dependencies**

```bash
# Backend dependencies
composer install

# Frontend dependencies
npm install
```

### **Bước 3: Cấu hình môi trường**

```bash
# Copy file cấu hình
cp .env.example .env

# Generate application key
php artisan key:generate

# Cấu hình database trong .env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### **Bước 4: Thiết lập database**

```bash
# Tạo database SQLite
touch database/database.sqlite

# Chạy migrations
php artisan migrate

# Chạy seeders (dữ liệu mẫu)
php artisan db:seed
```

### **Bước 5: Build assets**

```bash
# Development
npm run dev

# Production
npm run build
```

### **Bước 6: Khởi chạy ứng dụng**

```bash
# Khởi động Laravel server
php artisan serve

# Hoặc sử dụng Vite dev server (trong terminal khác)
npm run dev
```

🎉 **Truy cập ứng dụng tại**: `http://localhost:8000`

---

## 👥 Tài khoản Demo

Sau khi chạy seeders, bạn có thể đăng nhập với các tài khoản sau:

| Vai trò      | Email              | Password | Quyền hạn                  |
| ------------ | ------------------ | -------- | -------------------------- |
| **Admin**    | admin@gmail.com    | 12345678 | Quản trị toàn hệ thống     |
| **Landlord** | landlord@gmail.com | 12345678 | Quản lý tòa nhà, phòng trọ |
| **Tenant**   | tenant@gmail.com   | 12345678 | Tìm kiếm, đặt phòng        |

---

## 🛠️ Cấu trúc thư mục

```
tro-viet/
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/        # API & Web Controllers
│   │   │   ├── 📁 Admin/         # Admin Controllers
│   │   │   ├── Auth/             # Authentication
│   │   │   └── ...
│   │   ├── 📁 Middleware/        # Custom Middleware
│   │   ├── 📁 Requests/          # Form Requests
│   │   └── 📁 Resources/         # API Resources
│   ├── 📁 Models/                # Eloquent Models
│   └── 📁 Providers/             # Service Providers
├── 📁 database/
│   ├── 📁 migrations/            # Database Migrations
│   └── 📁 seeders/               # Database Seeders
├── 📁 resources/
│   ├── 📁 css/                   # Stylesheets
│   ├── 📁 js/                    # JavaScript
│   └── 📁 views/                 # Blade Templates
├── 📁 routes/
│   ├── api.php                   # API Routes
│   ├── web.php                   # Web Routes
│   └── auth.php                  # Auth Routes
└── 📁 public/
    └── 📁 admin/                 # Admin Assets
```

---

## 🎨 Giao diện người dùng

### **Dashboard Admin**

-   📊 Thống kê tổng quan hệ thống
-   👥 Quản lý người dùng và phân quyền
-   🏢 Quản lý tòa nhà và phòng trọ
-   📋 Quản lý đặt phòng và hợp đồng
-   📈 Báo cáo và analytics

### **Giao diện Chủ trọ**

-   🏢 Quản lý tòa nhà sở hữu
-   🚪 Quản lý phòng trọ chi tiết
-   📋 Xử lý đơn đặt phòng
-   📄 Tạo và quản lý hợp đồng
-   👥 Quản lý người thuê hiện tại

### **Giao diện Người thuê**

-   🔍 Tìm kiếm phòng trọ
-   📋 Đặt phòng trực tuyến
-   📄 Xem và ký hợp đồng
-   ⭐ Đánh giá phòng trọ
-   📱 Dashboard cá nhân

---

## 🛣️ Cấu trúc Routes theo Vai trò

Hệ thống routes đã được tổ chức lại theo vai trò để dễ quản lý và bảo mật:

### **🔓 Public Routes**

```http
GET    /                         # Trang chủ
GET    /about                    # Giới thiệu
GET    /contact                  # Liên hệ
```

### **👤 Authenticated Routes (Tất cả user)**

```http
GET    /dashboard                # Dashboard chung
GET    /profile                  # Quản lý profile
GET    /motel                    # Xem danh sách phòng
GET    /motel/{room}             # Chi tiết phòng
GET    /my-reviews               # Đánh giá của tôi
```

### **🏠 Tenant Routes**

```http
GET    /tenant/bookings          # Danh sách booking
POST   /tenant/bookings/{room}   # Tạo booking mới
GET    /tenant/contracts         # Danh sách hợp đồng
POST   /tenant/contracts/{id}/sign # Ký hợp đồng
```

### **🏢 Landlord Routes**

```http
GET    /landlord/buildings       # Quản lý tòa nhà
GET    /landlord/rooms           # Quản lý phòng trọ
GET    /landlord/bookings        # Xem booking
GET    /landlord/tenants         # Danh sách người thuê
```

### **👑 Admin Routes**

```http
GET    /admin/users              # Quản lý user
POST   /admin/bookings/{id}/approve # Duyệt booking
GET    /admin/contracts/create   # Tạo hợp đồng
GET    /admin/tenants/stats      # Thống kê
```

> 📋 **Chi tiết đầy đủ**: Xem file `ROUTES_DOCUMENTATION.md` để biết thêm chi tiết về từng route.

---

## 📡 API Documentation

### **Authentication Endpoints**

```http
POST   /login                    # Đăng nhập
POST   /register                 # Đăng ký
POST   /logout                   # Đăng xuất
POST   /password/reset           # Reset password
```

### **Building & Room Management**

```http
GET    /api/buildings            # Danh sách tòa nhà
POST   /api/buildings            # Tạo tòa nhà mới
PUT    /api/buildings/{id}       # Cập nhật tòa nhà
DELETE /api/buildings/{id}       # Xóa tòa nhà

GET    /api/rooms                # Danh sách phòng
POST   /api/rooms                # Tạo phòng mới
PUT    /api/rooms/{id}           # Cập nhật phòng
DELETE /api/rooms/{id}           # Xóa phòng
```

### **Booking & Contract Management**

```http
GET    /api/bookings             # Danh sách đặt phòng
POST   /api/bookings             # Tạo đặt phòng
PUT    /api/bookings/{id}        # Cập nhật đặt phòng
DELETE /api/bookings/{id}        # Hủy đặt phòng

GET    /api/contracts            # Danh sách hợp đồng
POST   /api/contracts            # Tạo hợp đồng
PUT    /api/contracts/{id}       # Cập nhật hợp đồng
```

### **Geographic Data**

```http
GET    /api/districts?province_id={id}  # Lấy quận/huyện theo tỉnh
GET    /api/wards?district_id={id}      # Lấy phường/xã theo quận
```

### **Review System**

```http
GET    /api/rooms/{id}/reviews   # Danh sách review của phòng
POST   /api/reviews              # Tạo review mới
PUT    /api/reviews/{id}         # Cập nhật review
DELETE /api/reviews/{id}         # Xóa review
```

---

## 🔧 Công nghệ sử dụng

### **Backend Technologies**

| Công nghệ                | Version | Mô tả                       |
| ------------------------ | ------- | --------------------------- |
| **Laravel**              | 12.0    | PHP Framework chính         |
| **Spatie Permission**    | 6.16    | Quản lý roles & permissions |
| **Spatie Query Builder** | 6.3     | API query filtering         |
| **Laravel Breeze**       | 2.3     | Authentication scaffolding  |
| **Pest**                 | 3.7     | Testing framework           |

### **Frontend Technologies**

| Công nghệ       | Version      | Mô tả                       |
| --------------- | ------------ | --------------------------- |
| **TailwindCSS** | 3.4.17       | Utility-first CSS framework |
| **Alpine.js**   | 3.14.9       | Lightweight JS framework    |
| **Vite**        | 6.2.5        | Build tool và dev server    |
| **Dropzone**    | 6.0.0-beta.2 | File upload library         |
| **Chart.js**    | Latest       | Data visualization          |

### **Development Tools**

-   **Laravel Pint** - Code formatting
-   **Laravel Pail** - Log monitoring
-   **Laravel Sail** - Docker development environment
-   **Laravel Tinker** - Interactive shell

---

## 🧪 Testing

### **Chạy Tests**

```bash
# Chạy tất cả tests
php artisan test

# Chạy tests với coverage
php artisan test --coverage

# Chạy specific test file
php artisan test tests/Feature/AuthTest.php
```

### **Test Coverage**

-   ✅ **Unit Tests**: Model validation, business logic
-   ✅ **Feature Tests**: HTTP requests, authentication
-   ✅ **Browser Tests**: End-to-end user workflows

---

## 📈 Performance & Optimization

### **Database Optimization**

-   ✅ Indexed foreign keys
-   ✅ Eager loading relationships
-   ✅ Query optimization với Spatie Query Builder
-   ✅ Database caching strategies

### **Frontend Optimization**

-   ✅ Vite build optimization
-   ✅ TailwindCSS purging unused styles
-   ✅ Image optimization và lazy loading
-   ✅ Alpine.js lightweight interactions

### **Caching Strategy**

-   ✅ Route caching
-   ✅ Config caching
-   ✅ View caching
-   ✅ Permission caching

---

## 🔒 Bảo mật

### **Security Features**

-   ✅ **CSRF Protection**: Tự động với Laravel
-   ✅ **SQL Injection Prevention**: Eloquent ORM
-   ✅ **XSS Protection**: Blade template escaping
-   ✅ **Authentication**: Laravel Breeze
-   ✅ **Authorization**: Role-based access control
-   ✅ **File Upload Security**: Validation và sanitization
-   ✅ **Rate Limiting**: API throttling

### **Best Practices**

-   ✅ Input validation với Form Requests
-   ✅ Password hashing với bcrypt
-   ✅ Secure session management
-   ✅ HTTPS enforcement (production)
-   ✅ Environment variable protection

---

## 🚀 Deployment

### **Production Deployment**

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Build assets
npm run build

# Set permissions
chmod -R 755 storage bootstrap/cache
```

### **Environment Configuration**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tro_viet_production
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

---

## 🤝 Đóng góp

Chúng tôi hoan nghênh mọi đóng góp! Vui lòng đọc [CONTRIBUTING.md](CONTRIBUTING.md) để biết chi tiết.

### **Quy trình đóng góp**

1. **Fork** repository
2. **Tạo branch** cho feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** lên branch (`git push origin feature/AmazingFeature`)
5. **Tạo Pull Request**

### **Coding Standards**

-   PSR-12 coding standard
-   Laravel best practices
-   Comprehensive testing
-   Clear documentation

---

## 📝 License

Dự án này được phân phối dưới **MIT License**. Xem [LICENSE](LICENSE) để biết thêm thông tin.

---

## 👨‍💻 Tác giả

-   **Team TRO-VIET** - _Initial work_ - [GitHub](https://github.com/tro-viet-team)

---

## 📞 Liên hệ

-   **Email**: support@tro-viet.com
-   **Website**: https://tro-viet.com
-   **Facebook**: https://facebook.com/tro.viet.app
-   **Zalo**: 0123456789

---

## 🙏 Acknowledgments

-   Laravel Framework team
-   TailwindCSS team
-   Alpine.js community
-   Spatie team cho các packages tuyệt vời
-   Toàn bộ Laravel community

---

<p align="center">
  <strong>🏠 TRO-VIET - Kết nối không gian sống lý tưởng 🏠</strong><br>
  Made with ❤️ in Vietnam
</p>
