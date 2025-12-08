@extends('components.dashboard-layout')

@section('title', 'Chairman Dashboard')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Chairman Dashboard</h1>
                <p class="text-gray-500 mt-1">
                    Welcome back, {{ auth()->user()->name }} — review ongoing member loan activities.
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
                ['title' => 'Pending Approvals', 'value' => 12, 'icon' => '⏳'],
                ['title' => 'Approved This Month', 'value' => 8, 'icon' => '✔️'],
                ['title' => 'Total Members', 'value' => 156, 'icon' => '👥'],
                ['title' => 'Active Loans', 'value' => 89, 'icon' => '💰']
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

    <!-- Pending Loans -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Pending Loan Approvals</h2>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                View All
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Member</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Loan</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Period</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Applied</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @for($i = 1; $i <= 5; $i++)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 font-semibold">
                                    JM
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">John Mule</p>
                                    <p class="text-gray-500 text-xs">EMP00{{ $i }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">
                                KES {{ number_format(150000 + ($i * 50000), 2) }}
                            </p>
                            <p class="text-gray-500 text-xs">
                                Savings: KES {{ number_format(100000 + ($i * 20000), 2) }}
                            </p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ 12 + ($i * 6) }} months</p>
                            <p class="text-gray-500 text-xs">
                                Monthly: KES {{ number_format((150000 + ($i * 50000)) * 1.05 / (12 + ($i * 6)), 2) }}
                            </p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ now()->subDays($i)->format('d M Y') }}</p>
                            <p class="text-gray-500 text-xs">{{ $i }} day(s) ago</p>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button class="px-3 py-2 bg-gray-900 text-white rounded-lg text-xs font-medium hover:bg-gray-800 transition">
                                    Approve
                                </button>
                                <button class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-300 transition">
                                    Reject
                                </button>
                                <button class="px-3 py-2 bg-gray-100 text-gray-800 rounded-lg text-xs font-medium hover:bg-gray-200 transition">
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

    <!-- Activity + Reports -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Recent Activity -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                @for($i = 1; $i <= 4; $i++)
                <div class="flex items-start">
                    <div class="p-2 rounded-full bg-gray-100 mr-3 text-lg">
                        {{ $i % 2 == 0 ? '✔️' : '📝' }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">
                            {{ $i % 2 == 0 ? 'Loan Approved' : 'Loan Application Received' }}
                        </p>
                        <p class="text-gray-600 text-sm">Jane Doe — KES {{ number_format(200000, 2) }}</p>
                        <p class="text-gray-400 text-xs">{{ now()->subHours($i * 2)->format('h:i A') }}</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Quick Reports -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Reports</h3>

            @php
                $reports = [
                    ['icon' => '📊', 'label' => 'Generate Financial Report'],
                    ['icon' => '💰', 'label' => 'Loan Performance'],
                    ['icon' => '👥', 'label' => 'Member Statistics'],
                    ['icon' => '📈', 'label' => 'Savings Growth'],
                ];
            @endphp

            <div class="space-y-3">
                @foreach ($reports as $rp)
                <button class="w-full flex items-center justify-center gap-2 bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                    {{ $rp['icon'] }} {{ $rp['label'] }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
