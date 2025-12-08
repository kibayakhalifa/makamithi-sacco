<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makamithi Sacco - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r hidden md:flex flex-col">
            <div class="p-6 border-b">
                <h1 class="text-xl font-semibold text-blue-900">Makamithi Sacco</h1>
                <p class="text-gray-500 text-sm mt-1">
                    @auth
                        {{ ucfirst(auth()->user()->role) }} Panel
                    @endauth
                </p>
            </div>

            <nav class="flex-1 p-4 space-y-1">

                @auth
                    @php
                        $userRole = auth()->user()->role;
                        $currentRoute = request()->route()->getName();
                        $current = request()->route()->getName();
                    @endphp

                    <!-- Member -->
                    @if($userRole === 'member')
                        <x-nav.link route="member.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="savings.index" current="{{ $current }}">💰 My Savings</x-nav.link>
                        <x-nav.link route="loans.apply" current="{{ $current }}">📝 Apply Loan</x-nav.link>
                        <x-nav.link route="profile.index" current="{{ $current }}">👤 My Profile</x-nav.link>
                        <a href="{{ route('loans.top-up') }}" class="{{ $currentRoute === 'loans.top-up' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                                  group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">🔄</span>
                            Top-up Loan
                        </a>
                        
                         <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>
                        <a href="{{ route('reports.index') }}" class="{{ str_starts_with($currentRoute, 'reports.') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                                          group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">📈</span>
                            Reports
                        </a>

                    @elseif($userRole === 'chairman')
                        <x-nav.link route="chairman.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="chairman.loan-approvals" current="{{ $current }}">✅ Loan Approvals</x-nav.link>
                        <a href="{{ route('reports.index') }}" class="{{ str_starts_with($currentRoute, 'reports.') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                                          group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">📈</span>
                            Reports
                        </a>
                        

                        <x-nav.link route="chairman.members" current="{{ $current }}">👥 Members</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>
                        
                        <!-- Treasurer Navigation -->
                    @elseif($userRole === 'treasurer')
                        <a href="{{ route('treasurer.dashboard') }}"
                            class="{{ $currentRoute === 'treasurer.dashboard' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                                                  group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">📊</span>
                            Dashboard
                        </a>
                        <a href="{{ route('treasurer.payments') }}"
                            class="{{ $currentRoute === 'treasurer.payments' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                                                  group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">💳</span>
                            Process Payments
                        </a>
                        

                        <a href="{{ route('reports.index') }}" class="{{ str_starts_with($currentRoute, 'reports.') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                                          group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">📈</span>
                            Reports
                        </a>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>

                    @elseif($userRole === 'secretary')
                        <x-nav.link route="secretary.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="secretary.members" current="{{ $current }}">👥 Member Management</x-nav.link>
                        <x-nav.link route="secretary.communications" current="{{ $current }}">📧 Communications</x-nav.link>
                        <x-nav.link route="secretary.documents" current="{{ $current }}">📄 Documents</x-nav.link>
                        <a href="{{ route('reports.index') }}" class="{{ str_starts_with($currentRoute, 'reports.') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}
                                  group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <span class="mr-3">📈</span>
                            Reports
                        </a>
                    @endif

                    <div class="pt-6 mt-6 border-t">
                        <x-nav.simple>⚙️ Settings</x-nav.simple>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                @endauth

            </nav>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white border-b px-6 py-4 flex justify-between items-center">

                <!-- Mobile Toggle -->
                <button id="menuToggle" class="md:hidden text-gray-700">
                    ☰
                </button>

                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <div class="hidden md:block text-right">
                        <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ ucfirst(auth()->user()->role) }} • {{ auth()->user()->employee_number ?? 'EMP001' }}
                        </p>
                    </div>

                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">

                @if(session('success'))
                    <x-alert.success>{{ session('success') }}</x-alert.success>
                @endif

                @if(session('error'))
                    <x-alert.error>{{ session('error') }}</x-alert.error>
                @endif

                @if(session('warning'))
                    <x-alert.warning>{{ session('warning') }}</x-alert.warning>
                @endif

                @yield('content')

            </main>

            <!-- Footer -->
            <footer class="bg-white border-t py-4 px-6 text-center text-sm text-gray-500">
                © {{ date('Y') }} Makamithi Sacco • Employee Savings & Credit Cooperative Society
            </footer>
        </div>

    </div>


    <!-- MOBILE SIDEBAR -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden">
        <div class="w-64 bg-white h-full shadow-lg p-6">

            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold text-blue-900">Makamithi Sacco</h1>
                <button id="closeMenu">✖</button>
            </div>

            <p class="text-gray-500 text-sm mt-1">
                {{ ucfirst(auth()->user()->role) }} Panel
            </p>

            <nav class="mt-6 space-y-2">
                {{-- Same navigation items as desktop --}}
                <a href="{{ route('member.dashboard') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>
            </nav>
        </div>
    </div>


    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMenu = document.getElementById('closeMenu');

        if (menuToggle) menuToggle.onclick = () => mobileSidebar.classList.remove('hidden');
        if (closeMenu) closeMenu.onclick = () => mobileSidebar.classList.add('hidden');
    </script>

</body>

</html>