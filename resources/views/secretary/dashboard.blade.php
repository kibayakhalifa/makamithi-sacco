@extends('components.dashboard-layout')

@section('title', 'Secretary Dashboard')

@section('content')
<div class="space-y-6 md:space-y-8">

    <!-- Header with Quick Actions -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 tracking-tight">Secretary Dashboard</h1>
                <p class="text-gray-500 mt-1 text-sm md:text-base">
                    Hello {{ auth()->user()->name }} — manage members, communications, and SACCO operations.
                </p>
            </div>
            <div class="text-right mt-4 md:mt-0">
                <p class="text-sm text-gray-500">Today</p>
                <p class="text-xl font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ now()->format('l') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Add New Member -->
        <a href="{{ route('secretary.members') }}" class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-2xl bg-gray-900 flex items-center justify-center mr-4 group-hover:bg-gray-800 transition-colors">
                    <span class="text-2xl text-white">👤</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Add Member</h3>
                    <p class="text-sm text-gray-500">Register new employees</p>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                <span class="flex items-center">
                    <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                    Requires Chairman approval
                </span>
            </div>
        </a>

        <!-- Loan Assistance -->
        <a href="{{ route('secretary.loan-assist') }}" class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-2xl bg-gray-800 flex items-center justify-center mr-4 group-hover:bg-gray-700 transition-colors">
                    <span class="text-2xl text-white">🤝</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Loan Assistance</h3>
                    <p class="text-sm text-gray-500">Help members apply</p>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                <span class="flex items-center">
                    <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                    1.5× savings rule applies
                </span>
            </div>
        </a>

        

        <!-- Communications -->
        <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-md transition-all duration-200 group cursor-pointer" onclick="openCommunications()">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-2xl bg-gray-900 flex items-center justify-center mr-4 group-hover:bg-gray-800 transition-colors">
                    <span class="text-2xl text-white">📨</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Communications</h3>
                    <p class="text-sm text-gray-500">Send notifications</p>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                <span class="flex items-center">
                    <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                    SMS & Email ready
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total Members -->
        <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Members</p>
                    <p class="text-2xl md:text-3xl font-semibold mt-2 text-gray-900">156</p>
                    <p class="text-xs text-gray-600 mt-1 flex items-center">
                        <span class="w-2 h-2 bg-gray-600 rounded-full mr-1"></span>
                        +12 this month
                    </p>
                </div>
                <div class="text-2xl md:text-3xl text-gray-300">👥</div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Active: 148</span>
                    <span>Pending: 8</span>
                </div>
            </div>
        </div>

        <!-- Total Savings -->
        <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Savings</p>
                    <p class="text-2xl md:text-3xl font-semibold mt-2 text-gray-900">KES 4.5M</p>
                    <p class="text-xs text-gray-600 mt-1 flex items-center">
                        <span class="w-2 h-2 bg-gray-600 rounded-full mr-1"></span>
                        +KES 150K this month
                    </p>
                </div>
                <div class="text-2xl md:text-3xl text-gray-300">💰</div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Payroll: KES 4.2M</span>
                    <span>Top-up: KES 300K</span>
                </div>
            </div>
        </div>

        <!-- Active Loans -->
        <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Active Loans</p>
                    <p class="text-2xl md:text-3xl font-semibold mt-2 text-gray-900">KES 3.8M</p>
                    <p class="text-xs text-gray-600 mt-1 flex items-center">
                        <span class="w-2 h-2 bg-gray-600 rounded-full mr-1"></span>
                        24 active loans
                    </p>
                </div>
                <div class="text-2xl md:text-3xl text-gray-300">📝</div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Normal: 22</span>
                    <span>Top-up: 2</span>
                </div>
            </div>
        </div>

        <!-- Meeting Schedule -->
        <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Next Meeting</p>
                    <p class="text-lg md:text-xl font-semibold mt-2 text-gray-900">15 Apr 2024</p>
                    <p class="text-xs text-gray-500 mt-1">Monday, 2:00 PM</p>
                </div>
                <div class="text-2xl md:text-3xl text-gray-300">📅</div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Agenda: Loan approvals</span>
                    <span class="font-medium text-gray-700">Prepare</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Pending Member Approvals -->
            <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Pending Member Approvals</h3>
                        <p class="text-sm text-gray-500">Awaiting Chairman review</p>
                    </div>
                    <a href="{{ route('secretary.pending-approvals') }}" class="text-sm text-gray-900 font-medium hover:text-gray-700 transition-colors">
                        View all →
                    </a>
                </div>

                <div class="space-y-4">
                    @php
                        $pendingMembers = [
                            ['name' => 'Michael Otieno', 'emp' => 'EMP011', 'dept' => 'Finance', 'days' => 2],
                            ['name' => 'Susan Njeru', 'emp' => 'EMP012', 'dept' => 'Marketing', 'days' => 1],
                            ['name' => 'David Kiprop', 'emp' => 'EMP013', 'dept' => 'IT', 'days' => 0],
                        ];
                    @endphp

                    @foreach($pendingMembers as $member)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all duration-200 group">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                <span class="text-gray-700 font-medium">{{ substr($member['name'], 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $member['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $member['emp'] }} • {{ $member['dept'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                                {{ $member['days'] == 0 ? 'Today' : $member['days'] . ' days ago' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Assisted Loans -->
            <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Assisted Loans</h3>
                        <p class="text-sm text-gray-500">Applications you helped with</p>
                    </div>
                    <span class="text-sm text-gray-900 font-medium">
                        Total: 24
                    </span>
                </div>

                <div class="space-y-4">
                    @php
                        $assistedLoans = [
                            ['member' => 'John Doe', 'amount' => 150000, 'date' => '2 days ago', 'status' => 'approved'],
                            ['member' => 'Jane Smith', 'amount' => 75000, 'date' => '1 day ago', 'status' => 'processing'],
                            ['member' => 'Robert Johnson', 'amount' => 200000, 'date' => '3 days ago', 'status' => 'pending'],
                        ];
                    @endphp

                    @foreach($assistedLoans as $loan)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all duration-200 group">
                        <div class="mb-2 sm:mb-0">
                            <p class="font-medium text-gray-900">{{ $loan['member'] }}</p>
                            <p class="text-sm text-gray-500">KES {{ number_format($loan['amount']) }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium 
                                {{ $loan['status'] == 'approved' ? 'bg-gray-100 text-gray-700' : 
                                   ($loan['status'] == 'processing' ? 'bg-gray-100 text-gray-700' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($loan['status']) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $loan['date'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Member Statistics -->
            <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Member Status Overview</h3>
                <p class="text-sm text-gray-500">Quick insights on member activities</p>
            </div>

            <div class="space-y-4">
                @php
                $memberStats = [
                    ['label' => 'New Applications This Month', 'value' => '12', 'icon' => '📥', 'color' => 'bg-blue-50 border-blue-200'],
                    ['label' => 'Members Requiring Follow-up', 'value' => '8', 'icon' => '📞', 'color' => 'bg-orange-50 border-orange-200'],
                    ['label' => 'Overdue Loan Payments', 'value' => '3', 'icon' => '⏰', 'color' => 'bg-red-50 border-red-200'],
                    ['label' => 'Pending Documentation', 'value' => '5', 'icon' => '📄', 'color' => 'bg-yellow-50 border-yellow-200'],
                ];
                @endphp

                @foreach($memberStats as $stat)
                <div class="p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all duration-200 group">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                        <span class="text-lg">{{ $stat['icon'] }}</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ $stat['label'] }}</p>
                    </div>
                    </div>
                    <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-900 font-semibold text-sm">{{ $stat['value'] }}</span>
                    <a href="#" class="text-xs text-gray-500 hover:text-gray-700 transition-colors">View →</a>
                    </div>
                </div>
                </div>
                @endforeach
            </div>
            </div>


            <!-- Quick Communications -->
            <div class="bg-white border border-gray-100 rounded-3xl p-5 md:p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Communications</h3>
                    <p class="text-sm text-gray-500">Send notifications to members</p>
                </div>

                <div class="space-y-4">
                    <!-- SMS Notification -->
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center mr-2">
                                    <span class="text-gray-700">📱</span>
                                </div>
                                <span class="font-medium text-gray-900">SMS Notification</span>
                            </div>
                            <span class="text-xs text-gray-500">Remaining: 98</span>
                        </div>
                        <textarea class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:border-gray-400 focus:ring-0 transition-colors resize-none" 
                                  rows="2" placeholder="Type your message here..."></textarea>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mt-3">
                            <select class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-white focus:border-gray-400 focus:ring-0 transition-colors">
                                <option>Select Members</option>
                                <option>All Members</option>
                                <option>Pending Approvals</option>
                                <option>Loan Applicants</option>
                            </select>
                            <button class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                                Send SMS
                            </button>
                        </div>
                    </div>

                    <!-- Email Notification -->
                    <div class="border border-gray-100 rounded-2xl p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center mr-2">
                                    <span class="text-gray-700">✉️</span>
                                </div>
                                <span class="font-medium text-gray-900">Email Notification</span>
                            </div>
                        </div>
                        <input type="text" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm mb-2 focus:border-gray-400 focus:ring-0 transition-colors" 
                               placeholder="Subject">
                        <textarea class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:border-gray-400 focus:ring-0 transition-colors resize-none" 
                                  rows="2" placeholder="Email content..."></textarea>
                        <div class="flex justify-end mt-3">
                            <button class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                                Send Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Communications Modal -->
<div id="communicationsModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Send Communications</h3>
                <button onclick="closeCommunications()" 
                        class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <span class="text-gray-500 hover:text-gray-700">✕</span>
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Send notifications to SACCO members</p>
        </div>

        <div class="p-6 space-y-6">
            <!-- Communication Type -->
            <div>
                <h4 class="text-lg font-medium text-gray-900 mb-4">Select Communication Type</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button class="p-4 border border-gray-200 rounded-2xl hover:border-gray-300 transition-all duration-200 text-left group"
                            onclick="selectCommType('sms')">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                <span class="text-gray-700">📱</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">SMS Notification</p>
                                <p class="text-sm text-gray-500">Quick text messages</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">Ideal for urgent updates</p>
                    </button>
                    <button class="p-4 border border-gray-200 rounded-2xl hover:border-gray-300 transition-all duration-200 text-left group"
                            onclick="selectCommType('email')">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                <span class="text-gray-700">✉️</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Email Notification</p>
                                <p class="text-sm text-gray-500">Detailed communications</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">For formal announcements</p>
                    </button>
                </div>
            </div>

            <!-- Recipient Selection -->
            <div id="recipientSection" class="hidden">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Select Recipients</h4>
                <div class="space-y-3">
                    <div class="flex items-center p-3 border border-gray-200 rounded-2xl hover:bg-gray-50 cursor-pointer group transition-colors">
                        <div class="w-5 h-5 rounded border-2 border-gray-300 mr-3 flex items-center justify-center group-has-[input:checked]:bg-gray-900 group-has-[input:checked]:border-gray-900 transition-colors">
                            <svg class="w-3 h-3 text-white opacity-0 group-has-[input:checked]:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <input type="checkbox" class="sr-only">
                        <span class="font-medium text-gray-900">All Members (156)</span>
                    </div>
                    <div class="flex items-center p-3 border border-gray-200 rounded-2xl hover:bg-gray-50 cursor-pointer group transition-colors">
                        <div class="w-5 h-5 rounded border-2 border-gray-300 mr-3 flex items-center justify-center group-has-[input:checked]:bg-gray-900 group-has-[input:checked]:border-gray-900 transition-colors">
                            <svg class="w-3 h-3 text-white opacity-0 group-has-[input:checked]:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <input type="checkbox" class="sr-only">
                        <span class="font-medium text-gray-900">Pending Approvals (8)</span>
                    </div>
                    <div class="flex items-center p-3 border border-gray-200 rounded-2xl hover:bg-gray-50 cursor-pointer group transition-colors">
                        <div class="w-5 h-5 rounded border-2 border-gray-300 mr-3 flex items-center justify-center group-has-[input:checked]:bg-gray-900 group-has-[input:checked]:border-gray-900 transition-colors">
                            <svg class="w-3 h-3 text-white opacity-0 group-has-[input:checked]:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <input type="checkbox" class="sr-only">
                        <span class="font-medium text-gray-900">Active Loan Holders (24)</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 p-3 border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 mr-3"></div>
                            <span class="font-medium text-gray-900">Specific Department</span>
                        </div>
                        <select class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-white focus:border-gray-400 focus:ring-0 transition-colors">
                            <option>Select Department</option>
                            <option>Finance</option>
                            <option>Operations</option>
                            <option>HR</option>
                            <option>IT</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div id="messageSection" class="hidden">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Message Content</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject (Email only)</label>
                    <input type="text" id="messageSubject"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-gray-400 focus:ring-0 transition-colors mb-4"
                           placeholder="Meeting announcement, loan approval, etc.">
                    
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea id="messageContent" rows="4"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:border-gray-400 focus:ring-0 transition-colors resize-none"
                              placeholder="Type your message here..."></textarea>
                    <p class="text-xs text-gray-400 mt-2" id="charCount">0/160 characters</p>
                </div>

                <!-- Template Suggestions -->
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Quick Templates:</p>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="useTemplate('meeting')" class="px-3 py-2 border border-gray-200 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                            📅 Meeting Reminder
                        </button>
                        <button onclick="useTemplate('approval')" class="px-3 py-2 border border-gray-200 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                            ✅ Loan Approved
                        </button>
                        <button onclick="useTemplate('payment')" class="px-3 py-2 border border-gray-200 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                            💳 Payment Due
                        </button>
                        <button onclick="useTemplate('savings')" class="px-3 py-2 border border-gray-200 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                            💰 Savings Update
                        </button>
                    </div>
                </div>
            </div>

            <!-- Preview & Send -->
            <div id="previewSection" class="hidden">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Preview & Send</h4>
                <div class="bg-gray-50 p-4 rounded-2xl mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <div class="bg-white p-4 rounded-2xl border border-gray-200">
                        <p class="font-medium text-gray-900 mb-1" id="previewSubject"></p>
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed" id="previewMessage"></p>
                    </div>
                    <p class="text-xs text-gray-500 mt-2" id="previewRecipients"></p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6 border-t border-gray-100">
                <button onclick="prevCommStep()" id="prevBtn" class="hidden px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200">
                    ← Back
                </button>
                <button onclick="nextCommStep()" id="nextBtn" class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                    Next: Select Recipients →
                </button>
                <button onclick="sendCommunication()" id="sendBtn" class="hidden px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow flex items-center">
                    <span class="mr-2">📤</span>
                    Send Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Communications Modal
    let currentStep = 0;
    let commType = '';

    function openCommunications() {
        document.getElementById('communicationsModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetCommSteps();
    }

    function closeCommunications() {
        document.getElementById('communicationsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetCommSteps();
    }

    function resetCommSteps() {
        currentStep = 0;
        commType = '';
        document.getElementById('recipientSection').classList.add('hidden');
        document.getElementById('messageSection').classList.add('hidden');
        document.getElementById('previewSection').classList.add('hidden');
        document.getElementById('prevBtn').classList.add('hidden');
        document.getElementById('sendBtn').classList.add('hidden');
        document.getElementById('nextBtn').classList.remove('hidden');
        document.getElementById('nextBtn').textContent = 'Next: Select Recipients →';
    }

    function selectCommType(type) {
        commType = type;
        nextCommStep();
    }

    function nextCommStep() {
        currentStep++;
        
        if (currentStep === 1) {
            document.getElementById('recipientSection').classList.remove('hidden');
            document.getElementById('prevBtn').classList.remove('hidden');
            document.getElementById('nextBtn').textContent = 'Next: Compose Message →';
        } else if (currentStep === 2) {
            document.getElementById('messageSection').classList.remove('hidden');
            document.getElementById('nextBtn').textContent = 'Next: Preview & Send →';
            
            // Update character count for SMS
            const messageContent = document.getElementById('messageContent');
            if (commType === 'sms') {
                messageContent.addEventListener('input', function() {
                    const count = this.value.length;
                    const charCount = document.getElementById('charCount');
                    charCount.textContent = `${count}/160 characters`;
                    
                    if (count > 160) {
                        charCount.classList.add('text-red-500');
                    } else {
                        charCount.classList.remove('text-red-500');
                    }
                });
            }
        } else if (currentStep === 3) {
            document.getElementById('previewSection').classList.remove('hidden');
            document.getElementById('nextBtn').classList.add('hidden');
            document.getElementById('sendBtn').classList.remove('hidden');
            
            // Update preview
            const subject = document.getElementById('messageSubject');
            const message = document.getElementById('messageContent');
            document.getElementById('previewSubject').textContent = 
                subject.value || '(No subject)';
            document.getElementById('previewMessage').textContent = 
                message.value;
            document.getElementById('previewRecipients').textContent = 
                'Will be sent to selected recipients';
        }
    }

    function prevCommStep() {
        currentStep--;
        
        if (currentStep === 0) {
            document.getElementById('recipientSection').classList.add('hidden');
            document.getElementById('prevBtn').classList.add('hidden');
            document.getElementById('nextBtn').textContent = 'Next: Select Recipients →';
        } else if (currentStep === 1) {
            document.getElementById('messageSection').classList.add('hidden');
            document.getElementById('previewSection').classList.add('hidden');
            document.getElementById('sendBtn').classList.add('hidden');
            document.getElementById('nextBtn').classList.remove('hidden');
            document.getElementById('nextBtn').textContent = 'Next: Compose Message →';
        } else if (currentStep === 2) {
            document.getElementById('previewSection').classList.add('hidden');
            document.getElementById('sendBtn').classList.add('hidden');
            document.getElementById('nextBtn').classList.remove('hidden');
            document.getElementById('nextBtn').textContent = 'Next: Preview & Send →';
        }
    }

    function useTemplate(type) {
        const templates = {
            'meeting': 'Dear member, please be reminded of our SACCO meeting on [Date] at [Time] in [Venue]. Your attendance is important.',
            'approval': 'Congratulations! Your loan application has been approved. Amount: KES [Amount]. Please visit the office for further instructions.',
            'payment': 'Reminder: Your loan payment of KES [Amount] is due on [Date]. Please ensure timely payment to avoid penalties.',
            'savings': 'Your current savings balance is KES [Amount]. Thank you for your consistent contributions to the SACCO.'
        };
        
        document.getElementById('messageContent').value = templates[type] || '';
        
        // Update character count
        if (commType === 'sms') {
            const count = document.getElementById('messageContent').value.length;
            const charCount = document.getElementById('charCount');
            charCount.textContent = `${count}/160 characters`;
            
            if (count > 160) {
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        }
    }

    function sendCommunication() {
        const message = document.getElementById('messageContent').value.trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        if (commType === 'sms' && message.length > 160) {
            alert('SMS messages must be 160 characters or less');
            return;
        }
        
        // Show success message
        alert(`${commType.toUpperCase()} notification sent successfully!`);
        closeCommunications();
    }

    // Task completion
    function markTaskDone(button) {
        const taskItem = button.closest('.group');
        taskItem.style.opacity = '0.5';
        button.textContent = '✓ Done';
        button.disabled = true;
        button.classList.remove('hover:text-gray-700');
        button.classList.add('text-gray-400');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('communicationsModal');
        if (event.target === modal) {
            closeCommunications();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeCommunications();
        }
    });

    // Initialize checkbox interactions
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#recipientSection input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const container = this.closest('.group');
                if (this.checked) {
                    container.classList.add('border-gray-900');
                } else {
                    container.classList.remove('border-gray-900');
                }
            });
        });
    });
</script>

<style>
    /* Custom scrollbar for modal */
    #communicationsModal > div::-webkit-scrollbar {
        width: 8px;
    }
    
    #communicationsModal > div::-webkit-scrollbar-track {
        background: #f9fafb;
        border-radius: 0 24px 24px 0;
    }
    
    #communicationsModal > div::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    
    #communicationsModal > div::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Task priority borders */
    .task-priority-high {
        border-left: 4px solid #dc2626;
    }
    
    .task-priority-medium {
        border-left: 4px solid #d97706;
    }
    
    .task-priority-low {
        border-left: 4px solid #059669;
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Group hover effects */
    .group:hover .group-hover\:bg-gray-200 {
        background-color: #e5e7eb;
    }
    
    /* Custom checkbox styling */
    input[type="checkbox"]:checked + div > div > svg {
        opacity: 1;
    }
</style>
@endsection