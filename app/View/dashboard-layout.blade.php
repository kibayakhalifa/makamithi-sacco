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
                        <a href="{{ route('member.savings.index') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ str_starts_with($currentRoute, 'member.savings.') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            💰 My Savings
                        </a>
                        <a href="{{ route('member.loans.apply') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ str_starts_with($currentRoute, 'member.loans.') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📝 Apply Loan
                        </a>
                        <a href="{{ route('member.profile') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ str_starts_with($currentRoute, 'member.profile') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            👤 My Profile
                        </a>
                    
                    @elseif(auth()->user()->role === 'treasurer')
                        <!-- TREASURER NAVIGATION -->
                        <a href="{{ route('treasurer.dashboard') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.dashboard') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📊 Treasurer Dashboard
                        </a>
                        
                        <a href="{{ route('treasurer.treasurer.savings.deductions') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.treasurer.savings.deductions') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            💵 Payroll Deductions
                        </a>
                        
                        <!-- EXISTING PAYMENTS LINK -->
                        <a href="{{ route('treasurer.payments') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.payments') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            💳 Process Payments
                        </a>
                        
                        <!-- LOANS LINK -->
                        <a href="{{ route('treasurer.loans') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.loans') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📋 Loans Management
                        </a>
                        
                        <!-- SAVINGS SUMMARY LINK -->
                        <a href="{{ route('treasurer.savings') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.savings') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            💰 Savings Summary
                        </a>
                        
                        <!-- EXPENSES LINK -->
                        <a href="{{ route('treasurer.expenses') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.expenses') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            💸 Expenses Tracking
                        </a>
                        
                        <!-- CHEQUES LINK -->
                        <a href="{{ route('treasurer.cheques') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.cheques') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            🏦 Cheque Management
                        </a>
                        
                        <!-- RECONCILIATION LINK -->
                        <a href="{{ route('treasurer.reconciliation') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.reconciliation') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            🔄 Bank Reconciliation
                        </a>
                        
                        <!-- REPORTS LINK -->
                        <a href="{{ route('treasurer.financial-reports') }}"
                            class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('treasurer.financial-reports') ? 'bg-blue-800 border-r-4 border-yellow-400' : '' }}">
                            📈 Financial Reports
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
                <a href="{{ route('logout') }}"
                class="block py-3 px-6 hover:bg-blue-800"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    🚪 Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
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