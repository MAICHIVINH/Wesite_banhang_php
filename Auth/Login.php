<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Hệ Thống</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/Admin/Login.css">
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-5xl grid grid-cols-1 md:grid-cols-2">

        <!-- Slide ảnh -->
        <div class="relative h-96 md:h-auto">
            <div id="slider" class="h-full w-full relative overflow-hidden">
                <img src="https://picsum.photos/600/500?random=1" class="slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-100">
                <img src="https://picsum.photos/600/500?random=2" class="slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0">
                <img src="https://picsum.photos/600/500?random=3" class="slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700 opacity-0">
            </div>
            <!-- Nút điều khiển -->
            <button onclick="prevSlide()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Form đăng nhập -->
        <div class="p-8 flex flex-col justify-center">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-indigo-500 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">ĐĂNG NHẬP HỆ THỐNG</h1>
                <p class="text-gray-600 mt-2">Vui lòng nhập thông tin đăng nhập</p>
            </div>

            <form id="loginForm" method="post" class="space-y-6" action="../Admin.php">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Email đăng nhập</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="email" id="username" name="email"
                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                            placeholder="Nhập email đăng nhập" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                            placeholder="Nhập mật khẩu" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                            onclick="togglePasswordVisibility()">
                            <i id="togglePasswordIcon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-3">Đăng nhập với tư cách:</span>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" id="isAdmin" name="isAdmin"
                            class="toggle-checkbox absolute w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer checked:right-0 checked:bg-indigo-600 transition-all duration-300" />
                        <label for="isAdmin"
                            class="toggle-label block w-10 h-6 rounded-full bg-gray-300 cursor-pointer"></label>

                    </div>
                    <label for="isAdmin" class="text-sm font-medium text-gray-700">Admin</label>
                </div>

                <button type="submit" name="login"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    Đăng nhập
                </button>
            </form>
        </div>
    </div>

    <script>
        // Toggle password
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Slide show
        let currentSlide = 0;
        const slides = document.querySelectorAll(".slide");

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.opacity = (i === index) ? "1" : "0";
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Auto chạy sau 5s
        setInterval(nextSlide, 5000);
    </script>
</body>

</html>