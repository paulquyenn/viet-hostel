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

                <h1>Trang Admin</h1>

            </div>
        </section>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

    </x-admin-layout>
@endrole

@role('tenant')
    <x-tenant-layout>
        <h1>Trang Tenant</h1>
    </x-tenant-layout>
@endrole
