@extends('components.dashboard-layout')

@section('title', 'Communications')

@section('content')
<div class="space-y-6 md:space-y-8">

    <!-- Header -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 tracking-tight">Communications Center</h1>
                <p class="text-gray-500 mt-1 text-sm md:text-base">
                    Manage SACCO communications, notifications, and member correspondence
                </p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openNewCommunication()"
                        class="px-5 md:px-6 py-2.5 md:py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all duration-200 flex items-center shadow-sm hover:shadow">
                    <span class="mr-2">✉️</span>
                    New Communication
                </button>
            </div>
        </div>
    </div>

    <!-- Communications Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- SMS Communications -->
        <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                            <span class="text-gray-700 text-xl">📱</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">SMS Sent</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">248</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">This month: 42 messages</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                        98% delivered
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-1.5"></span>
                        Remaining: 752
                    </span>
                    <button onclick="sendSMS()" class="text-gray-900 hover:text-gray-700 font-medium transition-colors">
                        Send SMS →
                    </button>
                </div>
            </div>
        </div>

        <!-- Email Communications -->
        <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                            <span class="text-gray-700 text-xl">✉️</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Emails Sent</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">156</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">This month: 28 emails</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                        92% opened
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-1.5"></span>
                        Unlimited
                    </span>
                    <button onclick="sendEmail()" class="text-gray-900 hover:text-gray-700 font-medium transition-colors">
                        Send Email →
                    </button>
                </div>
            </div>
        </div>

        <!-- Pending Responses -->
        <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                            <span class="text-gray-700 text-xl">⏳</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pending Responses</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">12</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Awaiting member replies</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                        3 urgent
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-1.5"></span>
                        Avg: 2 days
                    </span>
                    <button onclick="viewPending()" class="text-gray-900 hover:text-gray-700 font-medium transition-colors">
                        View All →
                    </button>
                </div>
            </div>
        </div>

        <!-- Communication Templates -->
        <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                            <span class="text-gray-700 text-xl">📄</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Templates</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">24</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Pre-defined messages</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                        8 active
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-1.5"></span>
                        4 categories
                    </span>
                    <button onclick="manageTemplates()" class="text-gray-900 hover:text-gray-700 font-medium transition-colors">
                        Manage →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Recent SMS Messages -->
            <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent SMS Messages</h3>
                        <p class="text-sm text-gray-500">Last 7 days</p>
                    </div>
                    <button onclick="viewSMSHistory()" class="text-sm text-gray-900 font-medium hover:text-gray-700 transition-colors">
                        View all →
                    </button>
                </div>

                <div class="space-y-4">
                    @php
                        $smsMessages = [
                            ['to' => 'All Members', 'message' => 'Meeting reminder: SACCO meeting tomorrow 2PM', 'time' => '2 hours ago', 'status' => 'delivered'],
                            ['to' => 'Loan Applicants', 'message' => 'Your loan application is under review', 'time' => '1 day ago', 'status' => 'delivered'],
                            ['to' => 'John Doe', 'message' => 'Your loan approved. Visit office for cheque', 'time' => '2 days ago', 'status' => 'read'],
                            ['to' => 'Pending Approvals', 'message' => 'Document verification required', 'time' => '3 days ago', 'status' => 'delivered'],
                        ];
                    @endphp

                    @foreach($smsMessages as $sms)
                    <div class="p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all duration-200 group">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                    <span class="text-gray-700 text-sm">📱</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900 block">{{ $sms['to'] }}</span>
                                    <span class="text-xs text-gray-500 sm:hidden">{{ $sms['time'] }}</span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 hidden sm:block">{{ $sms['time'] }}</span>
                        </div>
                        <p class="text-gray-700 text-sm mb-4 leading-relaxed">{{ $sms['message'] }}</p>
                        <div class="flex justify-between items-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium 
                                {{ $sms['status'] == 'delivered' ? 'bg-gray-100 text-gray-700' : 
                                   ($sms['status'] == 'read' ? 'bg-gray-100 text-gray-700' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($sms['status']) }}
                            </span>
                            <button class="text-xs text-gray-900 hover:text-gray-700 font-medium transition-colors">
                                Resend
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Quick Templates</h3>
                        <p class="text-sm text-gray-500">Frequently used messages</p>
                    </div>
                    <button onclick="addTemplate()" class="text-sm text-gray-900 font-medium hover:text-gray-700 transition-colors">
                        + Add Template
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                        $templates = [
                            ['name' => 'Meeting Announcement', 'type' => 'sms', 'category' => 'meetings'],
                            ['name' => 'Loan Approval Notice', 'type' => 'sms', 'category' => 'loans'],
                            ['name' => 'Payment Reminder', 'type' => 'email', 'category' => 'payments'],
                            ['name' => 'Savings Update', 'type' => 'email', 'category' => 'savings'],
                            ['name' => 'Welcome New Member', 'type' => 'email', 'category' => 'members'],
                            ['name' => 'Document Request', 'type' => 'sms', 'category' => 'documents'],
                        ];
                    @endphp

                    @foreach($templates as $template)
                    <div class="p-4 border border-gray-100 rounded-2xl hover:border-gray-300 transition-all duration-200 cursor-pointer group"
                         onclick="useTemplate('{{ $template['name'] }}')">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                    <span class="text-gray-700 text-sm">
                                        {{ $template['type'] == 'sms' ? '📱' : '✉️' }}
                                    </span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $template['name'] }}</span>
                            </div>
                            <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-lg">
                                {{ $template['category'] }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Click to use this template</p>
                        <div class="flex space-x-3 opacity-0 group-hover:opacity-100 transition-all duration-200">
                            <button class="text-xs text-gray-900 hover:text-gray-700 font-medium">Edit</button>
                            <button class="text-xs text-gray-900 hover:text-gray-700 font-medium">Preview</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Recent Emails -->
            <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Emails</h3>
                        <p class="text-sm text-gray-500">Last 30 days</p>
                    </div>
                    <button onclick="viewEmailHistory()" class="text-sm text-gray-900 font-medium hover:text-gray-700 transition-colors">
                        View all →
                    </button>
                </div>

                <div class="space-y-4">
                    @php
                        $emails = [
                            ['subject' => 'Quarterly SACCO Report', 'to' => 'All Members', 'time' => '1 day ago', 'status' => 'opened'],
                            ['subject' => 'Loan Application Update', 'to' => 'Jane Smith', 'time' => '2 days ago', 'status' => 'delivered'],
                            ['subject' => 'Meeting Minutes - April', 'to' => 'Committee Members', 'time' => '3 days ago', 'status' => 'opened'],
                            ['subject' => 'Savings Statement', 'to' => 'John Doe', 'time' => '5 days ago', 'status' => 'read'],
                        ];
                    @endphp

                    @foreach($emails as $email)
                    <div class="p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all duration-200 group">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-3">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 mb-1">{{ $email['subject'] }}</p>
                                <p class="text-sm text-gray-500">To: {{ $email['to'] }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $email['time'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium 
                                {{ $email['status'] == 'opened' ? 'bg-gray-100 text-gray-700' : 
                                   ($email['status'] == 'read' ? 'bg-gray-100 text-gray-700' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($email['status']) }}
                            </span>
                            <button class="text-xs text-gray-900 hover:text-gray-700 font-medium transition-colors">
                                View Details →
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Compose -->
            <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Compose</h3>
                    <p class="text-sm text-gray-500">Send a quick message</p>
                </div>

                <div class="space-y-5">
                    <!-- Communication Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Type</label>
                        <div class="flex space-x-3">
                            <button id="smsBtn" 
                                    class="flex-1 py-3 border border-gray-200 rounded-xl hover:border-gray-300 transition-all duration-200 flex items-center justify-center group"
                                    onclick="selectType('sms')">
                                <span class="mr-2 text-lg">📱</span>
                                <span class="font-medium text-gray-900">SMS</span>
                            </button>
                            <button id="emailBtn" 
                                    class="flex-1 py-3 border border-gray-200 rounded-xl hover:border-gray-300 transition-all duration-200 flex items-center justify-center group"
                                    onclick="selectType('email')">
                                <span class="mr-2 text-lg">✉️</span>
                                <span class="font-medium text-gray-900">Email</span>
                            </button>
                        </div>
                    </div>

                    <!-- Recipients -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Recipients</label>
                        <select class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 focus:border-gray-400 focus:ring-0 transition-colors">
                            <option value="">Select recipients...</option>
                            <option value="all">All Members (156)</option>
                            <option value="pending">Pending Approvals (8)</option>
                            <option value="loans">Active Loan Holders (24)</option>
                            <option value="department">By Department</option>
                            <option value="individual">Individual Member</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Message</label>
                        <textarea id="quickMessage" rows="4"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:border-gray-400 focus:ring-0 transition-colors resize-none"
                                  placeholder="Type your message here..."></textarea>
                        <p class="text-xs text-gray-400 mt-2" id="quickCharCount">0/160 characters</p>
                    </div>

                    <!-- Send Button -->
                    <div class="flex justify-end">
                        <button onclick="sendQuickMessage()"
                                class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all duration-200 flex items-center shadow-sm hover:shadow">
                            <span class="mr-2">📤</span>
                            Send Message
                        </button>
                    </div>
                </div>
            </div>

            <!-- Communication Settings -->
            <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-gray-100">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Communication Settings</h3>
                    <p class="text-sm text-gray-500">Configure notification preferences</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-4">
                                <span class="text-gray-700">📱</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">SMS Notifications</p>
                                <p class="text-sm text-gray-500">Send SMS alerts</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gray-900 transition-colors"></div>
                            <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-4">
                                <span class="text-gray-700">✉️</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Email Notifications</p>
                                <p class="text-sm text-gray-500">Send email updates</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gray-900 transition-colors"></div>
                            <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center mr-4">
                                <span class="text-gray-700">⏰</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Auto Reminders</p>
                                <p class="text-sm text-gray-500">Schedule reminders</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gray-900 transition-colors"></div>
                            <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- New Communication Modal -->
<div id="newCommunicationModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">New Communication</h3>
                <button onclick="closeNewCommunication()" 
                        class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <span class="text-gray-500 hover:text-gray-700">✕</span>
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Send a message to SACCO members</p>
        </div>

        <div class="p-6">
            <!-- Step 1: Type & Recipients -->
            <div id="step1" class="space-y-6">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 rounded-2xl bg-gray-900 text-white flex items-center justify-center mr-4">
                        1
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Select Type & Recipients</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Communication Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Communication Type</label>
                        <div class="space-y-3">
                            <div class="p-4 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-gray-900 transition-all duration-200 comm-type group"
                                 onclick="selectCommType('sms')">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mr-4 group-hover:bg-gray-200 transition-colors">
                                        <span class="text-gray-700 text-xl">📱</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">SMS Message</p>
                                        <p class="text-sm text-gray-500">Quick text notification</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-gray-900 transition-all duration-200 comm-type group"
                                 onclick="selectCommType('email')">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mr-4 group-hover:bg-gray-200 transition-colors">
                                        <span class="text-gray-700 text-xl">✉️</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Email Message</p>
                                        <p class="text-sm text-gray-500">Detailed communication</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recipients -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Select Recipients</label>
                        <div class="space-y-3">
                            <div class="p-4 border border-gray-200 rounded-2xl hover:bg-gray-50 cursor-pointer transition-colors group recipient-option" onclick="selectRecipient(this)">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center group-hover:border-gray-900 transition-colors radio-circle">
                                        <div class="w-3 h-3 rounded-full bg-gray-900 opacity-0 transition-opacity"></div>
                                    </div>
                                    <input type="radio" name="recipients" class="sr-only" id="allMembers" value="all">
                                    <div>
                                        <p class="font-medium text-gray-900">All Members</p>
                                        <p class="text-sm text-gray-500">156 members</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-2xl hover:bg-gray-50 cursor-pointer transition-colors group recipient-option" onclick="selectRecipient(this)">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center group-hover:border-gray-900 transition-colors radio-circle">
                                        <div class="w-3 h-3 rounded-full bg-gray-900 opacity-0 transition-opacity"></div>
                                    </div>
                                    <input type="radio" name="recipients" class="sr-only" id="pendingApprovals" value="pending">
                                    <div>
                                        <p class="font-medium text-gray-900">Pending Approvals</p>
                                        <p class="text-sm text-gray-500">8 members</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border border-gray-200 rounded-2xl hover:bg-gray-50 cursor-pointer transition-colors group recipient-option" onclick="selectRecipient(this)">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center group-hover:border-gray-900 transition-colors radio-circle">
                                        <div class="w-3 h-3 rounded-full bg-gray-900 opacity-0 transition-opacity"></div>
                                    </div>
                                    <input type="radio" name="recipients" class="sr-only" id="customGroup" value="custom">
                                    <div>
                                        <p class="font-medium text-gray-900">Custom Group</p>
                                        <p class="text-sm text-gray-500">Select specific members</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button onclick="nextStep()"
                            class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                        Next: Compose Message →
                    </button>
                </div>
            </div>

            <!-- Step 2: Compose Message -->
            <div id="step2" class="space-y-6 hidden">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 rounded-2xl bg-gray-900 text-white flex items-center justify-center mr-4">
                        2
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Compose Message</h4>
                </div>

                <div id="emailFields" class="hidden">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Subject</label>
                        <input type="text" id="emailSubject"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-gray-400 focus:ring-0 transition-colors"
                               placeholder="Enter email subject">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Message</label>
                    <textarea id="messageContent" rows="6"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:border-gray-400 focus:ring-0 transition-colors resize-none"
                              placeholder="Type your message here..."></textarea>
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mt-3 gap-2">
                        <p class="text-xs text-gray-400" id="charCount">0/160 characters</p>
                        <div class="flex space-x-4">
                            <button onclick="insertTemplate()" class="text-xs text-gray-900 hover:text-gray-700 font-medium transition-colors">
                                Insert Template
                            </button>
                            <button onclick="previewMessage()" class="text-xs text-gray-900 hover:text-gray-700 font-medium transition-colors">
                                Preview
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Template Suggestions -->
                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-sm font-medium text-gray-700 mb-4">Suggested Templates:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button onclick="loadTemplate('meeting')" class="p-4 border border-gray-200 rounded-xl hover:bg-white transition-all duration-200 text-left group">
                            <p class="font-medium text-gray-900">Meeting Announcement</p>
                            <p class="text-xs text-gray-500 mt-1">Notify about upcoming meetings</p>
                        </button>
                        <button onclick="loadTemplate('loan')" class="p-4 border border-gray-200 rounded-xl hover:bg-white transition-all duration-200 text-left group">
                            <p class="font-medium text-gray-900">Loan Update</p>
                            <p class="text-xs text-gray-500 mt-1">Loan approval/rejection notices</p>
                        </button>
                        <button onclick="loadTemplate('payment')" class="p-4 border border-gray-200 rounded-xl hover:bg-white transition-all duration-200 text-left group">
                            <p class="font-medium text-gray-900">Payment Reminder</p>
                            <p class="text-xs text-gray-500 mt-1">Due payment notifications</p>
                        </button>
                        <button onclick="loadTemplate('savings')" class="p-4 border border-gray-200 rounded-xl hover:bg-white transition-all duration-200 text-left group">
                            <p class="font-medium text-gray-900">Savings Update</p>
                            <p class="text-xs text-gray-500 mt-1">Monthly savings statements</p>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6 border-t border-gray-100">
                    <button onclick="prevStep()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200">
                        ← Back
                    </button>
                    <button onclick="nextToPreview()"
                            class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                        Next: Preview & Send →
                    </button>
                </div>
            </div>

            <!-- Step 3: Preview & Send -->
            <div id="step3" class="space-y-6 hidden">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 rounded-2xl bg-gray-900 text-white flex items-center justify-center mr-4">
                        3
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Preview & Send</h4>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-3">Preview:</p>
                        <div class="bg-white p-5 rounded-2xl border border-gray-200">
                            <p class="font-medium text-gray-900 mb-2" id="previewSubject"></p>
                            <p class="text-gray-700 whitespace-pre-wrap leading-relaxed" id="previewContent"></p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Recipients:</p>
                            <p class="text-gray-700 font-medium" id="previewRecipients"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Estimated Cost:</p>
                            <p class="text-gray-700 font-medium" id="previewCost"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-3">Schedule:</p>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <label class="flex items-center schedule-option" onclick="selectSchedule(this)">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center schedule-circle">
                                        <div class="w-3 h-3 rounded-full bg-gray-900 opacity-0 transition-opacity"></div>
                                    </div>
                                    <input type="radio" name="schedule" value="now" checked class="sr-only">
                                    <span class="text-gray-700">Send now</span>
                                </label>
                                <label class="flex items-center schedule-option" onclick="selectSchedule(this)">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center schedule-circle">
                                        <div class="w-3 h-3 rounded-full bg-gray-900 opacity-0 transition-opacity"></div>
                                    </div>
                                    <input type="radio" name="schedule" value="later" class="sr-only">
                                    <span class="text-gray-700">Schedule for later</span>
                                </label>
                                <input type="datetime-local" class="px-4 py-2 border border-gray-300 rounded-xl bg-white focus:border-gray-400 focus:ring-0 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6 border-t border-gray-100">
                    <button onclick="prevStep()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200">
                        ← Back
                    </button>
                    <button onclick="sendFinalCommunication()"
                            class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center">
                        <span class="mr-2">📤</span>
                        Send Communication
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Quick Compose Functions
    let selectedType = 'sms';

    function selectType(type) {
        selectedType = type;
        
        // Update button styles
        const smsBtn = document.getElementById('smsBtn');
        const emailBtn = document.getElementById('emailBtn');
        
        smsBtn.classList.remove('border-gray-900', 'bg-gray-100');
        emailBtn.classList.remove('border-gray-900', 'bg-gray-100');
        
        if (type === 'sms') {
            smsBtn.classList.add('border-gray-900', 'bg-gray-100');
        } else {
            emailBtn.classList.add('border-gray-900', 'bg-gray-100');
        }
        
        // Update character counter
        updateCharCount();
    }

    function updateCharCount() {
        const message = document.getElementById('quickMessage');
        const count = message.value.length;
        const max = selectedType === 'sms' ? 160 : 1000;
        const charCount = document.getElementById('quickCharCount');
        
        charCount.textContent = `${count}/${max} characters`;
        
        if (count > max) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    }

    function sendQuickMessage() {
        const message = document.getElementById('quickMessage').value.trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        if (selectedType === 'sms' && message.length > 160) {
            alert('SMS messages must be 160 characters or less');
            return;
        }
        
        // Show success message
        alert(`${selectedType.toUpperCase()} message sent successfully!`);
        document.getElementById('quickMessage').value = '';
        updateCharCount();
    }

    // New Communication Modal
    let currentStep = 1;
    let selectedCommType = '';

    function openNewCommunication() {
        document.getElementById('newCommunicationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetCommunication();
    }

    function closeNewCommunication() {
        document.getElementById('newCommunicationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetCommunication();
    }

    function resetCommunication() {
        currentStep = 1;
        selectedCommType = '';
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('emailFields').classList.add('hidden');
        
        // Reset selection
        document.querySelectorAll('.comm-type').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
        
        // Reset inputs
        document.getElementById('emailSubject').value = '';
        document.getElementById('messageContent').value = '';
    }

    function selectCommType(type) {
        selectedCommType = type;
        
        // Update selection
        document.querySelectorAll('.comm-type').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
        
        event.target.closest('.comm-type').classList.add('border-gray-900', 'bg-gray-50');
    }

    function selectRecipient(element) {
        // Remove selection from all
        document.querySelectorAll('.recipient-option').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
            el.querySelector('.radio-circle > div').classList.remove('opacity-100');
            el.querySelector('.radio-circle > div').classList.add('opacity-0');
        });
        
        // Add selection to clicked element
        element.classList.add('border-gray-900', 'bg-gray-50');
        element.querySelector('.radio-circle > div').classList.add('opacity-100');
        element.querySelector('.radio-circle > div').classList.remove('opacity-0');
        element.querySelector('input[type="radio"]').checked = true;
    }

    function selectSchedule(element) {
        // Remove selection from all
        document.querySelectorAll('.schedule-option').forEach(el => {
            el.querySelector('.schedule-circle > div').classList.remove('opacity-100');
            el.querySelector('.schedule-circle > div').classList.add('opacity-0');
        });
        
        // Add selection to clicked element
        element.querySelector('.schedule-circle > div').classList.add('opacity-100');
        element.querySelector('.schedule-circle > div').classList.remove('opacity-0');
        element.querySelector('input[type="radio"]').checked = true;
    }

    function nextStep() {
        if (!selectedCommType) {
            alert('Please select a communication type');
            return;
        }
        
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        currentStep = 2;
        
        // Show/hide email fields
        const emailFields = document.getElementById('emailFields');
        if (selectedCommType === 'email') {
            emailFields.classList.remove('hidden');
        } else {
            emailFields.classList.add('hidden');
        }
        
        // Initialize character counter
        updateMessageCharCount();
    }

    function prevStep() {
        if (currentStep === 2) {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            currentStep = 1;
        } else if (currentStep === 3) {
            document.getElementById('step3').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            currentStep = 2;
        }
    }

    function updateMessageCharCount() {
        const message = document.getElementById('messageContent');
        const count = message.value.length;
        const max = selectedCommType === 'sms' ? 300 : 1000;
        const charCount = document.getElementById('charCount');
        
        charCount.textContent = `${count}/${max} characters`;
        
        if (count > max) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    }

    function loadTemplate(type) {
        const templates = {
            'meeting': 'Dear member,\n\nPlease be reminded of our SACCO meeting on [Date] at [Time] in [Venue].\n\nAgenda:\n1. Review of previous minutes\n2. Loan applications\n3. Any other business\n\nYour attendance is important.\n\nSecretary,\nMakamithi SACCO',
            'loan': 'Dear member,\n\nYour loan application has been [Status].\n\nApplication Details:\nAmount: KES [Amount]\nStatus: [Approved/Rejected]\n\n[If approved]: Please visit the office with your ID for cheque collection.\n[If rejected]: Contact the Secretary for more information.\n\nThank you,\nMakamithi SACCO',
            'payment': 'Dear member,\n\nThis is a reminder that your loan payment of KES [Amount] is due on [Date].\n\nPlease ensure timely payment to maintain good standing with the SACCO.\n\nPayment Methods:\n1. Payroll deduction\n2. Direct bank deposit\n3. Mobile money\n\nThank you,\nMakamithi SACCO',
            'savings': 'Dear member,\n\nYour savings statement for [Month] is now available.\n\nCurrent Balance: KES [Amount]\nMonthly Contribution: KES [Monthly]\n\nYou qualify for a loan of up to KES [Eligible] (1.5× your savings).\n\nThank you for your consistent contributions.\n\nSecretary,\nMakamithi SACCO'
        };
        
        const messageContent = document.getElementById('messageContent');
        messageContent.value = templates[type] || '';
        updateMessageCharCount();
    }

    function nextToPreview() {
        const message = document.getElementById('messageContent').value.trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        if (selectedCommType === 'sms' && message.length > 300) {
            alert('SMS messages must be 300 characters or less');
            return;
        }
        
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.remove('hidden');
        currentStep = 3;
        
        // Update preview
        const emailSubject = document.getElementById('emailSubject');
        const previewSubject = document.getElementById('previewSubject');
        const previewContent = document.getElementById('previewContent');
        
        if (selectedCommType === 'email') {
            previewSubject.textContent = emailSubject.value || '(No subject)';
        } else {
            previewSubject.textContent = 'SMS Message';
        }
        
        previewContent.textContent = message;
        
        // Update recipients
        const selectedRecipient = document.querySelector('input[name="recipients"]:checked');
        let recipientText = 'Not selected';
        if (selectedRecipient) {
            const recipientDiv = selectedRecipient.closest('div').querySelector('.font-medium');
            recipientText = recipientDiv ? recipientDiv.textContent : 'Not selected';
        }
        document.getElementById('previewRecipients').textContent = recipientText;
        
        // Update cost
        const cost = selectedCommType === 'sms' ? 'KES 1 per SMS' : 'Free';
        document.getElementById('previewCost').textContent = cost;
    }

    function sendFinalCommunication() {
        const message = document.getElementById('messageContent').value.trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        // Show success message
        alert(`${selectedCommType.toUpperCase()} communication sent successfully!`);
        closeNewCommunication();
    }

    // Other functions
    function sendSMS() {
        selectType('sms');
        openNewCommunication();
    }

    function sendEmail() {
        selectType('email');
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        selectType('sms');
        
        const quickMessage = document.getElementById('quickMessage');
        const messageContent = document.getElementById('messageContent');
        
        quickMessage.addEventListener('input', updateCharCount);
        messageContent.addEventListener('input', updateMessageCharCount);
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('newCommunicationModal');
            if (event.target === modal) {
                closeNewCommunication();
            }
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNewCommunication();
            }
        });
        
        // Select first recipient by default
        const firstRecipient = document.querySelector('.recipient-option');
        if (firstRecipient) {
            selectRecipient(firstRecipient);
        }
    });
        alert('Viewing email history...');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        selectType('sms');
        
        const quickMessage = document.getElementById('quickMessage');
        const messageContent = document.getElementById('messageContent');
        
        quickMessage.addEventListener('input', updateCharCount);
        messageContent.addEventListener('input', updateMessageCharCount);
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('newCommunicationModal');
            if (event.target === modal) {
                closeNewCommunication();
            }
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNewCommunication();
            }
        });
    });
</script>

<style>
    /* Custom scrollbar */
    #newCommunicationModal > div::-webkit-scrollbar {
        width: 8px;
    }
    
    #newCommunicationModal > div::-webkit-scrollbar-track {
        background: #f9fafb;
        border-radius: 0 24px 24px 0;
    }
    
    #newCommunicationModal > div::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    
    #newCommunicationModal > div::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Radio button custom style */
    input[type="radio"]:checked + div > div {
        opacity: 1;
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endsection