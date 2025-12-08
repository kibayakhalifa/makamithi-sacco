@extends('components.dashboard-layout')

@section('title', 'My Savings')

@section('content')
<div class="space-y-8 font-sans">

    <!-- Savings Overview -->
    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <div>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">My Savings Account</h1>
            <p class="text-gray-500 mt-1">Track contributions, withdrawals, and growth over time.</p>
        </div>
        <div class="text-center md:text-right">
            <p class="text-gray-400 text-sm">Total Balance</p>
            <p class="text-3xl md:text-4xl font-bold text-gray-900">KES 150,000.00</p>
            <p class="text-gray-400 text-xs mt-1">Last updated: {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    <!-- Key Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase">Monthly Contribution</p>
                    <p class="text-xl font-semibold text-gray-900 mt-1">KES 5,000</p>
                    <p class="text-green-500 text-xs mt-0.5">Payroll deduction</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <span class="text-green-600 text-xl">💳</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase">Year-to-Date</p>
                    <p class="text-xl font-semibold text-gray-900 mt-1">KES 60,000</p>
                    <p class="text-blue-500 text-xs mt-0.5">Since Jan {{ date('Y') }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <span class="text-blue-600 text-xl">📅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase">Interest Earned</p>
                    <p class="text-xl font-semibold text-gray-900 mt-1">KES 12,500</p>
                    <p class="text-yellow-500 text-xs mt-0.5">Annual @ 5%</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-full">
                    <span class="text-yellow-600 text-xl">📈</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500 hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase">Loan Qualification</p>
                    <p class="text-xl font-semibold text-gray-900 mt-1">KES 225,000</p>
                    <p class="text-purple-500 text-xs mt-0.5">1.5× savings rule</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <span class="text-purple-600 text-xl">🏦</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Top Up Savings -->
        <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">💎 Top Up Savings</h3>
            <p class="text-gray-500 mb-4">Add extra savings to your account easily.</p>
            <div class="space-y-4">
                <input type="number" placeholder="Enter amount (KES)" min="100" step="100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-transparent">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option>M-Pesa</option>
                    <option>Bank Transfer</option>
                    <option>Cheque</option>
                    <option>Cash</option>
                </select>
                <button class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-medium transition">💰 Top Up Now</button>
            </div>
        </div>

        <!-- Withdrawal Request -->
        <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">🏧 Withdrawal Request</h3>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 text-sm text-yellow-800 rounded">
                ⚠️ Withdrawals allowed only on resignation, retirement, or death. KES 2,000 retention fee applies.
            </div>
            <div class="space-y-4">
                <input type="number" placeholder="Withdrawal Amount" max="148000" min="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option>Resignation</option>
                    <option>Retirement</option>
                    <option>Medical Emergency</option>
                    <option>Other</option>
                </select>
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-medium transition">📝 Submit Withdrawal</button>
            </div>
        </div>

        <!-- Savings Growth Overview -->
        <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">📊 Savings Growth</h3>
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-500 mb-1">
                    <span>Annual Growth</span>
                    <span>15.8%</span>
                </div>
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width: 65%"></div>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between bg-gray-50 p-2 rounded-lg"><span>This Month</span><span class="font-semibold">KES 5,000</span></div>
                <div class="flex justify-between bg-gray-50 p-2 rounded-lg"><span>Last Month</span><span class="font-semibold">KES 5,000</span></div>
                <div class="flex justify-between bg-gray-50 p-2 rounded-lg"><span>Year Total</span><span class="font-semibold">KES 60,000</span></div>
            </div>
            <div class="mt-4 space-y-2">
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded-lg font-medium transition">📄 Download Statement</button>
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded-lg font-medium transition">📧 Email Summary</button>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
            <div class="flex items-center space-x-2">
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                    <option>This year</option>
                    <option>All time</option>
                </select>
                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-medium">Export CSV</button>
            </div>
        </div>

        @php
            $transactions = $transactions ?? [
                ['date' => now()->format('d M Y'), 'desc' => 'Payroll Contribution', 'type' => 'Deposit', 'amount' => 5000, 'balance' => 150000, 'status' => 'Completed'],
                ['date' => now()->subDays(2)->format('d M Y'), 'desc' => 'Interest Earned', 'type' => 'Interest', 'amount' => 1250, 'balance' => 145000, 'status' => 'Completed'],
                ['date' => now()->subDays(5)->format('d M Y'), 'desc' => 'Manual Top-up', 'type' => 'Deposit', 'amount' => 10000, 'balance' => 143750, 'status' => 'Completed'],
            ];
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Balance</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($transactions as $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $t['date'] }}</td>
                            <td class="px-4 py-2">{{ $t['desc'] }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $t['type']=='Deposit'?'bg-green-100 text-green-800':($t['type']=='Interest'?'bg-blue-100 text-blue-800':'bg-red-100 text-red-800') }}">
                                    {{ $t['type'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2 {{ $t['amount']>0?'text-green-600':'text-red-600' }}">
                                {{ $t['amount']>0?'+':'' }}KES {{ number_format($t['amount'],2) }}
                            </td>
                            <td class="px-4 py-2">KES {{ number_format($t['balance'],2) }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $t['status']=='Completed'?'bg-green-100 text-green-800':'bg-yellow-100 text-yellow-800' }}">
                                    {{ $t['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition">Load More Transactions</button>
        </div>
    </div>

</div>
@endsection
