@extends('components.dashboard-layout')

@section('title', 'Member Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100 mt-2">
                    Member No: {{ auth()->user()->employee_number ?? 'EMP001' }} | 
                    Role: {{ ucfirst(auth()->user()->role) }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-blue-100">Today's Date</p>
                <p class="text-2xl font-bold">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">My Savings</h3>
                    <p class="text-3xl font-bold mt-2">KES 150,000.00</p>
                    <p class="text-green-600 text-sm mt-1">Qualifies for: KES 225,000.00 loan</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <span class="text-green-600 text-2xl">💰</span>
                </div>
            </div>
            <button class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition">
                View Savings Details
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Active Loans</h3>
                    <p class="text-3xl font-bold mt-2">KES 75,000.00</p>
                    <p class="text-red-600 text-sm mt-1">1 active loan</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <span class="text-red-600 text-2xl">📝</span>
                </div>
            </div>
            <button class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-semibold transition">
                View Loan Details
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Quick Actions</h3>
            <div class="mt-4 space-y-3">
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition">
                    📝 Apply for Loan
                </button>
                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition">
                    💰 Top Up Savings
                </button>
                <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold transition">
                    📄 Download Statement
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Activity</h2>
        <div class="space-y-4">
            @php
                $activities = [
                    ['icon' => '💰', 'color' => 'green', 'title' => 'Savings Contribution', 'desc' => 'KES 5,000 added to savings', 'time' => '2 hours ago'],
                    ['icon' => '📝', 'color' => 'blue', 'title' => 'Loan Repayment', 'desc' => 'KES 6,562.50 paid', 'time' => '1 day ago'],
                    ['icon' => '✅', 'color' => 'green', 'title' => 'Loan Approved', 'desc' => 'KES 150,000 loan approved', 'time' => '3 days ago'],
                    ['icon' => '💰', 'color' => 'green', 'title' => 'Savings Contribution', 'desc' => 'KES 5,000 added to savings', 'time' => '1 week ago'],
                    ['icon' => '📊', 'color' => 'purple', 'title' => 'Statement Generated', 'desc' => 'Monthly statement ready', 'time' => '2 weeks ago'],
                ];
            @endphp
            
            @foreach($activities as $activity)
            <div class="flex items-start p-4 hover:bg-gray-50 rounded-lg border">
                <div class="p-3 rounded-full bg-{{ $activity['color'] }}-100 mr-4">
                    <span class="text-{{ $activity['color'] }}-600 text-xl">
                        {{ $activity['icon'] }}
                    </span>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $activity['title'] }}</h4>
                    <p class="text-gray-600">{{ $activity['desc'] }}</p>
                    <p class="text-gray-400 text-sm mt-1">{{ $activity['time'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Loan Information -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Active Loan Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="font-bold text-lg mb-4">Loan Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Original Amount:</span>
                        <span class="font-bold">KES 150,000.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Current Balance:</span>
                        <span class="font-bold">KES 107,500.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Monthly Payment:</span>
                        <span class="font-bold">KES 6,562.50</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Interest Rate:</span>
                        <span class="font-bold text-green-600">5% Fixed</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="font-bold text-lg mb-4">Next Payment</h3>
                <div class="text-center">
                    <div class="text-4xl mb-2">📅</div>
                    <p class="text-2xl font-bold">{{ now()->addDays(5)->format('d M Y') }}</p>
                    <p class="text-gray-600 mt-2">in 5 days</p>
                    <p class="text-3xl font-bold mt-4">KES 6,562.50</p>
                    <button class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold">
                        Pay Early
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mt-6">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Repayment Progress</span>
                <span>28.3% Complete</span>
            </div>
            <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full" style="width: 28.3%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-2">KES 42,500 repaid of KES 150,000</p>
        </div>
    </div>
</div>
@endsection