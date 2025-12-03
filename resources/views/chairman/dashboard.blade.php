@extends('components.dashboard-layout')

@section('title', 'Chairman Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Chairman Dashboard</h1>
                <p class="text-purple-100 mt-2">Welcome, {{ auth()->user()->name }}! Review and approve loan applications</p>
            </div>
            <div class="text-right">
                <p class="text-purple-100">Today's Date</p>
                <p class="text-2xl font-bold">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Pending Approvals</h3>
                    <p class="text-3xl font-bold mt-2">12</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <span class="text-blue-600 text-2xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Approved This Month</h3>
                    <p class="text-3xl font-bold mt-2">8</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <span class="text-green-600 text-2xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Members</h3>
                    <p class="text-3xl font-bold mt-2">156</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <span class="text-yellow-600 text-2xl">👥</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Active Loans</h3>
                    <p class="text-3xl font-bold mt-2">89</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <span class="text-red-600 text-2xl">💰</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Approvals Table -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Pending Loan Approvals</h2>
            <button class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold">
                View All Approvals
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Loan Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Period</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Applied On</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @for($i = 1; $i <= 5; $i++)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-bold">JM</span>
                                </div>
                                <div>
                                    <p class="font-semibold">John Mule</p>
                                    <p class="text-gray-500 text-sm">EMP00{{ $i }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold">KES {{ number_format(150000 + ($i * 50000), 2) }}</p>
                            <p class="text-gray-500 text-sm">Savings: KES {{ number_format(100000 + ($i * 20000), 2) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>{{ 12 + ($i * 6) }} months</p>
                            <p class="text-gray-500 text-sm">Monthly: KES {{ number_format((150000 + ($i * 50000)) * 1.05 / (12 + ($i * 6)), 2) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>{{ now()->subDays($i)->format('d M Y') }}</p>
                            <p class="text-gray-500 text-sm">{{ $i }} day(s) ago</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    Approve
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    Reject
                                </button>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    View
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                @for($i = 1; $i <= 4; $i++)
                <div class="flex items-start">
                    <div class="p-2 rounded-full {{ $i % 2 == 0 ? 'bg-green-100' : 'bg-blue-100' }} mr-3">
                        <span class="{{ $i % 2 == 0 ? 'text-green-600' : 'text-blue-600' }}">
                            {{ $i % 2 == 0 ? '✅' : '📝' }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">{{ $i % 2 == 0 ? 'Loan Approved' : 'Loan Application Received' }}</p>
                        <p class="text-gray-600 text-sm">Jane Doe - KES {{ number_format(200000, 2) }}</p>
                        <p class="text-gray-400 text-xs">{{ now()->subHours($i * 2)->format('h:i A') }}</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Reports</h3>
            <div class="space-y-3">
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📊 Generate Financial Report
                </button>
                <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    💰 Loan Performance
                </button>
                <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    👥 Member Statistics
                </button>
                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📈 Savings Growth
                </button>
            </div>
        </div>
    </div>
</div>
@endsection