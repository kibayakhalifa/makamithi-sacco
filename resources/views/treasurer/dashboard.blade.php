@extends('components.dashboard-layout')

@section('title', 'Treasurer Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Treasurer Dashboard</h1>
                <p class="text-green-100 mt-2">Welcome, {{ auth()->user()->name }}! Manage payments and finances</p>
            </div>
            <div class="text-right">
                <p class="text-green-100">Sacco Balance</p>
                <p class="text-2xl font-bold">KES 12,450,000.00</p>
            </div>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Savings</h3>
                    <p class="text-3xl font-bold mt-2">KES 8,240,000</p>
                    <p class="text-green-600 text-sm mt-1">↑ 12% from last month</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <span class="text-green-600 text-2xl">💰</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Active Loans</h3>
                    <p class="text-3xl font-bold mt-2">KES 4,210,000</p>
                    <p class="text-blue-600 text-sm mt-1">89 active loans</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <span class="text-blue-600 text-2xl">📝</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Pending Payments</h3>
                    <p class="text-3xl font-bold mt-2">KES 450,000</p>
                    <p class="text-yellow-600 text-sm mt-1">15 pending cheques</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <span class="text-yellow-600 text-2xl">⏳</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Pending Payments to Process</h2>
            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold">
                Process All Payments
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Payment Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Member</th>
                        <th class="px-6 py-3 text-left text-xs fontibold text-gray-600 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Approved On</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @for($i = 1; $i <= 6; $i++)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full {{ $i % 2 == 0 ? 'bg-blue-100' : 'bg-purple-100' }} mr-3">
                                    <span class="{{ $i % 2 == 0 ? 'text-blue-600' : 'text-purple-600' }}">
                                        {{ $i % 2 == 0 ? '💰' : '🏦' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $i % 2 == 0 ? 'Loan Disbursement' : 'Savings Withdrawal' }}</p>
                                    <p class="text-gray-500 text-sm">{{ $i % 2 == 0 ? 'New Loan' : 'Member Exit' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold">Member {{ $i }}</p>
                            <p class="text-gray-500 text-sm">EMP00{{ $i }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold">KES {{ number_format(150000 + ($i * 25000), 2) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>{{ now()->subDays($i)->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $i % 3 == 0 ? 'bg-yellow-100 text-yellow-800' : 
                                   ($i % 3 == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $i % 3 == 0 ? 'Pending' : ($i % 3 == 1 ? 'Approved' : 'Ready') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    Issue Cheque
                                </button>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    View Details
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Financial Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Bank Reconciliation</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span>Total Bank Balance</span>
                    <span class="font-bold">KES 12,450,000.00</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span>System Balance</span>
                    <span class="font-bold">KES 12,420,500.00</span>
                </div>
                <div class="flex justify-between items-center p-3 {{ 12450000 - 12420500 > 0 ? 'bg-red-50' : 'bg-green-50' }} rounded-lg">
                    <span>Difference</span>
                    <span class="font-bold {{ 12450000 - 12420500 > 0 ? 'text-red-600' : 'text-green-600' }}">
                        KES {{ number_format(12450000 - 12420500, 2) }}
                    </span>
                </div>
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold">
                    Reconcile Accounts
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Financial Actions</h3>
            <div class="space-y-3">
                <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    🏦 Bank Deposit Slip
                </button>
                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📄 Generate Financial Report
                </button>
                <button class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    💸 Record Expense
                </button>
                <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📊 View Cash Flow
                </button>
            </div>
        </div>
    </div>
</div>
@endsection