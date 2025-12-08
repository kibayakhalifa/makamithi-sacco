@extends('components.dashboard-layout')

@section('title', 'Member Dashboard')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Member Dashboard</h1>
                <p class="text-gray-500 mt-1">
                    Welcome {{ auth()->user()->name }} — here is an overview of your savings and loan status.
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Today</p>
                <p class="text-xl font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $stats = [
                ['title' => 'Total Savings', 'value' => 'KES 450,000', 'icon' => '💰'],
                ['title' => 'Active Loans', 'value' => 2, 'icon' => '📄'],
                ['title' => 'Loan Balance', 'value' => 'KES 120,500', 'icon' => '💸'],
                ['title' => 'Withdrawable Amount', 'value' => 'KES 60,000', 'icon' => '🏦'],
            ];
        @endphp

        @foreach ($stats as $stat)
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ $stat['title'] }}</p>
                    <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stat['value'] }}</p>
                </div>
                <div class="text-3xl">{{ $stat['icon'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Savings Activity -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Recent Savings Activity</h2>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                View All
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Date</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Amount</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Type</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @for($i = 1; $i <= 5; $i++)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ now()->subDays($i)->format('d M Y') }}</p>
                            <p class="text-gray-500 text-xs">{{ $i }} day(s) ago</p>
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-900">
                            KES {{ number_format(10000 + ($i * 2000), 2) }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-gray-700">Monthly Contribution</span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                Successful
                            </span>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Loans + Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Active Loans -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Active Loans</h3>

            <div class="space-y-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">
                                KES {{ number_format(50000 + ($i * 30000), 2) }}
                            </p>
                            <p class="text-gray-500 text-xs">Duration: {{ 6 + ($i * 6) }} months</p>
                        </div>

                        <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            Active
                        </span>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

            <div class="space-y-3">
                <a href="{{ route('loans.apply') }}"
                   class="w-full flex items-center justify-center gap-2 bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                    📝 Apply for a Loan
                </a>

                <a href="{{ route('savings.index') }}"
                   class="w-full flex items-center justify-center gap-2 bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">
                    💰 View Savings
                </a>

                <button class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-800 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                    📄 Download Statement
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
