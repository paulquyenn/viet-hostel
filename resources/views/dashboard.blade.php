@role('admin')
    <x-admin-layout>

        <div class="pagetitle">
            <h1>Trang chủ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Thống kê -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quản lý người dùng hệ thống</h5>
                            <p>Admin có vai trò quản lý người dùng trong hệ thống Trọ Việt</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Tổng số người dùng</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\User::count() }}</h6>
                                    <span class="text-muted small pt-2">Người dùng đã đăng ký</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Chủ trọ</h5>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning">
                                    <i class="bi bi-person-badge text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\User::role('landlord')->count() }}</h6>
                                    <span class="text-muted small pt-2">Chủ trọ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Người thuê</h5>
                            <div class="d-flex align-items-center">
                                <div
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success">
                                    <i class="bi bi-person-check text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ \App\Models\User::role('tenant')->count() }}</h6>
                                    <span class="text-muted small pt-2">Người thuê trọ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

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
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 min-h-screen">
            <!-- Hero Section -->
            <div class="relative py-16 px-4 sm:px-6 lg:px-8 bg-white shadow-sm">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block text-gray-900">Chào mừng đến với Trọ Việt</span>
                        </h1>
                        <p
                            class="mt-3 max-w-md mx-auto text-base text-gray-900 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            Nền tảng quản lý nhà trọ hiện đại, giúp bạn dễ dàng theo dõi hợp đồng, thanh toán và thông tin
                            liên lạc.
                        </p>
                        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                            <div class="rounded-md shadow">
                                <a href="#"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 md:py-4 md:text-lg md:px-10">
                                    Xem phòng của tôi
                                </a>
                            </div>
                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                <a href="#"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                    Thanh toán
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Sections -->
            <div class="py-12 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center">
                        <h2 class="text-base text-gray-900 font-semibold tracking-wide uppercase">Tính năng</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            Quản lý nhà trọ hiệu quả
                        </p>
                        <p class="mt-4 max-w-2xl text-xl text-gray-900 lg:mx-auto">
                            Tro Việt cung cấp đầy đủ các công cụ để quản lý việc thuê trọ một cách dễ dàng và tiện lợi.
                        </p>
                    </div>

                    <div class="mt-10">
                        <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-gray-800 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Quản lý hợp đồng</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-900">
                                    Xem chi tiết hợp đồng, ngày hết hạn và các điều khoản quan trọng liên quan đến việc thuê
                                    trọ.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-gray-800 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Thanh toán online</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-900">
                                    Thanh toán tiền trọ, điện nước và các dịch vụ khác trực tuyến một cách nhanh chóng và an
                                    toàn.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-gray-800 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Báo cáo sự cố</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-900">
                                    Dễ dàng báo cáo các sự cố trong phòng trọ và theo dõi tiến độ xử lý từ chủ trọ.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-gray-800 text-white">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Thông báo thông minh</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-900">
                                    Nhận thông báo về các khoản thanh toán, ngày hết hạn hợp đồng và các thông tin quan
                                    trọng khác.
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-gray-50">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 lg:py-16">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                                Cần hỗ trợ?
                            </h2>
                            <p class="mt-3 max-w-3xl text-lg text-gray-900">
                                Đội ngũ hỗ trợ của chúng tôi luôn sẵn sàng giúp đỡ bạn với mọi vấn đề liên quan đến nhà trọ.
                            </p>
                            <div class="mt-8 sm:flex">
                                <div class="rounded-md shadow">
                                    <a href="#"
                                        class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900">
                                        Liên hệ ngay
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="#"
                                        class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-gray-100 hover:bg-gray-200">
                                        Xem hướng dẫn
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-0 lg:grid-cols-2">
                            <div class="col-span-1 flex justify-center py-8 px-8 bg-white rounded-lg">
                                <span class="text-gray-900 text-4xl font-bold">24/7</span>
                            </div>
                            <div class="col-span-1 flex justify-center py-8 px-8 bg-white rounded-lg">
                                <span class="text-gray-900 text-4xl font-bold">Hotline</span>
                            </div>
                            <div class="col-span-1 flex justify-center py-8 px-8 bg-white rounded-lg">
                                <span class="text-gray-900 text-4xl font-bold">Email</span>
                            </div>
                            <div class="col-span-1 flex justify-center py-8 px-8 bg-white rounded-lg">
                                <span class="text-gray-900 text-4xl font-bold">Chat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-tenant-layout>
@endrole
