<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RS Pondok Indah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-white font-sans">
    <!-- Professional Hospital Header -->
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Top Bar -->
            <div class="py-3 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <i class="fas fa-phone-alt text-blue-600 mr-2"></i>
                            <span class="text-sm text-gray-600">Emergency: <strong class="text-blue-700">1500-123</strong></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                            <span class="text-sm text-gray-600">24/7 Service</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-sm text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                {{ auth()->user()->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                  (auth()->user()->role == 'doctor' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                            
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <nav class="py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-hospital text-white text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-900">RS Pondok Indah</div>
                            <div class="text-xs text-gray-500">Healthcare Excellence</div>
                        </div>
                    </a>
                    
                    <!-- Navigation Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-blue-900 font-semibold hover:text-blue-700">
                            Home
                        </a>
                        
                        @auth
                            @if(auth()->user()->role === 'patient')
                                <a href="{{ route('patient.doctors.index') }}" class="text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-user-md mr-1"></i>Dokter
                                </a>
                                <a href="{{ route('appointments.index') }}" class="text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-calendar-check mr-1"></i>Janji Saya
                                </a>
                                <a href="{{ route('wounds.index') }}" class="text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-band-aid mr-1"></i>Luka
                                </a>
                            @elseif(auth()->user()->role === 'doctor')
                                <a href="{{ route('appointments.index') }}" class="text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-calendar-alt mr-1"></i>Appointments
                                </a>
                                <a href="{{ route('wounds.index') }}" class="text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-images mr-1"></i>Patient Wounds
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.doctors.index') }}" class="text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-users-cog mr-1"></i>Manage Doctors
                                </a>
                            @endif
                        @else
                            <a href="{{ route('home') }}#centers" class="text-gray-700 hover:text-blue-700">
                                <i class="fas fa-star mr-1"></i>Center of Excellence
                            </a>
                            <a href="{{ route('home') }}#locations" class="text-gray-700 hover:text-blue-700">
                                <i class="fas fa-map-marker-alt mr-1"></i>Lokasi
                            </a>
                        @endauth
                    </div>
                    
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-700">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Column 1 -->
                <div>
                    <div class="flex items-center mb-6">
                        <i class="fas fa-hospital text-3xl mr-3"></i>
                        <div>
                            <div class="text-xl font-bold">RS Pondok Indah</div>
                            <div class="text-blue-200 text-sm">Healthcare Excellence</div>
                        </div>
                    </div>
                    <p class="text-blue-200 text-sm">
                        Memberikan pelayanan kesehatan terbaik dengan standar global.
                    </p>
                </div>
                
                <!-- Column 2 -->
                <div>
                    <h3 class="text-lg font-bold mb-6">Layanan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-blue-200 hover:text-white">Emergency Care</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white">Medical Check-up</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white">Telemedicine</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white">Laboratorium</a></li>
                    </ul>
                </div>
                
                <!-- Column 3 -->
                <div>
                    <h3 class="text-lg font-bold mb-6">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-blue-300"></i>
                            <span class="text-blue-200">1500-123</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-300"></i>
                            <span class="text-blue-200">info@rspondokindah.co.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-blue-300"></i>
                            <span class="text-blue-200">Jl. Metro Duta Kav. UE, Jakarta</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Column 4 -->
                <div>
                    <h3 class="text-lg font-bold mb-6">Download App</h3>
                    <div class="space-y-4">
                        <button class="flex items-center bg-black text-white px-4 py-3 rounded-lg w-full">
                            <i class="fab fa-apple text-xl mr-3"></i>
                            <div class="text-left">
                                <div class="text-xs">Download on the</div>
                                <div class="font-bold">App Store</div>
                            </div>
                        </button>
                        <button class="flex items-center bg-green-600 text-white px-4 py-3 rounded-lg w-full">
                            <i class="fab fa-google-play text-xl mr-3"></i>
                            <div class="text-left">
                                <div class="text-xs">Get it on</div>
                                <div class="font-bold">Google Play</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-blue-800 mt-8 pt-8 text-center text-blue-300 text-sm">
                <p>&copy; {{ date('Y') }} RS Pondok Indah Group. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('button[class*="md:hidden"]');
            if (menuButton) {
                menuButton.addEventListener('click', function() {
                    const menu = document.querySelector('.md\\:flex');
                    if (menu) {
                        menu.classList.toggle('hidden');
                        menu.classList.toggle('flex');
                        menu.classList.toggle('flex-col');
                        menu.classList.toggle('absolute');
                        menu.classList.toggle('top-full');
                        menu.classList.toggle('left-0');
                        menu.classList.toggle('right-0');
                        menu.classList.toggle('bg-white');
                        menu.classList.toggle('shadow-lg');
                        menu.classList.toggle('p-4');
                        menu.classList.toggle('space-y-4');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>