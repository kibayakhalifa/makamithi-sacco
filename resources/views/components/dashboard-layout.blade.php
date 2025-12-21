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
        
        /* Base font sizes for mobile */
        html {
            font-size: 14px;
        }
        
        @media (min-width: 768px) {
            html {
                font-size: 16px;
            }
        }
        
        /* COLLAPSIBLE SIDEBAR STYLES - MODIFIED */
        .sidebar-collapsed {
            width: 4rem !important; /* Smaller on mobile */
        }

        .sidebar-collapsed .nav-text,
        .sidebar-collapsed h1,
        .sidebar-collapsed p {
            display: none;
        }

        .sidebar-collapsed nav a {
            justify-content: center;
            position: relative; /* For tooltip positioning */
        }

        /* Make icons slightly smaller when sidebar is collapsed on mobile */
        .sidebar-collapsed nav a {
            font-size: 1rem; /* Smaller on mobile */
            padding: 0.5rem 0;
        }

        @media (min-width: 768px) {
            .sidebar-collapsed nav a {
                font-size: 1.125rem; /* Slightly larger on desktop */
                padding: 0.75rem 0;
            }
            .sidebar-collapsed {
                width: 5rem !important;
            }
        }

        /* Tooltip styles */
        .nav-item {
            position: relative;
        }

        .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: #1f2937;
            color: white;
            padding: 0.375rem 0.75rem; /* Smaller padding */
            border-radius: 0.25rem;
            font-size: 0.75rem; /* Smaller font */
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 50;
            margin-left: 0.5rem;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
            pointer-events: none;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border-width: 5px; /* Smaller arrow */
            border-style: solid;
            border-color: transparent #1f2937 transparent transparent;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 50;
            margin-left: -0.5rem;
            pointer-events: none;
        }

        .sidebar-collapsed .nav-item:hover::after,
        .sidebar-collapsed .nav-item:hover::before {
            opacity: 1;
            visibility: visible;
        }

        /* Specific styling for collapsed sidebar tooltips */
        .sidebar-collapsed .nav-item::after {
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
        }

        .sidebar-collapsed .nav-item::before {
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border-color: transparent #1f2937 transparent transparent;
        }
        
        /* Mobile optimization */
        @media (max-width: 640px) {
            .text-sm-mobile {
                font-size: 0.75rem !important;
            }
            .text-xs-mobile {
                font-size: 0.65rem !important;
            }
            .p-2-mobile {
                padding: 0.5rem !important;
            }
            .text-lg-mobile {
                font-size: 1rem !important;
            }
            .text-xl-mobile {
                font-size: 1.125rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- SIDEBAR - MODIFIED -->
        <aside id="sidebar"
               class="hidden md:flex flex-col bg-white border-r shadow-sm
                      w-64 transition-all duration-300">  <!-- Added ID and transition classes -->

            <!-- Header - Smaller on mobile -->
            <div class="p-3 border-b bg-green-50">
                <h1 class="text-base font-bold text-green-700 flex items-center gap-2">
                    <span class="w-2 h-4 bg-orange-500 rounded"></span>
                    <span class="nav-text">Makamithi Sacco</span>
                </h1>

                <p class="text-xs text-green-700 mt-1 nav-text">
                    @auth
                        {{ ucfirst(auth()->user()->role) }} Panel
                    @endauth
                </p>
            </div>

            <!-- Navigation - Smaller font -->
            <nav class="flex-1 p-2 space-y-1 text-xs">

                @auth
                    @php
                        $userRole = auth()->user()->role;
                        $current = request()->route()->getName();
                    @endphp

                    {{-- MEMBER --}}
                    @if($userRole === 'member')
                        <div class="nav-item" data-tooltip="Dashboard">
                            <x-nav.link route="member.dashboard" current="{{ $current }}">📊 <span class="nav-text">Dashboard</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="My Savings">
                            <x-nav.link route="member.savings.index" current="{{ $current }}">💰 <span class="nav-text">My Savings</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Apply Loan">
                            <x-nav.link route="member.loans.apply" current="{{ $current }}">📝 <span class="nav-text">Apply Loan</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="My Profile">
                            <x-nav.link route="member.profile" current="{{ $current }}">👤 <span class="nav-text">My Profile</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="My Loans">
                            <x-nav.link route="member.loans.index" current="{{ $current }}">📜 <span class="nav-text">My Loans</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <x-nav.link route="documents.index" current="{{ $current }}">📄 <span class="nav-text">Documents</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Reports">
                            <x-nav.link route="member.reports.index" current="{{ $current }}">📈 <span class="nav-text">Reports</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <x-nav.link route="communications.index" current="{{ $current }}">📧 <span class="nav-text">Communications</span></x-nav.link>
                        </div>
                        


                        {{-- CHAIRMAN --}}
                    @elseif($userRole === 'chairman')
                        <div class="nav-item" data-tooltip="Dashboard">
                            <x-nav.link route="chairman.dashboard" current="{{ $current }}">📊 <span class="nav-text">Dashboard</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Loan Approvals">
                            <x-nav.link route="chairman.loan-approvals" current="{{ $current }}">✅ <span class="nav-text">Loan Approvals</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Reports">
                            <x-nav.link route="reports.index" current="{{ $current }}">📈 <span class="nav-text">Reports</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Members">
                            <x-nav.link route="chairman.members" current="{{ $current }}">👥 <span class="nav-text">Members</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <x-nav.link route="documents.index" current="{{ $current }}">📄 <span class="nav-text">Documents</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <x-nav.link route="communications.index" current="{{ $current }}">📧 <span class="nav-text">Communications</span></x-nav.link>
                        </div>


                        {{-- TREASURER --}}
                    @elseif($userRole === 'treasurer')
                        <div class="nav-item" data-tooltip="Dashboard">
                            <x-nav.link route="treasurer.dashboard" current="{{ $current }}">📊 <span class="nav-text">Treasurer Dashboard</span></x-nav.link>
                        </div>
                        
                        <!-- PAYROLL DEDUCTIONS LINK - ADDED -->
                        
                        
                        <div class="nav-item" data-tooltip="Payment Processing">
                            <x-nav.link route="treasurer.payments" current="{{ $current }}">💳 <span class="nav-text">Payment Processing</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Loans Management">
                            <x-nav.link route="treasurer.loans" current="{{ $current }}">📋 <span class="nav-text">Loans Management</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Savings Summary">
                            <x-nav.link route="treasurer.savings" current="{{ $current }}">💰 <span class="nav-text">Savings Summary</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Payroll Deductions">
                            <x-nav.link route="treasurer.treasurer.savings.deductions" current="{{ $current }}">
                                💵 <span class="nav-text">Payroll Deductions</span>
                            </x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Expenses Tracking">
                            <x-nav.link route="treasurer.expenses" current="{{ $current }}">📊 <span class="nav-text">Expenses Tracking</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Cheque Management">
                            <x-nav.link route="treasurer.cheques" current="{{ $current }}">🏦 <span class="nav-text">Cheque Management</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Financial Reports">
                            <x-nav.link route="treasurer.financial-reports" current="{{ $current }}">📈 <span class="nav-text">Financial Reports</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <x-nav.link route="documents.index" current="{{ $current }}">📄 <span class="nav-text">Documents</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <x-nav.link route="communications.index" current="{{ $current }}">📧 <span class="nav-text">Communications</span></x-nav.link>
                        </div>


                        {{-- SECRETARY --}}
                    @elseif($userRole === 'secretary')
                        <div class="nav-item" data-tooltip="Dashboard">
                            <x-nav.link route="secretary.dashboard" current="{{ $current }}">📊 <span class="nav-text">Dashboard</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Loan Approvals">
                            <x-nav.link route="secretary.loan-approvals" current="{{ $current }}">✅ <span class="nav-text">Loan Approvals</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Member Management">
                            <x-nav.link route="secretary.members" current="{{ $current }}">👥 <span class="nav-text">Member Management</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <x-nav.link route="secretary.communications" current="{{ $current }}">📧 <span class="nav-text">Communications</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <x-nav.link route="secretary.documents" current="{{ $current }}">📄 <span class="nav-text">Documents</span></x-nav.link>
                        </div>
                        <div class="nav-item" data-tooltip="Reports">
                            <x-nav.link route="reports.index" current="{{ $current }}">📈 <span class="nav-text">Reports</span></x-nav.link>
                        </div>

                    @endif

                    <!-- SETTINGS + LOGOUT - Smaller -->
                    <div class="pt-3 mt-3 border-t border-green-200">
                        <div class="nav-item" data-tooltip="Settings">
                            <a href="{{ route('settings') }}"
                                class="flex items-center gap-2 px-2 py-1.5 rounded-md
                                       text-green-700 hover:bg-green-100 text-xs">
                                ⚙️ <span class="nav-text">Settings</span>
                            </a>
                        </div>

                        <div class="nav-item" data-tooltip="Logout">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    class="w-full flex items-center gap-2 px-2 py-1.5
                                           text-red-600 hover:bg-red-100 rounded-md text-xs">
                                    🚪 <span class="nav-text">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>

                @endauth

            </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header - Smaller on mobile -->
            <header class="bg-white border-b px-4 py-3 flex justify-between items-center shadow-sm">

                <!-- LEFT SIDE: Mobile toggle + Desktop toggle -->
                <div class="flex items-center gap-2">
                    <!-- Mobile Toggle Button -->
                    <button id="menuToggle" class="md:hidden text-gray-700 text-xl">☰</button>
                    
                    <!-- Desktop Toggle Button -->
                    <button id="desktopToggle" class="hidden md:inline-flex text-base text-gray-700">
                        ⮜
                    </button>
                </div>

                <!-- RIGHT SIDE: Notifications + User info - Smaller -->
                <div class="flex items-center space-x-3">

                    <!-- Notifications -->
                    @auth
                        <div class="relative">
                            <a href="{{ route('communications.index') }}"
                                class="relative text-gray-600 hover:text-green-700 text-sm">
                                🔔
                                @php
                                    $unreadCount = auth()->user()
                                        ->notifications()
                                        ->whereNull('read_at')
                                        ->count();
                                @endphp


                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-2xs px-1 rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endauth

                    <div class="hidden md:block text-right">
                        <p class="text-xs font-medium text-green-800">{{ auth()->user()->name }}</p>
                        <p class="text-2xs text-green-600">
                            {{ ucfirst(auth()->user()->role) }} • {{ auth()->user()->employee_number ?? 'EMP001' }}
                        </p>
                    </div>

                    <div
                        class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>

            </header>

            <!-- Page Body - Smaller padding on mobile -->
            <main class="flex-1 overflow-y-auto p-3 md:p-6">

                @if(session('success'))
                    <x-alert.success class="text-sm">{{ session('success') }}</x-alert.success>
                @endif

                @if(session('error'))
                    <x-alert.error class="text-sm">{{ session('error') }}</x-alert.error>
                @endif

                @if(session('warning'))
                    <x-alert.warning class="text-sm">{{ session('warning') }}</x-alert.warning>
                @endif

                @yield('content')

            </main>

            <!-- Footer - Smaller -->
            <footer class="bg-white border-t py-3 px-4 text-center text-xs text-gray-500">
                © {{ date('Y') }} Makamithi Sacco • Employee Savings & Credit Cooperative Society
            </footer>
        </div>

    </div>

    <!-- MOBILE SIDEBAR - Smaller fonts -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden">
        <div class="w-64 bg-white h-full shadow-xl p-4 overflow-y-auto">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-lg font-semibold text-green-700">Makamithi Sacco</h1>
                <button id="closeMenu" class="text-red-600 text-lg">✖</button>
            </div>

            <p class="text-green-700 text-xs mb-4">
                {{ ucfirst(auth()->user()->role) }} Panel
            </p>

            <nav class="space-y-1">
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
                        <x-nav.link route="communications.index" current="{{ $current }}">📧 Communications</x-nav.link>


                        {{-- CHAIRMAN --}}
                    @elseif($userRole === 'chairman')
                        <x-nav.link route="chairman.dashboard" current="{{ $current }}">📊 Dashboard</x-nav.link>
                        <x-nav.link route="chairman.loan-approvals" current="{{ $current }}">✅ Loan Approvals</x-nav.link>
                        <x-nav.link route="chairman.members" current="{{ $current }}">👥 Members</x-nav.link>
                        <x-nav.link route="reports.index" current="{{ $current }}">📈 Reports</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>
                        <x-nav.link route="communications.index" current="{{ $current }}">📧 Communications</x-nav.link>


                        {{-- TREASURER --}}
                    @elseif($userRole === 'treasurer')
                        <x-nav.link route="treasurer.dashboard" current="{{ $current }}">📊 Treasurer Dashboard</x-nav.link>
                        <!-- ADDED FOR MOBILE -->
                        
                        <x-nav.link route="treasurer.payments" current="{{ $current }}">💳 Payment Processing</x-nav.link>
                        <x-nav.link route="treasurer.loans" current="{{ $current }}">📋 Loans Management</x-nav.link>
                        <x-nav.link route="treasurer.savings" current="{{ $current }}">💰 Savings Summary</x-nav.link>
                        <x-nav.link route="treasurer.treasurer.savings.deductions" current="{{ $current }}">💵 Payroll Deductions</x-nav.link>
                        <x-nav.link route="treasurer.expenses" current="{{ $current }}">📊 Expenses Tracking</x-nav.link>
                        <x-nav.link route="treasurer.cheques" current="{{ $current }}">🏦 Cheque Management</x-nav.link>
                        <x-nav.link route="treasurer.financial-reports" current="{{ $current }}">📈 Financial Reports</x-nav.link>
                        <x-nav.link route="documents.index" current="{{ $current }}">📄 Documents</x-nav.link>
                        <x-nav.link route="communications.index" current="{{ $current }}">📧 Communications</x-nav.link>


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
                    <div class="pt-4 mt-4 border-t border-green-200">
                        <a href="{{ route('settings') }}"
                            class="w-full block text-left px-3 py-1.5 text-green-700 hover:bg-green-100 rounded-lg text-sm">
                            ⚙️ Settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-3 py-1.5 text-red-600 hover:bg-red-100 rounded-lg text-sm">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                @endauth
            </nav>

        </div>
    </div>

    <script>
        // Collapsing functionality
        const sidebar = document.getElementById('sidebar');
        const desktopToggle = document.getElementById('desktopToggle');
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMenu = document.getElementById('closeMenu');

        // Restore sidebar state from localStorage
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('sidebar-collapsed');
            desktopToggle.textContent = '⮞';
        }

        // Desktop toggle for collapsing
        desktopToggle?.addEventListener('click', () => {
            const collapsed = sidebar.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', collapsed);
            desktopToggle.textContent = collapsed ? '⮞' : '⮜';
        });

        // Mobile menu toggle
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
        
        // Add text-2xs utility class if not exists
        const style = document.createElement('style');
        style.textContent = `
            .text-2xs { font-size: 0.625rem; line-height: 0.75rem; }
            @media (max-width: 640px) {
                .text-sm { font-size: 0.75rem; }
                .text-xs { font-size: 0.65rem; }
                h1, .text-lg { font-size: 1rem; }
                h2, .text-xl { font-size: 1.125rem; }
                h3, .text-2xl { font-size: 1.25rem; }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>

</html>