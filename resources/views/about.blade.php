<x-tenant-layout>
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Về chúng tôi</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Chào mừng đến với Trọ Việt
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Nơi cung cấp những sản phẩm và dịch vụ chất lượng cao.
                </p>
            </div>

            <div class="relative overflow-hidden bg-gray-100 rounded-lg shadow-lg mb-12">
                <img class="w-full h-96 object-cover" src="{{ asset('images/about-banner.jpg') }}" alt="Banner"
                    onerror="this.src='https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1267&q=80'">
                <div class="absolute inset-0 bg-gradient-to-t from-black opacity-50"></div>
                <div class="absolute bottom-0 p-8 text-white">
                    <h3 class="text-2xl font-bold">Tầm nhìn của chúng tôi</h3>
                    <p class="mt-2">Trở thành đối tác tin cậy và là lựa chọn hàng đầu trong lĩnh vực của chúng tôi.
                    </p>
                </div>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="transition duration-300 ease-in-out transform hover:-translate-y-2 hover:shadow-xl rounded-lg overflow-hidden bg-white shadow-md">
                        <div class="p-5">
                            <div
                                class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Chất lượng hàng đầu</h3>
                            <p class="mt-2 text-base text-gray-500">Chúng tôi cam kết cung cấp các sản phẩm và dịch vụ
                                có chất lượng cao nhất cho khách hàng.</p>
                        </div>
                    </div>

                    <div
                        class="transition duration-300 ease-in-out transform hover:-translate-y-2 hover:shadow-xl rounded-lg overflow-hidden bg-white shadow-md">
                        <div class="p-5">
                            <div
                                class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Đội ngũ chuyên nghiệp</h3>
                            <p class="mt-2 text-base text-gray-500">Đội ngũ chuyên gia giàu kinh nghiệm và tận tâm sẽ
                                đem đến cho bạn sự hài lòng.</p>
                        </div>
                    </div>

                    <div
                        class="transition duration-300 ease-in-out transform hover:-translate-y-2 hover:shadow-xl rounded-lg overflow-hidden bg-white shadow-md">
                        <div class="p-5">
                            <div
                                class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Hiệu quả & nhanh chóng</h3>
                            <p class="mt-2 text-base text-gray-500">Chúng tôi luôn đặt sự hiệu quả và tốc độ lên hàng
                                đầu để đáp ứng nhu cầu của khách hàng.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 bg-gray-50 rounded-xl p-8 shadow-inner">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Lịch sử phát triển</h3>
                        <p class="text-gray-600 mb-4">
                            Được thành lập vào năm 20XX, Tro Việt đã không ngừng phát triển và khẳng định vị thế trên
                            thị trường.
                            Với hơn X năm kinh nghiệm, chúng tôi tự hào là đối tác tin cậy của nhiều khách hàng.
                        </p>
                        <p class="text-gray-600">
                            Sứ mệnh của chúng tôi là cung cấp những giải pháp tối ưu, mang lại giá trị thiết thực cho
                            khách hàng
                            và góp phần vào sự phát triển bền vững của xã hội.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Giá trị cốt lõi</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-600">Chất lượng và uy tín là tiêu chí hàng đầu</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-600">Đổi mới sáng tạo không ngừng</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-600">Lấy khách hàng làm trung tâm</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-600">Phát triển bền vững và có trách nhiệm</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-16">
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-8">Đội ngũ lãnh đạo</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="mx-auto h-40 w-40 rounded-full overflow-hidden mb-4">
                            <img class="h-full w-full object-cover"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80"
                                alt="Team member">
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">Nguyễn Văn A</h4>
                        <p class="text-indigo-600">Giám đốc điều hành</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-40 w-40 rounded-full overflow-hidden mb-4">
                            <img class="h-full w-full object-cover"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80"
                                alt="Team member">
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">Trần Thị B</h4>
                        <p class="text-indigo-600">Giám đốc tài chính</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-40 w-40 rounded-full overflow-hidden mb-4">
                            <img class="h-full w-full object-cover"
                                src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80"
                                alt="Team member">
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">Lê Văn C</h4>
                        <p class="text-indigo-600">Giám đốc công nghệ</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-40 w-40 rounded-full overflow-hidden mb-4">
                            <img class="h-full w-full object-cover"
                                src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80"
                                alt="Team member">
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">Phạm Thị D</h4>
                        <p class="text-indigo-600">Giám đốc marketing</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 bg-indigo-600 rounded-xl py-12 px-6 sm:px-12 text-center text-white">
                <h3 class="text-3xl font-bold mb-6">Liên hệ với chúng tôi</h3>
                <p class="text-xl mb-8 max-w-2xl mx-auto">Bạn có câu hỏi hoặc cần tư vấn? Hãy liên hệ với chúng tôi
                    ngay hôm nay!</p>
                <a href="{{ route('contact') }}"
                    class="inline-block bg-white text-indigo-600 font-medium px-8 py-3 rounded-lg hover:bg-gray-100 transition duration-300">
                    Liên hệ ngay
                </a>
            </div>
        </div>
    </div>
</x-tenant-layout>
