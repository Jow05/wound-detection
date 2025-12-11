<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Medical System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-xl font-bold hover:text-blue-200">
                        <i class="fas fa-hospital mr-2"></i>MedSystem
                    </a>
                    
                    @auth
                        <!-- Navigation berdasarkan role -->
                        @if(auth()->user()->role === 'patient')
                            <a href="{{ route('doctors.index') }}" class="hover:text-blue-200">
                                <i class="fas fa-user-md mr-1"></i>Doctors
                            </a>
                            <a href="{{ route('appointments.index') }}" class="hover:text-blue-200">
                                <i class="fas fa-calendar-alt mr-1"></i>Appointments
                            </a>
                            <a href="{{ route('wounds.index') }}" class="hover:text-blue-200">
                                <i class="fas fa-band-aid mr-1"></i>Wounds
                            </a>
                        @elseif(auth()->user()->role === 'doctor')
                            <a href="{{ route('appointments.index') }}" class="hover:text-blue-200">
                                <i class="fas fa-calendar-alt mr-1"></i>Appointments
                            </a>
                            <a href="{{ route('wounds.index') }}" class="hover:text-blue-200">
                                <i class="fas fa-band-aid mr-1"></i>Patient Wounds
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.doctors.index') }}" class="hover:text-blue-200">
                                <i class="fas fa-users-cog mr-1"></i>Manage Doctors
                            </a>
                        @endif
                    @endauth
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm">Hi, {{ auth()->user()->name }}</span>
                        <span class="bg-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-user-tag mr-1"></i>{{ ucfirst(auth()->user()->role) }}
                        </span>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-100 font-medium">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <div class="font-bold mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Please fix the following errors:
                    </div>
                    <ul class="list-disc list-inside ml-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</body>
</html>