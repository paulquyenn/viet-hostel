@role('admin')
    <x-admin-layout>
        <div class="pagetitle">
            <h1>Dashboard Admin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="card-title text-white mb-2">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Chào mừng, {{ auth()->user()->name }}
                                    </h3>
                                    <p class="mb-0 opacity-75">
                                        Quản lý toàn diện hệ thống Trọ Việt - Nơi kết nối không gian sống lý tưởng
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="admin-icon-wrapper">
                                        <i class="bi bi-gear-wide-connected display-4 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary bg-gradient">
                                    <i class="bi bi-people text-white"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="stat-number">{{ \App\Models\User::count() }}</div>
                                    <div class="stat-label">Tổng người dùng</div>
                                </div>
                            </div>
                            <div class="stat-progress mt-3">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                                <small class="text-muted mt-1">Tất cả người dùng đã đăng ký</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-warning bg-gradient">
                                    <i class="bi bi-person-badge text-white"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="stat-number">{{ \App\Models\User::role('landlord')->count() }}</div>
                                    <div class="stat-label">Chủ trọ</div>
                                </div>
                            </div>
                            <div class="stat-progress mt-3">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-warning"
                                        style="width: {{ (\App\Models\User::role('landlord')->count() / max(\App\Models\User::count(), 1)) * 100 }}%">
                                    </div>
                                </div>
                                <small
                                    class="text-muted mt-1">{{ number_format((\App\Models\User::role('landlord')->count() / max(\App\Models\User::count(), 1)) * 100, 1) }}%
                                    tổng người dùng</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-success bg-gradient">
                                    <i class="bi bi-person-check text-white"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="stat-number">{{ \App\Models\User::role('tenant')->count() }}</div>
                                    <div class="stat-label">Người thuê</div>
                                </div>
                            </div>
                            <div class="stat-progress mt-3">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ (\App\Models\User::role('tenant')->count() / max(\App\Models\User::count(), 1)) * 100 }}%">
                                    </div>
                                </div>
                                <small
                                    class="text-muted mt-1">{{ number_format((\App\Models\User::role('tenant')->count() / max(\App\Models\User::count(), 1)) * 100, 1) }}%
                                    tổng người dùng</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-info bg-gradient">
                                    <i class="bi bi-building text-white"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="stat-number">{{ \App\Models\Building::count() }}</div>
                                    <div class="stat-label">Tòa nhà</div>
                                </div>
                            </div>
                            <div class="stat-progress mt-3">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-info" style="width: 85%"></div>
                                </div>
                                <small class="text-muted mt-1">Tổng tòa nhà trong hệ thống</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Recent Activity -->
            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-graph-up me-2 text-primary"></i>
                                Thống kê hoạt động
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="metric-card text-center p-3 bg-light rounded">
                                        <i class="bi bi-door-open display-6 text-primary mb-2"></i>
                                        <h4 class="mb-1">{{ \App\Models\Room::count() }}</h4>
                                        <small class="text-muted">Tổng phòng trọ</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric-card text-center p-3 bg-light rounded">
                                        <i class="bi bi-calendar-check display-6 text-success mb-2"></i>
                                        <h4 class="mb-1">{{ \App\Models\Booking::count() }}</h4>
                                        <small class="text-muted">Đặt phòng</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric-card text-center p-3 bg-light rounded">
                                        <i class="bi bi-file-earmark-text display-6 text-warning mb-2"></i>
                                        <h4 class="mb-1">{{ \App\Models\Contract::count() }}</h4>
                                        <small class="text-muted">Hợp đồng</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-clock-history me-2 text-primary"></i>
                                Hoạt động gần đây
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="activity-feed">
                                <div class="activity-item d-flex mb-3">
                                    <div class="activity-icon bg-success">
                                        <i class="bi bi-person-plus-fill text-white"></i>
                                    </div>
                                    <div class="activity-content ms-3">
                                        <div class="fw-semibold">Người dùng mới đăng ký</div>
                                        <small class="text-muted">5 phút trước</small>
                                    </div>
                                </div>
                                <div class="activity-item d-flex mb-3">
                                    <div class="activity-icon bg-primary">
                                        <i class="bi bi-building-add text-white"></i>
                                    </div>
                                    <div class="activity-content ms-3">
                                        <div class="fw-semibold">Tòa nhà mới được thêm</div>
                                        <small class="text-muted">1 giờ trước</small>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-icon bg-warning">
                                        <i class="bi bi-calendar-check text-white"></i>
                                    </div>
                                    <div class="activity-content ms-3">
                                        <div class="fw-semibold">Đặt phòng mới</div>
                                        <small class="text-muted">2 giờ trước</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Custom Styles -->
        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .stat-card {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
            }

            .stat-number {
                font-size: 1.75rem;
                font-weight: 700;
                color: #2c3e50;
            }

            .stat-label {
                font-size: 0.875rem;
                color: #6c757d;
                font-weight: 500;
            }

            .activity-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
            }

            .metric-card {
                transition: transform 0.2s ease;
            }

            .metric-card:hover {
                transform: scale(1.05);
            }
        </style>
    </x-admin-layout>
