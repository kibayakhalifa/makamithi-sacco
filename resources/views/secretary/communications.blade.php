@extends('components.dashboard-layout')

@section('title', 'Communications')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">📨</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Communications Center</h1>
                        <p class="text-gray-500 text-sm md:text-base">Manage SACCO communications, notifications, and member correspondence</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="openNewCommunication()"
                    class="px-6 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <span>✉️</span> New Communication
                </button>
            </div>
        </div>
    </div>

    <!-- Communications Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">SMS Sent</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">248</p>
                    <p class="text-gray-500 text-sm mt-1">This month: 42</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">📱</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-green-600 text-xs font-medium">98% delivered</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Emails Sent</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">156</p>
                    <p class="text-gray-500 text-sm mt-1">This month: 28</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">✉️</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-blue-600 text-xs font-medium">92% opened</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Responses</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">12</p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting replies</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-orange-600 text-xs font-medium">3 urgent</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Templates</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">24</p>
                    <p class="text-gray-500 text-sm mt-1">Pre-defined messages</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">📄</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-purple-600 text-xs font-medium">8 active</span>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('sms')" id="smsTab"
                    class="px-6 py-4 font-medium border-b-2 border-blue-600 text-blue-700 whitespace-nowrap">
                    📱 SMS Messages
                </button>
                <button onclick="switchTab('email')" id="emailTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✉️ Emails
                </button>
                <button onclick="switchTab('templates')" id="templatesTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📄 Templates
                </button>
                <button onclick="switchTab('settings')" id="settingsTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ⚙️ Settings
                </button>
            </nav>
        </div>

        <!-- SMS Messages Tab -->
        <div id="smsContent" class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">SMS Messages</h3>
                    <p class="text-gray-500 text-sm">Recent SMS communications</p>
                </div>
                <button onclick="sendSMS()"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <span>📱</span> Send SMS
                </button>
            </div>

            @php
                $smsMessages = [
                    ['to' => 'All Members', 'message' => 'Meeting reminder: SACCO meeting tomorrow 2PM', 'time' => '2 hours ago', 'status' => 'delivered'],
                    ['to' => 'Loan Applicants', 'message' => 'Your loan application is under review', 'time' => '1 day ago', 'status' => 'delivered'],
                    ['to' => 'John Doe', 'message' => 'Your loan approved. Visit office for cheque', 'time' => '2 days ago', 'status' => 'read'],
                    ['to' => 'Pending Approvals', 'message' => 'Document verification required', 'time' => '3 days ago', 'status' => 'delivered'],
                ];
            @endphp

            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Recipients
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Message
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Time Sent
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($smsMessages as $index => $sms)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                <p class="font-medium text-gray-900 text-sm">{{ $sms['to'] }}</p>
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                <p class="text-gray-700 text-sm">{{ $sms['message'] }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                {{ $sms['time'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <span class="px-2 py-1 text-xs rounded-full {{ $sms['status'] == 'delivered' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                    {{ ucfirst($sms['status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <div class="flex gap-2">
                                    <button onclick="resendSMS({{ $index }})"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                        Resend
                                    </button>
                                    <button onclick="viewSMSDetails({{ $index }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Emails Tab -->
        <div id="emailContent" class="p-6 hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Email Communications</h3>
                    <p class="text-gray-500 text-sm">Recent email communications</p>
                </div>
                <button onclick="sendEmail()"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                    <span>✉️</span> Send Email
                </button>
            </div>

            @php
                $emails = [
                    ['subject' => 'Quarterly SACCO Report', 'to' => 'All Members', 'time' => '1 day ago', 'status' => 'opened'],
                    ['subject' => 'Loan Application Update', 'to' => 'Jane Smith', 'time' => '2 days ago', 'status' => 'delivered'],
                    ['subject' => 'Meeting Minutes - April', 'to' => 'Committee Members', 'time' => '3 days ago', 'status' => 'opened'],
                    ['subject' => 'Savings Statement', 'to' => 'John Doe', 'time' => '5 days ago', 'status' => 'read'],
                ];
            @endphp

            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Subject
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Recipients
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Time Sent
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($emails as $index => $email)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                <p class="font-medium text-gray-900 text-sm">{{ $email['subject'] }}</p>
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                <p class="text-gray-700 text-sm">{{ $email['to'] }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                {{ $email['time'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <span class="px-2 py-1 text-xs rounded-full {{ $email['status'] == 'opened' ? 'bg-green-100 text-green-800 border border-green-200' : ($email['status'] == 'read' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-gray-100 text-gray-800 border border-gray-200') }}">
                                    {{ ucfirst($email['status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <div class="flex gap-2">
                                    <button onclick="viewEmail({{ $index }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        View
                                    </button>
                                    <button onclick="resendEmail({{ $index }})"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                        Resend
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Templates Tab -->
        <div id="templatesContent" class="p-6 hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Message Templates</h3>
                    <p class="text-gray-500 text-sm">Pre-defined communication templates</p>
                </div>
                <button onclick="addTemplate()"
                    class="px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-medium hover:bg-purple-700 transition flex items-center gap-2">
                    <span>+</span> Add Template
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $templates = [
                        ['name' => 'Meeting Announcement', 'type' => 'sms', 'category' => 'meetings', 'uses' => '24'],
                        ['name' => 'Loan Approval Notice', 'type' => 'sms', 'category' => 'loans', 'uses' => '18'],
                        ['name' => 'Payment Reminder', 'type' => 'email', 'category' => 'payments', 'uses' => '32'],
                        ['name' => 'Savings Update', 'type' => 'email', 'category' => 'savings', 'uses' => '15'],
                        ['name' => 'Welcome New Member', 'type' => 'email', 'category' => 'members', 'uses' => '12'],
                        ['name' => 'Document Request', 'type' => 'sms', 'category' => 'documents', 'uses' => '8'],
                    ];
                @endphp

                @foreach($templates as $template)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-300 hover:shadow-md transition bg-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 {{ $template['type'] == 'sms' ? 'bg-green-50' : 'bg-blue-50' }} rounded-lg flex items-center justify-center">
                                <span class="{{ $template['type'] == 'sms' ? 'text-green-600' : 'text-blue-600' }} text-sm">
                                    {{ $template['type'] == 'sms' ? '📱' : '✉️' }}
                                </span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $template['name'] }}</span>
                        </div>
                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-full">
                            {{ $template['category'] }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 mb-3">Used {{ $template['uses'] }} times</div>
                    <div class="flex gap-2">
                        <button onclick="useTemplate('{{ $template['name'] }}')"
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white py-2 rounded text-xs font-medium">
                            Use Template
                        </button>
                        <button onclick="editTemplate('{{ $template['name'] }}')"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded text-xs font-medium">
                            Edit
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Settings Tab -->
        <div id="settingsContent" class="p-6 hidden">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Communication Settings</h3>
                <p class="text-gray-500 text-sm">Configure notification preferences</p>
            </div>

            <div class="space-y-4 max-w-2xl">
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-700">📱</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">SMS Notifications</p>
                            <p class="text-sm text-gray-500">Send SMS alerts to members</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-600 transition-colors"></div>
                        <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-700">✉️</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Email Notifications</p>
                            <p class="text-sm text-gray-500">Send email updates to members</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-600 transition-colors"></div>
                        <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-700">⏰</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Auto Reminders</p>
                            <p class="text-sm text-gray-500">Schedule automatic payment reminders</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-600 transition-colors"></div>
                        <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-700">📊</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Reports</p>
                            <p class="text-sm text-gray-500">Send monthly reports automatically</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-600 transition-colors"></div>
                        <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-5 w-5 transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Compose -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Quick Compose</h3>
                <p class="text-gray-500 text-sm">Send a quick message to members</p>
            </div>
            <div class="flex gap-2">
                <button id="quickSMSBtn" onclick="selectQuickType('sms')"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2">
                    📱 SMS
                </button>
                <button id="quickEmailBtn" onclick="selectQuickType('email')"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2">
                    ✉️ Email
                </button>
            </div>
        </div>

        <div class="space-y-4">
            <select id="quickRecipients"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:border-gray-400 focus:ring-0 transition">
                <option value="">Select recipients...</option>
                <option value="all">All Members (156)</option>
                <option value="pending">Pending Approvals (8)</option>
                <option value="loans">Active Loan Holders (24)</option>
                <option value="department">By Department</option>
            </select>

            <textarea id="quickMessage" rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:border-gray-400 focus:ring-0 transition resize-none"
                placeholder="Type your message here..."></textarea>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <p class="text-xs text-gray-500" id="quickCharCount">0/160 characters</p>
                <button onclick="sendQuickMessage()"
                    class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition flex items-center gap-2">
                    <span>📤</span> Send Message
                </button>
            </div>
        </div>
    </div>

</div>

<!-- New Communication Modal -->
<div id="newCommunicationModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">New Communication</h3>
                <button onclick="closeNewCommunication()"
                    class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <span class="text-gray-500 hover:text-gray-700">✕</span>
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Send a message to SACCO members</p>
        </div>

        <div class="p-6 space-y-6">
            <!-- Step Indicators -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-medium">
                        1
                    </div>
                    <div class="h-1 w-12 bg-gray-900"></div>
                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center text-sm font-medium">
                        2
                    </div>
                    <div class="h-1 w-12 bg-gray-200"></div>
                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center text-sm font-medium">
                        3
                    </div>
                </div>
            </div>

            <!-- Step 1: Type & Recipients -->
            <div id="step1" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button onclick="selectCommType('sms')" id="modalSMSBtn"
                        class="p-4 border-2 border-gray-200 rounded-lg hover:border-gray-900 transition text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                <span class="text-green-600 text-xl">📱</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">SMS Message</p>
                                <p class="text-sm text-gray-500">Quick text notification</p>
                            </div>
                        </div>
                    </button>
                    
                    <button onclick="selectCommType('email')" id="modalEmailBtn"
                        class="p-4 border-2 border-gray-200 rounded-lg hover:border-gray-900 transition text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                <span class="text-blue-600 text-xl">✉️</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Email Message</p>
                                <p class="text-sm text-gray-500">Detailed communication</p>
                            </div>
                        </div>
                    </button>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Recipients</label>
                    <select id="modalRecipients"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white text-gray-900 focus:border-gray-400 focus:ring-0 transition-colors">
                        <option value="">Select recipients...</option>
                        <option value="all">All Members (156)</option>
                        <option value="pending">Pending Approvals (8)</option>
                        <option value="loans">Active Loan Holders (24)</option>
                        <option value="defaulted">Defaulted Loans (3)</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button onclick="nextStep()"
                        class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">
                        Next: Compose →
                    </button>
                </div>
            </div>

            <!-- Step 2: Compose -->
            <div id="step2" class="space-y-6 hidden">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Subject</label>
                    <input type="text" id="modalSubject"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                        placeholder="Enter subject (for emails)">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Message</label>
                    <textarea id="modalMessage" rows="4"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 focus:border-gray-400 focus:ring-0 transition-colors resize-none"
                        placeholder="Type your message here..."></textarea>
                    <p class="text-xs text-gray-400 mt-2" id="modalCharCount">0/160 characters</p>
                </div>

                <div class="flex justify-between">
                    <button onclick="prevStep()"
                        class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        ← Back
                    </button>
                    <button onclick="nextToPreview()"
                        class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">
                        Next: Preview →
                    </button>
                </div>
            </div>

            <!-- Step 3: Preview -->
            <div id="step3" class="space-y-6 hidden">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-900 mb-1" id="previewSubject"></p>
                        <p class="text-gray-700 whitespace-pre-wrap" id="previewContent"></p>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button onclick="prevStep()"
                        class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        ← Back
                    </button>
                    <button onclick="sendFinalCommunication()"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center gap-2">
                        <span>📤</span> Send Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab switching
    function switchTab(tabName) {
        // Hide all content
        ['sms', 'email', 'templates', 'settings'].forEach(tab => {
            document.getElementById(tab + 'Content').classList.add('hidden');
            document.getElementById(tab + 'Tab').classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
            document.getElementById(tab + 'Tab').classList.add('text-gray-500');
        });

        // Show selected content
        document.getElementById(tabName + 'Content').classList.remove('hidden');

        // Activate selected tab
        document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-blue-600', 'text-blue-700');
        document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');
    }

    // Quick Compose
    let quickType = 'sms';
    let modalType = 'sms';

    function selectQuickType(type) {
        quickType = type;
        const smsBtn = document.getElementById('quickSMSBtn');
        const emailBtn = document.getElementById('quickEmailBtn');
        
        smsBtn.classList.remove('border-gray-900', 'bg-gray-100');
        emailBtn.classList.remove('border-gray-900', 'bg-gray-100');
        
        if (type === 'sms') {
            smsBtn.classList.add('border-gray-900', 'bg-gray-100');
        } else {
            emailBtn.classList.add('border-gray-900', 'bg-gray-100');
        }
        
        updateQuickCharCount();
    }

    function updateQuickCharCount() {
        const message = document.getElementById('quickMessage');
        const count = message.value.length;
        const max = quickType === 'sms' ? 160 : 1000;
        const charCount = document.getElementById('quickCharCount');
        
        charCount.textContent = `${count}/${max} characters`;
        charCount.className = count > max ? 'text-xs text-red-500' : 'text-xs text-gray-500';
    }

    function sendQuickMessage() {
        const message = document.getElementById('quickMessage').value.trim();
        const recipients = document.getElementById('quickRecipients').value;
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        if (!recipients) {
            alert('Please select recipients');
            return;
        }
        
        if (quickType === 'sms' && message.length > 160) {
            alert('SMS messages must be 160 characters or less');
            return;
        }
        
        alert(`${quickType.toUpperCase()} sent to ${recipients} successfully!`);
        document.getElementById('quickMessage').value = '';
        updateQuickCharCount();
    }

    // Modal Functions
    function openNewCommunication() {
        document.getElementById('newCommunicationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetModal();
    }

    function closeNewCommunication() {
        document.getElementById('newCommunicationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetModal();
    }

    function resetModal() {
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.add('hidden');
        
        modalType = 'sms';
        document.getElementById('modalSMSBtn').classList.add('border-gray-900', 'bg-gray-50');
        document.getElementById('modalEmailBtn').classList.remove('border-gray-900', 'bg-gray-50');
        document.getElementById('modalSubject').value = '';
        document.getElementById('modalMessage').value = '';
        updateModalCharCount();
    }

    function selectCommType(type) {
        modalType = type;
        const smsBtn = document.getElementById('modalSMSBtn');
        const emailBtn = document.getElementById('modalEmailBtn');
        
        smsBtn.classList.remove('border-gray-900', 'bg-gray-50');
        emailBtn.classList.remove('border-gray-900', 'bg-gray-50');
        
        if (type === 'sms') {
            smsBtn.classList.add('border-gray-900', 'bg-gray-50');
        } else {
            emailBtn.classList.add('border-gray-900', 'bg-gray-50');
        }
    }

    function updateModalCharCount() {
        const message = document.getElementById('modalMessage');
        const count = message.value.length;
        const max = modalType === 'sms' ? 160 : 1000;
        const charCount = document.getElementById('modalCharCount');
        
        charCount.textContent = `${count}/${max} characters`;
        charCount.className = count > max ? 'text-xs text-red-500 mt-2' : 'text-xs text-gray-400 mt-2';
    }

    function nextStep() {
        if (!document.getElementById('modalRecipients').value) {
            alert('Please select recipients');
            return;
        }
        
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        
        if (modalType === 'sms') {
            document.getElementById('modalSubject').placeholder = 'SMS Message';
        }
    }

    function prevStep() {
        if (document.getElementById('step2').classList.contains('hidden')) {
            document.getElementById('step3').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        } else {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
        }
    }

    function nextToPreview() {
        const message = document.getElementById('modalMessage').value.trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        if (modalType === 'sms' && message.length > 160) {
            alert('SMS messages must be 160 characters or less');
            return;
        }
        
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.remove('hidden');
        
        // Update preview
        const subject = document.getElementById('modalSubject');
        const previewSubject = document.getElementById('previewSubject');
        const previewContent = document.getElementById('previewContent');
        
        previewSubject.textContent = subject.value || (modalType === 'sms' ? 'SMS Message' : 'No Subject');
        previewContent.textContent = message;
    }

    function sendFinalCommunication() {
        const message = document.getElementById('modalMessage').value.trim();
        
        if (!message) {
            alert('Please enter a message');
            return;
        }
        
        alert(`${modalType.toUpperCase()} communication sent successfully!`);
        closeNewCommunication();
    }

    // Action Functions
    function sendSMS() {
        openNewCommunication();
        selectCommType('sms');
    }

    function sendEmail() {
        openNewCommunication();
        selectCommType('email');
    }

    function resendSMS(index) {
        if (confirm('Resend this SMS message?')) {
            alert('SMS resent successfully!');
        }
    }

    function viewSMSDetails(index) {
        alert('Viewing SMS details...');
    }

    function viewEmail(index) {
        alert('Viewing email details...');
    }

    function resendEmail(index) {
        if (confirm('Resend this email?')) {
            alert('Email resent successfully!');
        }
    }

    function useTemplate(name) {
        alert(`Using template: ${name}\n\nThis would load the template into the composer.`);
        openNewCommunication();
    }

    function editTemplate(name) {
        alert(`Editing template: ${name}`);
    }

    function addTemplate() {
        alert('Add new template form would open here.');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('sms');
        selectQuickType('sms');
        selectCommType('sms');
        
        // Add event listeners
        document.getElementById('quickMessage').addEventListener('input', updateQuickCharCount);
        document.getElementById('modalMessage').addEventListener('input', updateModalCharCount);
        
        // Close modal on outside click
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
@endsection