@extends('components.dashboard-layout')

@section('title', 'Secretary Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Secretary Dashboard</h1>
                <p class="text-indigo-100 mt-2">Welcome, {{ auth()->user()->name }}! Manage member records and communications</p>
            </div>
            <div class="text-right">
                <p class="text-indigo-100">New Members This Month</p>
                <p class="text-2xl font-bold">5</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Members</h3>
                    <p class="text-3xl font-bold mt-2">156</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <span class="text-indigo-600 text-2xl">👥</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Active Members</h3>
                    <p class="text-3xl font-bold mt-2">148</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <span class="text-green-600 text-2xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Pending Updates</h3>
                    <p class="text-3xl font-bold mt-2">23</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <span class="text-yellow-600 text-2xl">📝</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Exited Members</h3>
                    <p class="text-3xl font-bold mt-2">8</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <span class="text-red-600 text-2xl">🚪</span>
                </div>
            </div>
        </div>
    </div>

    <!-- New Member Registrations -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">New Member Registrations</h2>
            <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold">
                Register New Member
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Join Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @for($i = 1; $i <= 5; $i++)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-indigo-600 font-bold">M{{ $i }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold">New Member {{ $i }}</p>
                                    <p class="text-gray-500 text-sm">EMP{{ 200 + $i }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p>{{ ['Finance', 'HR', 'IT', 'Operations', 'Sales'][$i-1] }}</p>
                            <p class="text-gray-500 text-sm">Makamithi Enterprises</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>{{ now()->subDays($i*2)->format('d M Y') }}</p>
                            <p class="text-gray-500 text-sm">{{ $i*2 }} days ago</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $i % 3 == 0 ? 'bg-yellow-100 text-yellow-800' : 
                                   ($i % 3 == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $i % 3 == 0 ? 'Pending' : ($i % 3 == 1 ? 'Active' : 'Verified') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                                    Activate
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
            <h3 class="text-lg font-bold text-gray-800 mb-4">Communication Tasks</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-blue-500 mr-3">📧</span>
                        <span>Pending Emails</span>
                    </div>
                    <span class="font-bold">12</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-green-500 mr-3">📱</span>
                        <span>SMS to Send</span>
                    </div>
                    <span class="font-bold">8</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-3">📄</span>
                        <span>Documents to Process</span>
                    </div>
                    <span class="font-bold">15</span>
                </div>
                <button class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-lg font-semibold">
                    Send Bulk Notification
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Secretary Actions</h3>
            <div class="space-y-3">
                <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📋 Meeting Minutes
                </button>
                <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    👥 Member Directory
                </button>
                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📊 Reports Generation
                </button>
                <button class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center">
                    📁 Document Archive
                </button>
            </div>
        </div>
    </div>
</div>
@endsection