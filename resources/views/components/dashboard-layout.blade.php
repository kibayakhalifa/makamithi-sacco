<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r hidden md:flex flex-col shadow-sm">

            <!-- Header -->
            <div class="p-6 border-b bg-green-50">
                <h1 class="text-2xl font-bold text-green-700 flex items-center gap-2">
                    <span class="w-2 h-6 bg-orange-500 rounded"></span>
                    Makamithi Sacco
                </h1>

                <p class="text-green-800 text-sm mt-1">
                    @auth
                        {{ ucfirst(auth()->user()->role) }} Panel
                    @endauth
                </p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1">

                @auth
                    @php
                        $userRole = auth()->user()->role;
                        $current = request()->route()->getName();
                    @endphp

                    {{-- MEMBER --}}
                    @if($userRole === 'member')
                        <x-nav.link route="member.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="member.savings.index" current="{{ $current }}">💰 My Savings</x-nav.link>
                        <x-nav.link route="member.loans.apply" current="{{ $current }}">📝 Apply Loan</x-nav.link>
                        <x-nav.link route="member.profile" current="{{ $current }}">👤 My Profile</x-nav.link>
                        <x-nav.link route="member.loans.index" current="{{ $current }}">📜 My Loans</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>
                        <x-nav.link route="member.reports.index" current="{{ $current }}">📈 Reports</x-nav.link>

                        {{-- CHAIRMAN --}}
                    @elseif($userRole === 'chairman')
                        <x-nav.link route="chairman.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="chairman.loan-approvals" current="{{ $current }}">✅ Loan Approvals</x-nav.link>
                        <x-nav.link route="reports.index" current="{{ $current }}">📈 Reports</x-nav.link>
                        <x-nav.link route="chairman.members" current="{{ $current }}">👥 Members</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>

                        {{-- TREASURER --}}
                    @elseif($userRole === 'treasurer')
                        <x-nav.link route="treasurer.dashboard" current="{{ $current }}">📊 Treasurer Dashboard</x-nav.link>
                        <x-nav.link route="treasurer.payments" current="{{ $current }}">💳 Payment Processing</x-nav.link>
                        <x-nav.link route="treasurer.loans" current="{{ $current }}">📋 Loans Management</x-nav.link>
                        <x-nav.link route="treasurer.savings" current="{{ $current }}">💰 Savings Summary</x-nav.link>
                        <x-nav.link route="treasurer.expenses" current="{{ $current }}">📊 Expenses Tracking</x-nav.link>
                        <x-nav.link route="treasurer.cheques" current="{{ $current }}">🏦 Cheque Management</x-nav.link>
                        <x-nav.link route="treasurer.reconciliation" current="{{ $current }}">✔️ Bank
                            Reconciliation</x-nav.link>
                        <x-nav.link route="treasurer.financial-reports" current="{{ $current }}">📈 Financial
                            Reports</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>

                        {{-- SECRETARY --}}
                    @elseif($userRole === 'secretary')
                        <x-nav.link route="secretary.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="secretary.loan-approvals" current="{{ $current }}">✅ Loan Approvals</x-nav.link>
                        <x-nav.link route="secretary.members" current="{{ $current }}">👥 Member Management</x-nav.link>
                        <x-nav.link route="secretary.communications" current="{{ $current }}">📧 Communications</x-nav.link>
                        <x-nav.link route="secretary.documents" current="{{ $current }}">📄 Documents</x-nav.link>
                        <x-nav.link route="reports.index" current="{{ $current }}">📈 Reports</x-nav.link>

                    @endif

                    <!-- SETTINGS + LOGOUT -->
                    <div class="pt-6 mt-6 border-t border-green-200">
                        <a href="{{ route('settings') }}"
                            class="w-full block text-left px-4 py-2 text-green-700 hover:bg-green-100 rounded-lg">
                            ⚙️ Settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                @endauth

            </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white border-b px-6 py-4 flex justify-between items-center shadow-sm">

                <button id="menuToggle" class="md:hidden text-gray-700 text-2xl">☰</button>

                <div class="flex items-center space-x-3">
                    <div class="hidden md:block text-right">
                        <p class="font-medium text-green-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-green-600">
                            {{ ucfirst(auth()->user()->role) }} • {{ auth()->user()->employee_number ?? 'EMP001' }}
                        </p>
                    </div>

                    <div
                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">

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
        <div class="w-64 bg-white h-full shadow-xl p-6 overflow-y-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold text-green-700">Makamithi Sacco</h1>
                <button id="closeMenu" class="text-red-600 text-xl">✖</button>
            </div>

            <p class="text-green-700 text-sm mb-6">
                {{ ucfirst(auth()->user()->role) }} Panel
            </p>

            <nav class="space-y-2">
                @auth
                    @php
                        $userRole = auth()->user()->role;
                        $current = request()->route()->getName();
                    @endphp

                    {{-- MEMBER --}}
                    @if($userRole === 'member')
                        <x-nav.link route="member.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="member.savings.index" current="{{ $current }}">💰 My Savings</x-nav.link>
                        <x-nav.link route="member.loans.apply" current="{{ $current }}">📝 Apply Loan</x-nav.link>
                        <x-nav.link route="member.profile" current="{{ $current }}">👤 My Profile</x-nav.link>
                        <x-nav.link route="member.loans.index" current="{{ $current }}">📜 My Loans</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>
                        <x-nav.link route="member.reports.index" current="{{ $current }}">📈 Reports</x-nav.link>

                        {{-- CHAIRMAN --}}
                    @elseif($userRole === 'chairman')
                        <x-nav.link route="chairman.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="chairman.loan-approvals" current="{{ $current }}">✅ Loan Approvals</x-nav.link>
                        <x-nav.link route="chairman.members" current="{{ $current }}">👥 Members</x-nav.link>
                        <x-nav.link route="reports.index" current="{{ $current }}">📈 Reports</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>

                        {{-- TREASURER --}}
                    @elseif($userRole === 'treasurer')
                        <x-nav.link route="treasurer.dashboard" current="{{ $current }}">📊 Treasurer Dashboard</x-nav.link>
                        <x-nav.link route="treasurer.payments" current="{{ $current }}">💳 Payment Processing</x-nav.link>
                        <x-nav.link route="treasurer.loans" current="{{ $current }}">📋 Loans Management</x-nav.link>
                        <x-nav.link route="treasurer.savings" current="{{ $current }}">💰 Savings Summary</x-nav.link>
                        <x-nav.link route="treasurer.expenses" current="{{ $current }}">📊 Expenses Tracking</x-nav.link>
                        <x-nav.link route="treasurer.cheques" current="{{ $current }}">🏦 Cheque Management</x-nav.link>
                        <x-nav.link route="treasurer.reconciliation" current="{{ $current }}">✔️ Bank
                            Reconciliation</x-nav.link>
                        <x-nav.link route="treasurer.financial-reports" current="{{ $current }}">📈 Financial
                            Reports</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>

                        {{-- SECRETARY --}}
                    @elseif($userRole === 'secretary')
                        <x-nav.link route="secretary.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="secretary.loan-approvals" current="{{ $current }}">✅ Loan Approvals</x-nav.link>
                        <x-nav.link route="secretary.members" current="{{ $current }}">👥 Member Management</x-nav.link>
                        <x-nav.link route="secretary.communications" current="{{ $current }}">📧 Communications</x-nav.link>
                        <x-nav.link route="secretary.documents" current="{{ $current }}">📄 Documents</x-nav.link>
                        <x-nav.link route="reports.index" current="{{ $current }}">📈 Reports</x-nav.link>

                    @endif

                    <!-- SETTINGS + LOGOUT -->
                    <div class="pt-6 mt-6 border-t border-green-200">
                        <a href="{{ route('settings') }}"
                            class="w-full block text-left px-4 py-2 text-green-700 hover:bg-green-100 rounded-lg">
                            ⚙️ Settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                @endauth
            </nav>

        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMenu = document.getElementById('closeMenu');

        if (menuToggle) menuToggle.onclick = () => mobileSidebar.classList.remove('hidden');
        if (closeMenu) closeMenu.onclick = () => mobileSidebar.classList.add('hidden');

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-auto-dismiss').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>

</body>

</html>