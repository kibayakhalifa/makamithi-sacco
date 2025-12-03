<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makamithi Sacco - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar Navigation -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-900 text-white hidden md:block">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Makamithi Sacco</h1>
                <p class="text-blue-200 text-sm mt-1">
                    @auth
                        {{ ucfirst(auth()->user()->role) }} Dashboard
                    @endauth
                </p>
            </div>
            
            <nav class="mt-6">
                @auth
                    @php
                        $userRole = auth()->user()->role;
                        $currentRoute = request()->route()->getName();
                    @endphp
                    
                    <!-- Member Navigation -->
                    @if($userRole === 'member')
                        <a href="{{ route('member.dashboard') }}" 
                           class="block py-3 px-6 hover:bg-blue-800 {{ $currentRoute === 'member.dashboard' ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💰 My Savings
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📝 Apply Loan
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📄 My Statements
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            👤 My Profile
                        </a>
                    
                    <!-- Chairman Navigation -->
                    @elseif($userRole === 'chairman')
                        <a href="{{ route('chairman.dashboard') }}" 
                           class="block py-3 px-6 hover:bg-blue-800 {{ $currentRoute === 'chairman.dashboard' ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            ✅ Loan Approvals
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📈 Reports
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            👥 Members
                        </a>
                    
                    <!-- Treasurer Navigation -->
                    @elseif($userRole === 'treasurer')
                        <a href="{{ route('treasurer.dashboard') }}" 
                           class="block py-3 px-6 hover:bg-blue-800 {{ $currentRoute === 'treasurer.dashboard' ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💳 Process Payments
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💸 Expenses
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            🏦 Bank Reconciliation
                        </a>
                    
                    <!-- Secretary Navigation -->
                    @elseif($userRole === 'secretary')
                        <a href="{{ route('secretary.dashboard') }}" 
                           class="block py-3 px-6 hover:bg-blue-800 {{ $currentRoute === 'secretary.dashboard' ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            👥 Member Management
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📧 Communications
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📄 Documents
                        </a>
                    @endif
                    
                    <!-- Common Links -->
                    <div class="mt-8 border-t border-blue-800 pt-4">
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            ⚙️ Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="block w-full text-left py-3 px-6 hover:bg-blue-800">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4 flex justify-between items-center">
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-600 hover:text-gray-900" id="menuToggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- User info -->
                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden md:block">
                            <p class="font-semibold text-gray-800">
                                @auth
                                    {{ auth()->user()->name }}
                                @endauth
                            </p>
                            <p class="text-sm text-gray-500">
                                @auth
                                    {{ ucfirst(auth()->user()->role) }} • {{ auth()->user()->employee_number ?? 'EMP001' }}
                                @endauth
                            </p>
                        </div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">
                                    @auth
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endauth
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                        <div class="flex items-center">
                            <span class="mr-2">✅</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                        <div class="flex items-center">
                            <span class="mr-2">❌</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                        <div class="flex items-center">
                            <span class="mr-2">⚠️</span>
                            <span>{{ session('warning') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t py-4 px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-600 text-sm">
                        &copy; {{ date('Y') }} Makamithi Sacco. All rights reserved.
                    </p>
                    <p class="text-gray-500 text-sm mt-2 md:mt-0">
                        v1.0.0 • Employee Savings & Credit Cooperative Society
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" id="mobileOverlay"></div>
        <div class="relative w-64 h-full bg-blue-900 text-white">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Makamithi Sacco</h1>
                    <button id="closeMenu" class="text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-blue-200 text-sm mt-1">
                    @auth
                        {{ ucfirst(auth()->user()->role) }} Dashboard
                    @endauth
                </p>
            </div>
            
            <!-- Mobile Navigation (same as desktop) -->
            <nav class="mt-6">
                @auth
                    @php
                        $userRole = auth()->user()->role;
                        $currentRoute = request()->route()->getName();
                    @endphp
                    
                    @if($userRole === 'member')
                        <a href="{{ route('member.dashboard') }}" class="block py-3 px-6 hover:bg-blue-800">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💰 My Savings
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📝 Apply Loan
                        </a>
                    @elseif($userRole === 'chairman')
                        <a href="{{ route('chairman.dashboard') }}" class="block py-3 px-6 hover:bg-blue-800">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            ✅ Loan Approvals
                        </a>
                    @elseif($userRole === 'treasurer')
                        <a href="{{ route('treasurer.dashboard') }}" class="block py-3 px-6 hover:bg-blue-800">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💳 Process Payments
                        </a>
                    @elseif($userRole === 'secretary')
                        <a href="{{ route('secretary.dashboard') }}" class="block py-3 px-6 hover:bg-blue-800">
                            📊 Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            👥 Member Management
                        </a>
                    @endif
                    
                    <div class="mt-8 border-t border-blue-800 pt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left py-3 px-6 hover:bg-blue-800">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </nav>
        </div>
    </div>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const closeMenu = document.getElementById('closeMenu');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    mobileSidebar.classList.remove('hidden');
                });
            }
            
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    mobileSidebar.classList.add('hidden');
                });
            }
            
            if (closeMenu) {
                closeMenu.addEventListener('click', function() {
                    mobileSidebar.classList.add('hidden');
                });
            }
            
            // Close mobile menu when clicking a link
            document.querySelectorAll('#mobileSidebar a').forEach(link => {
                link.addEventListener('click', function() {
                    mobileSidebar.classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>