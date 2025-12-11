<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS Evergreen Health & Wellness Center - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .hospital-header {
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
        }
        .emram-badge {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .card-shadow:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        .form-select-custom {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header Navigation -->
    <header class="hospital-header text-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <i class="fas fa-hospital text-blue-700 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Evergreen Health & Wellness Center</h1>
                        <p class="text-blue-200 text-xs">Healthcare Excellence</p>
                    </div>
                </div>

                <!-- Main Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="#" class="hover:text-blue-200 text-sm font-medium">Home</a>
                    <a href="#" class="hover:text-blue-200 text-sm font-medium">Our Specialist</a>
                    <a href="#" class="hover:text-blue-200 text-sm font-medium">Our Doctors</a>
                    <a href="#" class="hover:text-blue-200 text-sm font-medium">Appointments</a>
                    <a href="#" class="bg-white text-blue-700 px-4 py-1.5 rounded text-sm font-semibold hover:bg-gray-100">
                        Login / Sign in
                    </a>
                </nav>

                <!-- Mobile Menu -->
                <button class="md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="mb-10">
            <!-- EMRAM Badge -->
            <div class="flex justify-center mb-6">
                <div class="emram-badge px-6 py-2 rounded-full inline-flex items-center">
                    <i class="fas fa-trophy mr-2"></i>
                    <span class="font-bold">HIMSS EMRAM Tingkat 7</span>
                </div>
            </div>

            <!-- Main Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4">
                    Pertama di Indonesia,
                    <span class="text-blue-700">tiga rumah sakit</span><br>
                    Evergreen Health & Wellness Center<br>
                    <span class="text-blue-700">meraih validasi</span><br>
                    HIMSS EMRAM Tingkat 7
                </h1>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
            </div>

            <!-- Separator Line -->
            <div class="flex items-center justify-center my-8">
                <div class="w-full border-t border-gray-300"></div>
            </div>

            <!-- EMRAM Section -->
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">EMRAM</h2>
                <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl card-shadow">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-laptop-medical text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800">Paperless Environment</h3>
                            <p class="text-sm text-gray-600 mt-1">Lingkungan bebas kertas</p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800">Data Security</h3>
                            <p class="text-sm text-gray-600 mt-1">Keamanan data terjamin</p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800">Advanced Analytics</h3>
                            <p class="text-sm text-gray-600 mt-1">Analitik data canggih</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Find Doctor Section -->
        <div class="bg-white rounded-xl card-shadow p-8 max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Cari Dokter</h2>
            <p class="text-gray-600 mb-6">Temukan dokter spesialis sesuai kebutuhan Anda</p>

            <!-- Search Form -->
            <div class="space-y-6">
                <!-- Nama Dokter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-md mr-2 text-blue-600"></i>Nama Dokter
                    </label>
                    <div class="relative">
                        <select class="w-full p-3 border border-gray-300 rounded-lg form-select-custom appearance-none bg-white pr-10">
                            <option value="">Pilih Nama Dokter</option>
                            <option value="dr-ahmad">Dr. Ahmad Wijaya, Sp.PD</option>
                            <option value="dr-sari">Dr. Sari Dewi, Sp.OG</option>
                            <option value="dr-budi">Dr. Budi Santoso, Sp.JP</option>
                            <option value="dr-maya">Dr. Maya Indah, Sp.A</option>
                            <option value="dr-rian">Dr. Rian Pratama, Sp.B</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Rumah Sakit -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-hospital mr-2 text-blue-600"></i>Rumah Sakit
                    </label>
                    <div class="relative">
                        <select class="w-full p-3 border border-gray-300 rounded-lg form-select-custom appearance-none bg-white pr-10">
                            <option value="">Seluruh Cabang RSPI</option>
                            <option value="rspi-pondok-indah">RSPI Pondok Indah</option>
                            <option value="rspi-bintaro">RSPI Bintaro Jaya</option>
                            <option value="rspi-pur">RSPI Puri Indah</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Spesialisasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-stethoscope mr-2 text-blue-600"></i>Spesialisasi
                    </label>
                    <div class="relative">
                        <select class="w-full p-3 border border-gray-300 rounded-lg form-select-custom appearance-none bg-white pr-10">
                            <option value="">Pilih Spesialisasi</option>
                            <option value="jantung">Penyakit Jantung</option>
                            <option value="kandungan">Kebidanan & Kandungan</option>
                            <option value="anak">Anak</option>
                            <option value="bedah">Bedah Umum</option>
                            <option value="kulit">Kulit & Kelamin</option>
                            <option value="mata">Mata</option>
                            <option value="saraf">Saraf</option>
                            <option value="paru">Paru</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Pilihan Hari -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>Pilihan Hari
                    </label>
                    <div class="relative">
                        <select class="w-full p-3 border border-gray-300 rounded-lg form-select-custom appearance-none bg-white pr-10">
                            <option value="">Pilih Tanggal</option>
                            <option value="today">Hari Ini</option>
                            <option value="tomorrow">Besok</option>
                            <option value="week">Minggu Ini</option>
                            <option value="next-week">Minggu Depan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button class="flex-1 py-3 px-6 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </button>
                    <button class="flex-1 py-3 px-6 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Cari Dokter
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="bg-blue-50 p-6 rounded-xl text-center card-shadow">
                <i class="fas fa-phone-alt text-blue-600 text-2xl mb-3"></i>
                <h4 class="font-bold text-gray-800 mb-1">Call Center</h4>
                <p class="text-gray-600">021 765 7525</p>
            </div>
            <div class="bg-green-50 p-6 rounded-xl text-center card-shadow">
                <i class="fas fa-clock text-green-600 text-2xl mb-3"></i>
                <h4 class="font-bold text-gray-800 mb-1">Jam Operasional</h4>
                <p class="text-gray-600">24 Jam / 7 Hari</p>
            </div>
            <div class="bg-purple-50 p-6 rounded-xl text-center card-shadow">
                <i class="fas fa-map-marker-alt text-purple-600 text-2xl mb-3"></i>
                <h4 class="font-bold text-gray-800 mb-1">3 Lokasi</h4>
                <p class="text-gray-600">Evergreen</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="flex justify-center space-x-6 mb-4">
                    <a href="#" class="hover:text-blue-300"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="hover:text-blue-300"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="hover:text-blue-300"><i class="fab fa-twitter text-xl"></i></a>
                    <a href="#" class="hover:text-blue-300"><i class="fab fa-youtube text-xl"></i></a>
                </div>
                <p class="text-gray-400 text-sm">© 2025 Evergreen Health & Wellness Center. Seluruh hak cipta dilindungi undang-undang.</p>
                <p class="text-gray-500 text-xs mt-2">Sertifikasi HIMSS EMRAM Level 7 - No. ID-2023-001</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('button.md\\:hidden').addEventListener('click', function() {
            const nav = document.querySelector('nav.hidden.md\\:flex');
            if (nav.classList.contains('hidden')) {
                nav.classList.remove('hidden');
                nav.classList.add('flex', 'flex-col', 'absolute', 'top-16', 'left-0', 'right-0', 
                                 'bg-blue-900', 'p-4', 'space-y-4', 'z-50', 'shadow-lg');
            } else {
                nav.classList.add('hidden');
                nav.classList.remove('flex', 'flex-col', 'absolute', 'top-16', 'left-0', 'right-0',
                                  'bg-blue-900', 'p-4', 'space-y-4', 'z-50', 'shadow-lg');
            }
        });

        // Form validation
        document.querySelector('button.bg-blue-600').addEventListener('click', function() {
            const doctorSelect = document.querySelector('select:first-of-type');
            if (doctorSelect.value === '') {
                alert('Silakan pilih nama dokter terlebih dahulu');
                doctorSelect.focus();
            }
        });
    </script>
</body>
</html>