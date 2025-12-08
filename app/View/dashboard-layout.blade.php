<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makamithi Sacco - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Sidebar Navigation -->
    <div class="flex h-screen">
        <div class="w-64 bg-blue-900 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Makamithi Sacco</h1>
                <p class="text-blue-200 text-sm mt-1">{{ auth()->user()->role }} Dashboard</p>
            </div>

            <nav class="mt-6">
                <!-- Dynamic navigation based on role -->
                @auth
                    @if(auth()->user()->role === 'member')
                        <a href="{{ route('member.dashboard') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ $currentRoute === 'member.dashboard' ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('savings.index') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ str_starts_with($currentRoute, 'savings.') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            💰 My Savings
                        </a>
                        <a href="{{ route('loans.apply') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ str_starts_with($currentRoute, 'loans.') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📝 Apply Loan
                        </a>
                        <a href="{{ route('profile.index') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ str_starts_with($currentRoute, 'profile.') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            👤 My Profile
                        </a>
                    @elseif(auth()->user()->role === 'chairman')
                        <a href="{{ route('chairman.dashboard') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('chairman.dashboard') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Chairman Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            ✅ Loan Approvals
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📈 Reports
                        </a>

                    @elseif(auth()->user()->role === 'treasurer')
                        <a href="{{ route('treasurer.dashboard') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.dashboard') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Treasurer Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💳 Process Payments
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            💸 Expenses
                        </a>

                    @elseif(auth()->user()->role === 'secretary')
                        <a href="{{ route('secretary.dashboard') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('secretary.dashboard') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Secretary Dashboard
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            👥 Member Management
                        </a>
                        <a href="#" class="block py-3 px-6 hover:bg-blue-800">
                            📧 Communications
                        </a>
                    @endif

                    <!-- Common logout -->
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

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</body>

</html>