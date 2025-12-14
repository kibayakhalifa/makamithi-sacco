@extends('components.dashboard-layout')

@section('title', 'Documents')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">📁</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Document Management</h1>
                        <p class="text-gray-500 text-sm md:text-base">Manage SACCO documents, meeting minutes, and member files</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="openUploadModal()"
                    class="px-6 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <span>📎</span> Upload Document
                </button>
            </div>
        </div>
    </div>

    <!-- Document Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Documents</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">248</p>
                    <p class="text-gray-500 text-sm mt-1">4.2 GB storage</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">📁</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-blue-600 text-xs font-medium">78% used</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Meeting Minutes</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">36</p>
                    <p class="text-gray-500 text-sm mt-1">Last: 10 Apr 2024</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">📝</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-green-600 text-xs font-medium">3 pending approval</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Loan Documents</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">84</p>
                    <p class="text-gray-500 text-sm mt-1">24 active loans</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">📄</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-orange-600 text-xs font-medium">12 pending review</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Member Files</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">156</p>
                    <p class="text-gray-500 text-sm mt-1">All 156 members</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">👤</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-purple-600 text-xs font-medium">8 incomplete</span>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('all')" id="allTab"
                    class="px-6 py-4 font-medium border-b-2 border-blue-600 text-blue-700 whitespace-nowrap">
                    📁 All Documents
                </button>
                <button onclick="switchTab('minutes')" id="minutesTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📝 Meeting Minutes
                </button>
                <button onclick="switchTab('loans')" id="loansTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📄 Loan Documents
                </button>
                <button onclick="switchTab('members')" id="membersTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    👤 Member Files
                </button>
                <button onclick="switchTab('categories')" id="categoriesTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📊 Categories
                </button>
            </nav>
        </div>

        <!-- All Documents -->
        <div id="allContent" class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">All Documents</h3>
                    <p class="text-gray-500 text-sm">Complete document repository</p>
                </div>
                <div class="flex gap-2">
                    <input type="text" placeholder="Search documents..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm w-full md:w-auto"
                        id="searchInput">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm"
                        id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="minutes">Meeting Minutes</option>
                        <option value="loans">Loan Documents</option>
                        <option value="members">Member Files</option>
                        <option value="financial">Financial Reports</option>
                    </select>
                </div>
            </div>

            @php
                $recentDocs = [
                    ['name' => 'SACCO Meeting Minutes - April 10.pdf', 'type' => 'minutes', 'size' => '2.4 MB', 'uploaded' => '2 hours ago', 'uploader' => 'Secretary', 'category' => 'Meeting Minutes'],
                    ['name' => 'Loan Application - John Doe.docx', 'type' => 'loan', 'size' => '1.2 MB', 'uploaded' => '1 day ago', 'uploader' => 'John Doe', 'category' => 'Loan Documents'],
                    ['name' => 'Member Register - Q1 2024.xlsx', 'type' => 'register', 'size' => '3.8 MB', 'uploaded' => '2 days ago', 'uploader' => 'Secretary', 'category' => 'Member Files'],
                    ['name' => 'Bank Statement - March 2024.pdf', 'type' => 'financial', 'size' => '4.2 MB', 'uploaded' => '3 days ago', 'uploader' => 'Treasurer', 'category' => 'Financial Reports'],
                    ['name' => 'SACCO Constitution.pdf', 'type' => 'policy', 'size' => '5.1 MB', 'uploaded' => '1 week ago', 'uploader' => 'Chairman', 'category' => 'Policies'],
                    ['name' => 'Loan Repayment Schedule.xlsx', 'type' => 'loan', 'size' => '2.8 MB', 'uploaded' => '1 week ago', 'uploader' => 'Treasurer', 'category' => 'Loan Documents'],
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
                                Document
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Category
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Size
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Uploaded
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Uploader
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentDocs as $index => $doc)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 {{ $doc['type'] == 'minutes' ? 'bg-green-50' : ($doc['type'] == 'loan' ? 'bg-orange-50' : 'bg-blue-50') }} rounded-lg flex items-center justify-center mr-3">
                                        <span class="{{ $doc['type'] == 'minutes' ? 'text-green-600' : ($doc['type'] == 'loan' ? 'text-orange-600' : 'text-blue-600') }} text-sm">
                                            {{ $doc['type'] == 'minutes' ? '📝' : ($doc['type'] == 'loan' ? '📄' : '📁') }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $doc['name'] }}</p>
                                        <p class="text-gray-500 text-xs">{{ $doc['type'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $doc['category'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                {{ $doc['size'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                {{ $doc['uploaded'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                {{ $doc['uploader'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <div class="flex gap-2">
                                    <button onclick="downloadDocument('{{ $doc['name'] }}')"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                        Download
                                    </button>
                                    <button onclick="previewDocument('{{ $doc['name'] }}')"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Preview
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Meeting Minutes -->
        <div id="minutesContent" class="p-6 hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Meeting Minutes</h3>
                    <p class="text-gray-500 text-sm">SACCO meeting records</p>
                </div>
                <button onclick="addMeetingMinutes()"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <span>📝</span> Add Minutes
                </button>
            </div>

            @php
                $meetings = [
                    ['date' => '10 Apr 2024', 'title' => 'Monthly SACCO Meeting', 'attendees' => 8, 'status' => 'approved', 'size' => '2.4 MB'],
                    ['date' => '27 Mar 2024', 'title' => 'Loan Committee Meeting', 'attendees' => 5, 'status' => 'approved', 'size' => '1.8 MB'],
                    ['date' => '13 Mar 2024', 'title' => 'Monthly SACCO Meeting', 'attendees' => 8, 'status' => 'approved', 'size' => '2.1 MB'],
                    ['date' => '28 Feb 2024', 'title' => 'Emergency Meeting', 'attendees' => 6, 'status' => 'draft', 'size' => '1.5 MB'],
                ];
            @endphp

            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Meeting Date
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Title
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Attendees
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Size
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($meetings as $meeting)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                {{ $meeting['date'] }}
                            </td>
                            <td class="px-4 py-3 border border-gray-300">
                                <p class="font-medium text-gray-900 text-sm">{{ $meeting['title'] }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                {{ $meeting['attendees'] }} members
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <span class="px-2 py-1 text-xs rounded-full {{ $meeting['status'] == 'approved' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-orange-100 text-orange-800 border border-orange-200' }}">
                                    {{ ucfirst($meeting['status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                {{ $meeting['size'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <div class="flex gap-2">
                                    <button onclick="viewMeeting('{{ $meeting['title'] }}')"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        View
                                    </button>
                                    @if($meeting['status'] == 'draft')
                                    <button onclick="editMeeting('{{ $meeting['title'] }}')"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                        Edit
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Categories -->
        <div id="categoriesContent" class="p-6 hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Document Categories</h3>
                    <p class="text-gray-500 text-sm">Organized by document type</p>
                </div>
                <button onclick="manageCategories()"
                    class="px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-medium hover:bg-purple-700 transition flex items-center gap-2">
                    <span>⚙️</span> Manage Categories
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $categories = [
                        ['name' => 'Meeting Minutes', 'count' => 36, 'icon' => '📝', 'color' => 'green'],
                        ['name' => 'Loan Documents', 'count' => 84, 'icon' => '📄', 'color' => 'orange'],
                        ['name' => 'Member Files', 'count' => 156, 'icon' => '👤', 'color' => 'purple'],
                        ['name' => 'Financial Reports', 'count' => 24, 'icon' => '💰', 'color' => 'blue'],
                        ['name' => 'Policies & Procedures', 'count' => 12, 'icon' => '📋', 'color' => 'red'],
                        ['name' => 'Correspondence', 'count' => 48, 'icon' => '✉️', 'color' => 'indigo'],
                    ];
                @endphp

                @foreach($categories as $category)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-300 hover:shadow-md transition bg-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-{{ $category['color'] }}-50 rounded-lg flex items-center justify-center">
                                <span class="text-{{ $category['color'] }}-600 text-lg">{{ $category['icon'] }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $category['name'] }}</p>
                                <p class="text-gray-500 text-sm">{{ $category['count'] }} documents</p>
                            </div>
                        </div>
                        <span class="text-gray-400">→</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="viewCategory('{{ $category['name'] }}')"
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white py-2 rounded text-xs font-medium">
                            View Documents
                        </button>
                        <button onclick="editCategory('{{ $category['name'] }}')"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded text-xs font-medium">
                            Edit
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Upload & Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Upload</h3>
            <div class="space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-gray-400 transition cursor-pointer"
                     onclick="document.getElementById('fileInput').click()">
                    <div class="text-4xl mb-4">📎</div>
                    <p class="font-medium text-gray-900 mb-2">Drop files here or click to upload</p>
                    <p class="text-sm text-gray-500">Supports PDF, DOC, XLS, JPG up to 10MB</p>
                    <input type="file" id="fileInput" class="hidden" multiple onchange="handleFileUpload(event)">
                </div>

                <div class="space-y-3" id="uploadQueue">
                    <!-- Upload queue will appear here -->
                </div>

                <div class="flex gap-2">
                    <select class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Select category...</option>
                        <option value="minutes">Meeting Minutes</option>
                        <option value="loan">Loan Documents</option>
                        <option value="member">Member Files</option>
                        <option value="financial">Financial Reports</option>
                    </select>
                    <button onclick="processUploads()"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                        Upload
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button onclick="openUploadModal()"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📎</span> Upload Document
                </button>
                <button onclick="addMeetingMinutes()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📝</span> Add Meeting Minutes
                </button>
                <button onclick="generateReport('storage')"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📊</span> Storage Report
                </button>
                <button onclick="exportDocumentList()"
                    class="w-full bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>💾</span> Export Document List
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Upload Document</h3>
                <button onclick="closeUploadModal()"
                    class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <span class="text-gray-500 hover:text-gray-700">✕</span>
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Upload and set access permissions</p>
        </div>

        <form action="{{ route('secretary.documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Title *</label>
                    <input type="text" name="title" id="docTitle"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                        placeholder="e.g., SACCO Meeting Minutes - April 2024" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach([
                            ['id' => 'minutes', 'icon' => '📝', 'name' => 'Meeting Minutes'],
                            ['id' => 'loans', 'icon' => '📄', 'name' => 'Loan Documents'],
                            ['id' => 'members', 'icon' => '👤', 'name' => 'Member Files'],
                            ['id' => 'financial', 'icon' => '💰', 'name' => 'Financial Reports'],
                            ['id' => 'policy', 'icon' => '📋', 'name' => 'Policies'],
                            ['id' => 'other', 'icon' => '📎', 'name' => 'Other']
                        ] as $category)
                        <label class="cursor-pointer">
                            <input type="radio" name="category" value="{{ $category['id'] }}" 
                                class="hidden peer" required>
                            <div class="p-3 border border-gray-200 rounded-lg hover:border-gray-300 transition text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                <div class="text-2xl mb-2">{{ $category['icon'] }}</div>
                                <p class="text-sm font-medium">{{ $category['name'] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Access Control Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Access Control *</label>
                    
                    <!-- Access Type Selection -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                        @foreach([
                            ['id' => 'committee', 'icon' => '👥', 'name' => 'Committee', 'desc' => 'Secretary, Chairman, Treasurer'],
                            ['id' => 'members', 'icon' => '👤', 'name' => 'All Members', 'desc' => 'All SACCO members'],
                            ['id' => 'specific_users', 'icon' => '🎯', 'name' => 'Specific Users', 'desc' => 'Select individual users'],
                            ['id' => 'public', 'icon' => '🌐', 'name' => 'Public', 'desc' => 'Everyone with login'],
                        ] as $access)
                        <label class="cursor-pointer">
                            <input type="radio" name="access_type" value="{{ $access['id'] }}" 
                                class="hidden peer" required onclick="toggleAccessOptions('{{ $access['id'] }}')">
                            <div class="p-3 border border-gray-200 rounded-lg hover:border-gray-300 transition text-center peer-checked:border-green-500 peer-checked:bg-green-50 h-full">
                                <div class="text-2xl mb-2">{{ $access['icon'] }}</div>
                                <p class="text-sm font-medium">{{ $access['name'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $access['desc'] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Committee Roles Selection (hidden by default) -->
                    <div id="committeeOptions" class="hidden space-y-3 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Committee Roles</label>
                        <div class="space-y-2">
                            @foreach(['secretary', 'chairman', 'treasurer'] as $role)
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="allowed_roles[]" value="{{ $role }}"
                                    class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="text-sm text-gray-700 capitalize">{{ $role }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Members Option (hidden by default) -->
                    <div id="membersOptions" class="hidden space-y-3 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-600">
                            This document will be accessible to all members with the "member" role.
                        </p>
                        <input type="hidden" name="allowed_roles[]" value="member">
                    </div>

                    <!-- Specific Users Selection (hidden by default) -->
                    <div id="specificUsersOptions" class="hidden space-y-3 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Users</label>
                        <div class="max-h-48 overflow-y-auto space-y-2">
                            @foreach($users as $user)
                            <label class="flex items-center space-x-3 hover:bg-gray-100 p-2 rounded">
                                <input type="checkbox" name="specific_users[]" value="{{ $user->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                    <span class="text-xs text-gray-500 capitalize">({{ $user->role }})</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Public Option (hidden by default) -->
                    <div id="publicOptions" class="hidden space-y-3 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-600">
                            This document will be accessible to all logged-in users.
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select File *</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-gray-400 transition cursor-pointer"
                         onclick="document.getElementById('modalFileInput').click()">
                        <div class="text-4xl mb-4">📎</div>
                        <p class="font-medium text-gray-900 mb-2">Click to select file</p>
                        <p class="text-sm text-gray-500">Max file size: 10MB</p>
                        <input type="file" name="file" id="modalFileInput" class="hidden" onchange="handleModalFileSelect(event)" required>
                    </div>
                    <div class="mt-3" id="selectedFileInfo"></div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="docDescription" rows="3"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors resize-none"
                        placeholder="Optional description..."></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeUploadModal()"
                        class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                        <span class="mr-2">📤</span>
                        Upload Document
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    // Tab switching
    function switchTab(tabName) {
        // Hide all content
        ['all', 'minutes', 'loans', 'members', 'categories'].forEach(tab => {
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

    // Access control toggling
    function toggleAccessOptions(type) {
        // Hide all options
        ['committeeOptions', 'membersOptions', 'specificUsersOptions', 'publicOptions'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });

        // Clear all checkboxes when switching access types
        if (type !== 'committee') {
            document.querySelectorAll('input[name="allowed_roles[]"]').forEach(cb => {
                cb.checked = false;
            });
        }
        
        if (type !== 'specific_users') {
            document.querySelectorAll('input[name="specific_users[]"]').forEach(cb => {
                cb.checked = false;
            });
        }

        // Show selected option
        if (type === 'committee') {
            document.getElementById('committeeOptions').classList.remove('hidden');
        } else if (type === 'members') {
            document.getElementById('membersOptions').classList.remove('hidden');
        } else if (type === 'specific_users') {
            document.getElementById('specificUsersOptions').classList.remove('hidden');
        } else if (type === 'public') {
            document.getElementById('publicOptions').classList.remove('hidden');
        }
    }

    // Quick Upload (for the old quick upload section - optional)
    let uploadQueue = [];

    function handleFileUpload(event) {
        const files = Array.from(event.target.files);
        
        files.forEach(file => {
            if (file.size > 10 * 1024 * 1024) {
                alert(`File "${file.name}" exceeds 10MB limit`);
                return;
            }
            
            uploadQueue.push(file);
            addToUploadQueue(file);
        });
        
        event.target.value = '';
    }

    function addToUploadQueue(file) {
        const queue = document.getElementById('uploadQueue');
        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-white';
        item.innerHTML = `
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                    📎
                </div>
                <div>
                    <p class="font-medium text-gray-900 text-sm">${file.name}</p>
                    <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                </div>
            </div>
            <button onclick="removeFromQueue('${file.name}')" class="text-gray-500 hover:text-gray-700">
                ✕
            </button>
        `;
        queue.appendChild(item);
    }

    function removeFromQueue(fileName) {
        uploadQueue = uploadQueue.filter(file => file.name !== fileName);
        
        const items = document.querySelectorAll('#uploadQueue div');
        items.forEach(item => {
            if (item.querySelector('.font-medium').textContent === fileName) {
                item.remove();
            }
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function processUploads() {
        if (uploadQueue.length === 0) {
            alert('No files to upload');
            return;
        }
        
        alert(`Uploading ${uploadQueue.length} file(s)...`);
        
        setTimeout(() => {
            alert('Files uploaded successfully!');
            uploadQueue = [];
            document.getElementById('uploadQueue').innerHTML = '';
        }, 2000);
    }

    // Modal Functions
    let selectedCategory = '';

    function openUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetUploadModal();
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetUploadModal();
    }

    function resetUploadModal() {
        selectedCategory = '';
        document.getElementById('uploadForm').reset();
        document.getElementById('selectedFileInfo').innerHTML = '';
        
        // Reset access controls
        document.querySelectorAll('.category-btn').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
        
        // Hide all access options
        ['committeeOptions', 'membersOptions', 'specificUsersOptions', 'publicOptions'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        
        // Uncheck all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.checked = false;
        });
        
        // Uncheck all checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
    }

    function selectCategory(category) {
        selectedCategory = category;
        
        document.querySelectorAll('.category-btn').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
        
        event.target.closest('.category-btn').classList.add('border-gray-900', 'bg-gray-50');
    }

    function handleModalFileSelect(event) {
        const file = event.target.files[0];
        
        if (!file) return;
        
        if (file.size > 10 * 1024 * 1024) {
            alert('File exceeds 10MB limit');
            event.target.value = '';
            return;
        }
        
        document.getElementById('selectedFileInfo').innerHTML = `
            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                        📎
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">${file.name}</p>
                        <p class="text-xs text-gray-500">${formatFileSize(file.size)} • ${file.type}</p>
                    </div>
                </div>
                <button type="button" onclick="clearSelectedFile()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
        `;
    }

    function clearSelectedFile() {
        document.getElementById('modalFileInput').value = '';
        document.getElementById('selectedFileInfo').innerHTML = '';
    }

    // Form validation and submission
    document.addEventListener('DOMContentLoaded', function() {
        const uploadForm = document.getElementById('uploadForm');
        
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                const fileInput = document.getElementById('modalFileInput');
                const accessType = document.querySelector('input[name="access_type"]:checked');
                const title = document.getElementById('docTitle').value.trim();
                const category = document.querySelector('input[name="category"]:checked');
                
                // Validate title
                if (!title) {
                    e.preventDefault();
                    alert('Please enter a document title');
                    return;
                }
                
                // Validate category
                if (!category) {
                    e.preventDefault();
                    alert('Please select a category');
                    return;
                }
                
                // Validate file
                if (!fileInput.files[0]) {
                    e.preventDefault();
                    alert('Please select a file');
                    return;
                }
                
                // Validate access type
                if (!accessType) {
                    e.preventDefault();
                    alert('Please select an access type');
                    return;
                }
                
                // Validate based on access type
                if (accessType.value === 'committee') {
                    const committeeRoles = document.querySelectorAll('input[name="allowed_roles[]"]:checked');
                    if (committeeRoles.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one committee role');
                        return;
                    }
                }
                
                if (accessType.value === 'specific_users') {
                    const specificUsers = document.querySelectorAll('input[name="specific_users[]"]:checked');
                    if (specificUsers.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one user');
                        return;
                    }
                }
                
                // If all validations pass, show loading state
                const submitBtn = uploadForm.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<span class="mr-2">⏳</span> Uploading...';
                submitBtn.disabled = true;
            });
        }
    });

    // Action Functions for existing demo buttons
    function downloadDocument(name) {
        alert(`Downloading: ${name}`);
    }

    function previewDocument(name) {
        alert(`Previewing: ${name}`);
    }

    function addMeetingMinutes() {
        openUploadModal();
        // Auto-select minutes category
        const minutesRadio = document.querySelector('input[name="category"][value="minutes"]');
        if (minutesRadio) {
            minutesRadio.checked = true;
            // Trigger category selection styling if needed
            document.querySelectorAll('.category-btn').forEach(el => {
                el.classList.remove('border-gray-900', 'bg-gray-50');
            });
            const minutesLabel = minutesRadio.closest('label');
            if (minutesLabel) {
                minutesLabel.querySelector('div').classList.add('border-gray-900', 'bg-gray-50');
            }
        }
    }

    function viewMeeting(title) {
        alert(`Viewing: ${title}`);
    }

    function editMeeting(title) {
        alert(`Editing: ${title}`);
    }

    function viewCategory(name) {
        alert(`Viewing category: ${name}`);
    }

    function editCategory(name) {
        alert(`Editing category: ${name}`);
    }

    function manageCategories() {
        alert('Managing categories...');
    }

    function generateReport(type) {
        alert(`Generating ${type} report...`);
    }

    function exportDocumentList() {
        if (confirm('Export document list to Excel?')) {
            alert('Exporting document list...');
        }
    }

    // Search and filter functionality for documents table
    function initDocumentSearch() {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }
        
        if (categoryFilter) {
            categoryFilter.addEventListener('change', function(e) {
                const category = e.target.value;
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    if (!category) {
                        row.style.display = '';
                        return;
                    }
                    
                    const categoryCell = row.querySelector('td:nth-child(2) span');
                    if (categoryCell && categoryCell.textContent.toLowerCase().includes(category)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    }

    // Initialize everything
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('all');
        initDocumentSearch();
        
        // Modal click outside to close
        window.onclick = function(event) {
            const modal = document.getElementById('uploadModal');
            if (event.target === modal) {
                closeUploadModal();
            }
        }
        
        // Escape key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeUploadModal();
            }
        });
        
        // Initialize access type selection for demo
        const defaultAccessType = document.querySelector('input[name="access_type"][value="committee"]');
        if (defaultAccessType) {
            defaultAccessType.checked = true;
            toggleAccessOptions('committee');
            
            // Check secretary by default since they're uploading
            const secretaryCheckbox = document.querySelector('input[name="allowed_roles[]"][value="secretary"]');
            if (secretaryCheckbox) {
                secretaryCheckbox.checked = true;
            }
        }
    });
</script>
@endsection