@extends('components.dashboard-layout')

@section('title', 'Communications')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Communications Center</h1>
                <p class="text-gray-500 mt-1">
                    Manage all SACCO communications, notifications, and member correspondence
                </p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openNewCommunication()"
                        class="px-6 py-3 rounded-lg bg-gray-900 text-white font-medium hover:bg-gray-800 transition flex items-center">
                    <span class="mr-2">✉️</span>
                    New Communication
                </button>
            </div>
        </div>
    </div>

    <!-- Communications Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- SMS Communications -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <span class="text-green-600 text-xl">📱</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">SMS Sent</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">248</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">This month: 42 messages</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        98% delivered
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                        Remaining: 752
                    </span>
                    <button onclick="sendSMS()" class="text-gray-900 hover:text-gray-700 font-medium">
                        Send SMS
                    </button>
                </div>
            </div>
        </div>

        <!-- Email Communications -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <span class="text-blue-600 text-xl">✉️</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Emails Sent</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">156</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">This month: 28 emails</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        92% opened
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                        Unlimited
                    </span>
                    <button onclick="sendEmail()" class="text-gray-900 hover:text-gray-700 font-medium">
                        Send Email
                    </button>
                </div>
            </div>
        </div>

        <!-- Pending Responses -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                            <span class="text-yellow-600 text-xl">⏳</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pending Responses</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">12</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Awaiting member replies</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        3 urgent
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></span>
                        Avg: 2 days
                    </span>
                    <button onclick="viewPending()" class="text-gray-900 hover:text-gray-700 font-medium">
                        View All
                    </button>
                </div>
            </div>
        </div>

        <!-- Communication Templates -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                            <span class="text-purple-600 text-xl">📄</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Templates</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">24</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Pre-defined messages</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        8 active
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-1"></span>
                        4 categories
                    </span>
                    <button onclick="manageTemplates()" class="text-gray-900 hover:text-gray-700 font-medium">
                        Manage
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column: Recent Communications -->
        <div class="space-y-6">
            <!-- Recent SMS Messages -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent SMS Messages</h3>
                        <p class="text-sm text-gray-500">Last 7 days</p>
                    </div>
                    <button onclick="viewSMSHistory()" class="text-sm text-gray-900 font-medium hover:text-gray-700">
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
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2">
                                    <span class="text-green-600 text-sm">📱</span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $sms['to'] }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $sms['time'] }}</span>
                        </div>
                        <p class="text-gray-700 text-sm mb-3">{{ $sms['message'] }}</p>
                        <div class="flex justify-between items-center">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                {{ $sms['status'] == 'delivered' ? 'bg-green-100 text-green-800' : 
                                   ($sms['status'] == 'read' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($sms['status']) }}
                            </span>
                            <button class="text-xs text-gray-900 hover:text-gray-700">
                                Resend
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Quick Templates</h3>
                        <p class="text-sm text-gray-500">Frequently used messages</p>
                    </div>
                    <button onclick="addTemplate()" class="text-sm text-gray-900 font-medium hover:text-gray-700">
                        + Add Template
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition cursor-pointer group"
                         onclick="useTemplate('{{ $template['name'] }}')">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full {{ $template['type'] == 'sms' ? 'bg-green-100' : 'bg-blue-100' }} flex items-center justify-center mr-2">
                                    <span class="{{ $template['type'] == 'sms' ? 'text-green-600' : 'text-blue-600' }} text-sm">
                                        {{ $template['type'] == 'sms' ? '📱' : '✉️' }}
                                    </span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $template['name'] }}</span>
                            </div>
                            <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded">
                                {{ $template['category'] }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">Click to use this template</p>
                        <div class="mt-3 flex space-x-2 opacity-0 group-hover:opacity-100 transition">
                            <button class="text-xs text-gray-900 hover:text-gray-700">Edit</button>
                            <button class="text-xs text-gray-900 hover:text-gray-700">Preview</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Email History & Compose -->
        <div class="space-y-6">
            <!-- Recent Emails -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Emails</h3>
                        <p class="text-sm text-gray-500">Last 30 days</p>
                    </div>
                    <button onclick="viewEmailHistory()" class="text-sm text-gray-900 font-medium hover:text-gray-700">
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
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900">{{ $email['subject'] }}</p>
                                <p class="text-sm text-gray-500">To: {{ $email['to'] }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $email['time'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                {{ $email['status'] == 'opened' ? 'bg-blue-100 text-blue-800' : 
                                   ($email['status'] == 'read' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($email['status']) }}
                            </span>
                            <button class="text-xs text-gray-900 hover:text-gray-700">
                                View Details
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Compose -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Compose</h3>
                    <p class="text-sm text-gray-500">Send a quick message</p>
                </div>

                <div class="space-y-4">
                    <!-- Communication Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <div class="flex space-x-4">
                            <button id="smsBtn" class="flex-1 py-3 border border-gray-300 rounded-lg hover:border-gray-400 transition flex items-center justify-center"
                                    onclick="selectType('sms')">
                                <span class="mr-2">📱</span>
                                SMS
                            </button>
                            <button id="emailBtn" class="flex-1 py-3 border border-gray-300 rounded-lg hover:border-gray-400 transition flex items-center justify-center"
                                    onclick="selectType('email')">
                                <span class="mr-2">✉️</span>
                                Email
                            </button>
                        </div>
                    </div>

                    <!-- Recipients -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipients</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea id="quickMessage" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                                  placeholder="Type your message here..."></textarea>
                        <p class="text-xs text-gray-400 mt-2" id="quickCharCount">0/160 characters</p>
                    </div>

                    <!-- Send Button -->
                    <div class="flex justify-end">
                        <button onclick="sendQuickMessage()"
                                class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition flex items-center">
                            <span class="mr-2">📤</span>
                            Send Message
                        </button>
                    </div>
                </div>
            </div>

            <!-- Communication Settings -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Communication Settings</h3>
                    <p class="text-sm text-gray-500">Configure notification preferences</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <span class="text-green-600">📱</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">SMS Notifications</p>
                                <p class="text-sm text-gray-500">Send SMS alerts</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <span class="text-blue-600">✉️</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Email Notifications</p>
                                <p class="text-sm text-gray-500">Send email updates</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <span class="text-purple-600">⏰</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Auto Reminders</p>
                                <p class="text-sm text-gray-500">Schedule reminders</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- New Communication Modal -->
<div id="newCommunicationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">New Communication</h3>
                <button onclick="closeNewCommunication()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Send a message to SACCO members</p>
        </div>

        <div class="p-6">
            <!-- Step 1: Type & Recipients -->
            <div id="step1" class="space-y-6">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center mr-3">
                        1
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Select Type & Recipients</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Communication Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Communication Type</label>
                        <div class="space-y-3">
                            <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-gray-900 transition comm-type"
                                 onclick="selectCommType('sms')">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <span class="text-green-600 text-xl">📱</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">SMS Message</p>
                                        <p class="text-sm text-gray-500">Quick text notification</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-gray-900 transition comm-type"
                                 onclick="selectCommType('email')">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <span class="text-blue-600 text-xl">✉️</span>
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
                            <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <div class="flex items-center">
                                    <input type="radio" name="recipients" class="mr-3" id="allMembers">
                                    <div>
                                        <p class="font-medium text-gray-900">All Members</p>
                                        <p class="text-sm text-gray-500">156 members</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <div class="flex items-center">
                                    <input type="radio" name="recipients" class="mr-3" id="pendingApprovals">
                                    <div>
                                        <p class="font-medium text-gray-900">Pending Approvals</p>
                                        <p class="text-sm text-gray-500">8 members</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <div class="flex items-center">
                                    <input type="radio" name="recipients" class="mr-3" id="customGroup">
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
                            class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">
                        Next: Compose Message →
                    </button>
                </div>
            </div>

            <!-- Step 2: Compose Message -->
            <div id="step2" class="space-y-6 hidden">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center mr-3">
                        2
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Compose Message</h4>
                </div>

                <div id="emailFields" class="hidden">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <input type="text" id="emailSubject"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                               placeholder="Enter email subject">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="messageContent" rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                              placeholder="Type your message here..."></textarea>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-xs text-gray-400" id="charCount">0/160 characters</p>
                        <div class="flex space-x-2">
                            <button onclick="insertTemplate()" class="text-xs text-gray-900 hover:text-gray-700">
                                Insert Template
                            </button>
                            <button onclick="previewMessage()" class="text-xs text-gray-900 hover:text-gray-700">
                                Preview
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Template Suggestions -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-3">Suggested Templates:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <button onclick="loadTemplate('meeting')" class="p-3 border border-gray-200 rounded-lg hover:bg-white transition text-left">
                            <p class="font-medium text-gray-900">Meeting Announcement</p>
                            <p class="text-xs text-gray-500">Notify about upcoming meetings</p>
                        </button>
                        <button onclick="loadTemplate('loan')" class="p-3 border border-gray-200 rounded-lg hover:bg-white transition text-left">
                            <p class="font-medium text-gray-900">Loan Update</p>
                            <p class="text-xs text-gray-500">Loan approval/rejection notices</p>
                        </button>
                        <button onclick="loadTemplate('payment')" class="p-3 border border-gray-200 rounded-lg hover:bg-white transition text-left">
                            <p class="font-medium text-gray-900">Payment Reminder</p>
                            <p class="text-xs text-gray-500">Due payment notifications</p>
                        </button>
                        <button onclick="loadTemplate('savings')" class="p-3 border border-gray-200 rounded-lg hover:bg-white transition text-left">
                            <p class="font-medium text-gray-900">Savings Update</p>
                            <p class="text-xs text-gray-500">Monthly savings statements</p>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between pt-6 border-t">
                    <button onclick="prevStep()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        ← Back
                    </button>
                    <button onclick="nextToPreview()"
                            class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">
                        Next: Preview & Send →
                    </button>
                </div>
            </div>

            <!-- Step 3: Preview & Send -->
            <div id="step3" class="space-y-6 hidden">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center mr-3">
                        3
                    </div>
                    <h4 class="text-lg font-medium text-gray-900">Preview & Send</h4>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                        <div class="bg-white p-4 rounded-lg border">
                            <p class="font-medium text-gray-900 mb-1" id="previewSubject"></p>
                            <p class="text-gray-700 whitespace-pre-wrap" id="previewContent"></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Recipients:</p>
                            <p class="text-gray-700" id="previewRecipients"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Estimated Cost:</p>
                            <p class="text-gray-700" id="previewCost"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Schedule:</p>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="schedule" checked class="mr-2">
                                    <span class="text-gray-700">Send now</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="schedule" class="mr-2">
                                    <span class="text-gray-700">Schedule for later</span>
                                </label>
                                <input type="datetime-local" class="px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between pt-6 border-t">
                    <button onclick="prevStep()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        ← Back
                    </button>
                    <button onclick="sendFinalCommunication()"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
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
        document.getElementById('smsBtn').classList.remove('border-gray-900', 'bg-gray-100');
        document.getElementById('emailBtn').classList.remove('border-gray-900', 'bg-gray-100');
        
        if (type === 'sms') {
            document.getElementById('smsBtn').classList.add('border-gray-900', 'bg-gray-100');
        } else {
            document.getElementById('emailBtn').classList.add('border-gray-900', 'bg-gray-100');
        }
        
        // Update character counter
        updateCharCount();
    }

    function updateCharCount() {
        const message = document.getElementById('quickMessage').value;
        const count = message.length;
        const max = selectedType === 'sms' ? 160 : 1000;
        document.getElementById('quickCharCount').textContent = `${count}/${max} characters`;
        
        if (count > max) {
            document.getElementById('quickCharCount').classList.add('text-red-500');
        } else {
            document.getElementById('quickCharCount').classList.remove('text-red-500');
        }
    }

    function sendQuickMessage() {
        const message = document.getElementById('quickMessage').value;
        
        if (!message.trim()) {
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
        resetCommunication();
    }

    function closeNewCommunication() {
        document.getElementById('newCommunicationModal').classList.add('hidden');
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
    }

    function selectCommType(type) {
        selectedCommType = type;
        
        // Update selection
        document.querySelectorAll('.comm-type').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
        
        event.target.closest('.comm-type').classList.add('border-gray-900', 'bg-gray-50');
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
        if (selectedCommType === 'email') {
            document.getElementById('emailFields').classList.remove('hidden');
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
        const message = document.getElementById('messageContent').value;
        const count = message.length;
        const max = selectedCommType === 'sms' ? 160 : 1000;
        document.getElementById('charCount').textContent = `${count}/${max} characters`;
    }

    function loadTemplate(type) {
        const templates = {
            'meeting': 'Dear member,\n\nPlease be reminded of our SACCO meeting on [Date] at [Time] in [Venue].\n\nAgenda:\n1. Review of previous minutes\n2. Loan applications\n3. Any other business\n\nYour attendance is important.\n\nSecretary,\nMakamithi SACCO',
            'loan': 'Dear member,\n\nYour loan application has been [Status].\n\nApplication Details:\nAmount: KES [Amount]\nStatus: [Approved/Rejected]\n\n[If approved]: Please visit the office with your ID for cheque collection.\n[If rejected]: Contact the Secretary for more information.\n\nThank you,\nMakamithi SACCO',
            'payment': 'Dear member,\n\nThis is a reminder that your loan payment of KES [Amount] is due on [Date].\n\nPlease ensure timely payment to maintain good standing with the SACCO.\n\nPayment Methods:\n1. Payroll deduction\n2. Direct bank deposit\n3. Mobile money\n\nThank you,\nMakamithi SACCO',
            'savings': 'Dear member,\n\nYour savings statement for [Month] is now available.\n\nCurrent Balance: KES [Amount]\nMonthly Contribution: KES [Monthly]\n\nYou qualify for a loan of up to KES [Eligible] (1.5× your savings).\n\nThank you for your consistent contributions.\n\nSecretary,\nMakamithi SACCO'
        };
        
        document.getElementById('messageContent').value = templates[type] || '';
        updateMessageCharCount();
    }

    function nextToPreview() {
        const message = document.getElementById('messageContent').value;
        
        if (!message.trim()) {
            alert('Please enter a message');
            return;
        }
        
        if (selectedCommType === 'sms' && message.length > 160) {
            alert('SMS messages must be 160 characters or less');
            return;
        }
        
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.remove('hidden');
        currentStep = 3;
        
        // Update preview
        document.getElementById('previewSubject').textContent = 
            selectedCommType === 'email' ? document.getElementById('emailSubject').value || '(No subject)' : 'SMS Message';
        document.getElementById('previewContent').textContent = message;
        
        // Update recipients
        const selectedRecipient = document.querySelector('input[name="recipients"]:checked');
        const recipientText = selectedRecipient ? selectedRecipient.closest('div').querySelector('.font-medium').textContent : 'Not selected';
        document.getElementById('previewRecipients').textContent = recipientText;
        
        // Update cost
        const cost = selectedCommType === 'sms' ? 'KES 1 per SMS' : 'Free';
        document.getElementById('previewCost').textContent = cost;
    }

    function sendFinalCommunication() {
        const message = document.getElementById('messageContent').value;
        
        if (!message.trim()) {
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
        openNewCommunication();
    }

    function viewPending() {
        alert('Viewing pending responses...');
    }

    function manageTemplates() {
        alert('Opening template manager...');
    }

    function useTemplate(name) {
        alert(`Using template: ${name}`);
        openNewCommunication();
    }

    function addTemplate() {
        alert('Adding new template...');
    }

    function viewSMSHistory() {
        alert('Viewing SMS history...');
    }

    function viewEmailHistory() {
        alert('Viewing email history...');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        selectType('sms');
        document.getElementById('quickMessage').addEventListener('input', updateCharCount);
        document.getElementById('messageContent').addEventListener('input', updateMessageCharCount);
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('newCommunicationModal');
            if (event.target == modal) {
                closeNewCommunication();
            }
        }
    });
</script>

<style>
    .comm-type.border-gray-900 {
        border-color: #111827;
        background-color: #f9fafb;
    }
    
    .message-bubble {
        max-width: 70%;
        word-wrap: break-word;
    }
    
    .toggle-checkbox:checked {
        right: 0;
        border-color: #10b981;
    }
    
    .toggle-checkbox:checked + .toggle-label {
        background-color: #10b981;
    }
</style>
@endsection