@endrole

@role('landlord')
    <x-landlord-layout>
        <div class="pagetitle">
            <h1>Trang quản lý</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Thống kê của chủ trọ -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Chào mừng đến với Trọ Việt</h5>
                            <p>Quản lý các nhà trọ, phòng trọ và người thuê của bạn</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Tòa nhà</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\Building::where('user_id', auth()->id())->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Phòng trọ</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-door-open"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\Room::whereHas('building', function ($q) {
                                        $q->where('user_id', auth()->id());
                                    })->count() }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Phòng trống</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-unlock"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\Room::whereHas('building', function ($q) {
                                        $q->where('user_id', auth()->id());
                                    })->where('status', 'available')->count() }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Phòng đã thuê</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-lock"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\Room::whereHas('building', function ($q) {
                                        $q->where('user_id', auth()->id());
                                    })->where('status', 'occupied')->count() }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách tòa nhà -->
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Tòa nhà của bạn <span>| Gần đây</span></h5>

                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">Phòng</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\Building::where('user_id', auth()->id())->latest()->take(5)->get() as $building)
                                        <tr>
                                            <td>{{ $building->name }}</td>
                                            <td>{{ $building->full_address }}</td>
                                            <td>{{ $building->rooms->count() }}</td>
                                            <td>
                                                <a href="{{ route('building.show', $building) }}"
                                                    class="btn btn-sm btn-primary">Xem</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
    </x-landlord-layout>
@endrole

