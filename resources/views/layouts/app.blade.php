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
    <!-- Simple Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-blue-600">
                        <i class="fas fa-hospital mr-2"></i>MedSystem
                    </a>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Hi, {{ Auth::user()->name }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ Auth::user()->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                          (Auth::user()->role == 'doctor' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                    
                    <!-- Dashboard Link berdasarkan Role -->
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                        </a>
                    @elseif(Auth::user()->role == 'doctor')
                        <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('patient.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Register
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
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