@role('tenant')
    <x-tenant-layout>
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
            <!-- Hero Section with Enhanced Design -->
            <div class="relative overflow-hidden bg-white">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
                <div class="absolute inset-0 bg-black opacity-50"></div>

                <!-- Background Image/Pattern -->
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M20 20c0 11.046-8.954 20-20 20v20h40V20H20z\'/%3E%3C/g%3E%3C/svg%3E');">
                </div>

                <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <!-- Welcome Badge -->
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white text-sm font-medium mb-6">
                            <i class="bi bi-house-heart mr-2"></i>
                            Chào mừng {{ auth()->user()->name }}
                        </div>

                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                            Trải nghiệm sống
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                                tuyệt vời
                            </span>
                            <br>cùng Trọ Việt
                        </h1>

                        <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                            Nền tảng quản lý nhà trọ hiện đại, kết nối bạn với không gian sống lý tưởng và cung cấp trải
                            nghiệm thuê trọ hoàn hảo
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('tenant.contracts.index') }}"
                                class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                                <i class="bi bi-file-earmark-text mr-2"></i>
                                Hợp đồng của tôi
                            </a>
                            <a href="{{ route('tenant.bookings.index') }}"
                                class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transition-all duration-300">
                                <i class="bi bi-calendar-check mr-2"></i>
                                Đặt phòng của tôi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="absolute top-20 left-10 w-20 h-20 bg-yellow-400 rounded-full opacity-20 animate-bounce"></div>
                <div class="absolute bottom-20 right-10 w-16 h-16 bg-purple-400 rounded-full opacity-20 animate-pulse">
                </div>
            </div>

            <!-- Features Section with Modern Cards -->
            <div class="py-20 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Section Header -->
                    <div class="text-center mb-16">
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-600 text-sm font-medium mb-4">
                            <i class="bi bi-stars mr-2"></i>
                            Tính năng dành cho bạn
                        </div>
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">
                            Quản lý cuộc sống
                            <span class="text-blue-600">thông minh</span>
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            Trọ Việt cung cấp đầy đủ các công cụ hiện đại để bạn quản lý việc thuê trọ một cách dễ dàng và
                            hiệu quả
                        </p>
                    </div>

                    <!-- Feature Cards Grid -->
                    <div class="grid md:grid-cols-2 gap-8 mb-16">
                        <!-- Contract Management -->
                        <div class="feature-card group">
                            <div class="feature-icon bg-gradient-to-br from-blue-500 to-blue-600">
                                <i class="bi bi-file-earmark-text text-white text-2xl"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">Quản lý hợp đồng</h3>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Xem chi tiết hợp đồng, theo dõi ngày hết hạn và các điều khoản quan trọng.
                                    Nhận thông báo tự động về các mốc thời gian quan trọng.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Theo dõi thời hạn hợp đồng
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Ký hợp đồng điện tử
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Lưu trữ an toàn
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Online Payment -->
                        <div class="feature-card group">
                            <div class="feature-icon bg-gradient-to-br from-green-500 to-green-600">
                                <i class="bi bi-credit-card text-white text-2xl"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">Thanh toán online</h3>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Thanh toán tiền trọ, điện nước và các dịch vụ khác một cách nhanh chóng,
                                    an toàn với nhiều phương thức thanh toán.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Đa dạng phương thức
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Bảo mật cao
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Lịch sử giao dịch
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Issue Reporting -->
                        <div class="feature-card group">
                            <div class="feature-icon bg-gradient-to-br from-orange-500 to-orange-600">
                                <i class="bi bi-exclamation-triangle text-white text-2xl"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">Báo cáo sự cố</h3>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Dễ dàng báo cáo các vấn đề trong phòng trọ và theo dõi tiến độ xử lý
                                    từ chủ trọ theo thời gian thực.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Báo cáo nhanh chóng
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Theo dõi tiến độ
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Hình ảnh minh họa
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Smart Notifications -->
                        <div class="feature-card group">
                            <div class="feature-icon bg-gradient-to-br from-purple-500 to-purple-600">
                                <i class="bi bi-bell text-white text-2xl"></i>
                            </div>
                            <div class="feature-content">
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">Thông báo thông minh</h3>
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Nhận thông báo tự động về thanh toán, ngày hết hạn hợp đồng và
                                    các thông tin quan trọng khác qua email và SMS.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Nhắc nhở tự động
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Đa kênh thông báo
                                    </li>
                                    <li class="flex items-center">
                                        <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                                        Tùy chỉnh linh hoạt
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section with Modern Design -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
                        <div>
                            <h2 class="text-4xl font-bold text-white mb-6">
                                Cần hỗ trợ?
                                <span class="block text-2xl font-normal text-gray-300 mt-2">
                                    Chúng tôi luôn sẵn sàng giúp đỡ
                                </span>
                            </h2>
                            <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                                Đội ngũ hỗ trợ chuyên nghiệp của Trọ Việt luôn sẵn sàng giải đáp mọi thắc mắc
                                và hỗ trợ bạn 24/7 với các vấn đề liên quan đến nhà trọ.
                            </p>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('contact') }}"
                                    class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                                    <i class="bi bi-headset mr-2"></i>
                                    Liên hệ ngay
                                </a>
                                <a href="{{ route('about') }}"
                                    class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-gray-600 text-gray-300 font-semibold rounded-xl hover:bg-gray-600 hover:text-white transition-all duration-300">
                                    <i class="bi bi-book mr-2"></i>
                                    Xem hướng dẫn
                                </a>
                            </div>
                        </div>

                        <!-- Support Options Grid -->
                        <div class="mt-12 lg:mt-0 grid grid-cols-2 gap-6">
                            <div class="support-card">
                                <div class="support-icon">
                                    <i class="bi bi-clock text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-white">24/7</h4>
                                <p class="text-gray-400 text-sm">Hỗ trợ liên tục</p>
                            </div>

                            <div class="support-card">
                                <div class="support-icon">
                                    <i class="bi bi-telephone text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-white">Hotline</h4>
                                <p class="text-gray-400 text-sm">Gọi trực tiếp</p>
                            </div>

                            <div class="support-card">
                                <div class="support-icon">
                                    <i class="bi bi-envelope text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-white">Email</h4>
                                <p class="text-gray-400 text-sm">Phản hồi nhanh</p>
                            </div>

                            <div class="support-card">
                                <div class="support-icon">
                                    <i class="bi bi-chat-dots text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-white">Live Chat</h4>
                                <p class="text-gray-400 text-sm">Tư vấn ngay</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Styles for Tenant -->
        <style>
            .feature-card {
                background: white;
                border-radius: 24px;
                padding: 2rem;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
                transition: all 0.4s ease;
                border: 1px solid rgba(255, 255, 255, 0.1);
                position: relative;
                overflow: hidden;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }

            .feature-card:hover::before {
                transform: scaleX(1);
            }

            .feature-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            }

            .feature-icon {
                width: 80px;
                height: 80px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
                transition: transform 0.3s ease;
            }

            .feature-card:hover .feature-icon {
                transform: scale(1.1);
            }

            .support-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border-radius: 16px;
                padding: 2rem;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }

            .support-card:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateY(-4px);
            }

            .support-icon {
                width: 60px;
                height: 60px;
                background: rgba(59, 130, 246, 0.2);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                color: #60a5fa;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
        </style>
    </x-tenant-layout>
@endrole
