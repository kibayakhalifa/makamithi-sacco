@extends('components.dashboard-layout')

@section('title', 'Documents')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Document Management</h1>
                <p class="text-gray-500 mt-1">
                    Manage SACCO documents, meeting minutes, and member files
                </p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openUploadModal()"
                        class="px-6 py-3 rounded-lg bg-gray-900 text-white font-medium hover:bg-gray-800 transition flex items-center">
                    <span class="mr-2">📎</span>
                    Upload Document
                </button>
            </div>
        </div>
    </div>

    <!-- Documents Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Documents -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                            <span class="text-gray-600 text-xl">📁</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Documents</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">248</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">4.2 GB total storage</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        78% used
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                        156 member files
                    </span>
                    <button onclick="viewAllDocuments()" class="text-gray-900 hover:text-gray-700 font-medium">
                        View All
                    </button>
                </div>
            </div>
        </div>

        <!-- Meeting Minutes -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <span class="text-blue-600 text-xl">📝</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Meeting Minutes</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">36</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">Last: 10 Apr 2024</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        3 pending
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                        All approved
                    </span>
                    <button onclick="addMinutes()" class="text-gray-900 hover:text-gray-700 font-medium">
                        Add Minutes
                    </button>
                </div>
            </div>
        </div>

        <!-- Loan Documents -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <span class="text-green-600 text-xl">📄</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Loan Documents</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">84</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">24 active loans</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        12 pending
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></span>
                        Avg: 3.5 per loan
                    </span>
                    <button onclick="viewLoanDocs()" class="text-gray-900 hover:text-gray-700 font-medium">
                        Review
                    </button>
                </div>
            </div>
        </div>

        <!-- Member Files -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                            <span class="text-purple-600 text-xl">👤</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Member Files</p>
                            <p class="text-2xl font-semibold mt-1 text-gray-900">156</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400">All 156 members</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        8 incomplete
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                        Review needed
                    </span>
                    <button onclick="checkMemberFiles()" class="text-gray-900 hover:text-gray-700 font-medium">
                        Check Files
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column: Recent Documents & Uploads -->
        <div class="space-y-6">
            <!-- Recent Documents -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Documents</h3>
                        <p class="text-sm text-gray-500">Last 7 days</p>
                    </div>
                    <button onclick="viewRecentDocs()" class="text-sm text-gray-900 font-medium hover:text-gray-700">
                        View all →
                    </button>
                </div>

                <div class="space-y-4">
                    @php
                        $recentDocs = [
                            ['name' => 'SACCO Meeting Minutes - April 10.pdf', 'type' => 'minutes', 'size' => '2.4 MB', 'uploaded' => '2 hours ago', 'uploader' => 'Secretary'],
                            ['name' => 'Loan Application - John Doe.docx', 'type' => 'loan', 'size' => '1.2 MB', 'uploaded' => '1 day ago', 'uploader' => 'John Doe'],
                            ['name' => 'Member Register - Q1 2024.xlsx', 'type' => 'register', 'size' => '3.8 MB', 'uploaded' => '2 days ago', 'uploader' => 'Secretary'],
                            ['name' => 'Bank Statement - March 2024.pdf', 'type' => 'financial', 'size' => '4.2 MB', 'uploaded' => '3 days ago', 'uploader' => 'Treasurer'],
                        ];
                    @endphp

                    @foreach($recentDocs as $doc)
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg {{ $doc['type'] == 'minutes' ? 'bg-blue-100' : ($doc['type'] == 'loan' ? 'bg-green-100' : 'bg-gray-100') }} flex items-center justify-center mr-3">
                                    <span class="{{ $doc['type'] == 'minutes' ? 'text-blue-600' : ($doc['type'] == 'loan' ? 'text-green-600' : 'text-gray-600') }}">
                                        {{ $doc['type'] == 'minutes' ? '📝' : ($doc['type'] == 'loan' ? '📄' : '📊') }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $doc['name'] }}</p>
                                    <div class="flex items-center space-x-3 mt-1">
                                        <span class="text-xs text-gray-500">{{ $doc['size'] }}</span>
                                        <span class="text-xs text-gray-500">•</span>
                                        <span class="text-xs text-gray-500">{{ $doc['uploaded'] }}</span>
                                        <span class="text-xs text-gray-500">•</span>
                                        <span class="text-xs text-gray-500">By {{ $doc['uploader'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 text-gray-500 hover:text-gray-700" title="Download">
                                    ⬇️
                                </button>
                                <button class="p-2 text-gray-500 hover:text-gray-700" title="Preview">
                                    👁️
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Upload -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Upload</h3>
                    <p class="text-sm text-gray-500">Upload documents quickly</p>
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-gray-400 transition cursor-pointer"
                     onclick="document.getElementById('fileInput').click()">
                    <div class="text-4xl mb-4">📎</div>
                    <p class="font-medium text-gray-900 mb-2">Drop files here or click to upload</p>
                    <p class="text-sm text-gray-500">Supports PDF, DOC, XLS, JPG up to 10MB</p>
                    <input type="file" id="fileInput" class="hidden" multiple onchange="handleFileUpload(event)">
                </div>

                <div class="mt-4 space-y-3" id="uploadQueue">
                    <!-- Upload queue will appear here -->
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                        <option value="">Select category...</option>
                        <option value="minutes">Meeting Minutes</option>
                        <option value="loan">Loan Documents</option>
                        <option value="member">Member Files</option>
                        <option value="financial">Financial Reports</option>
                        <option value="other">Other Documents</option>
                    </select>
                </div>

                <div class="mt-6 flex justify-end">
                    <button onclick="processUploads()"
                            class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition flex items-center">
                        <span class="mr-2">📤</span>
                        Upload All
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Document Categories & Management -->
        <div class="space-y-6">
            <!-- Document Categories -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Document Categories</h3>
                        <p class="text-sm text-gray-500">Organized by type</p>
                    </div>
                    <button onclick="manageCategories()" class="text-sm text-gray-900 font-medium hover:text-gray-700">
                        Manage
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $categories = [
                            ['name' => 'Meeting Minutes', 'count' => 36, 'icon' => '📝', 'color' => 'blue'],
                            ['name' => 'Loan Documents', 'count' => 84, 'icon' => '📄', 'color' => 'green'],
                            ['name' => 'Member Files', 'count' => 156, 'icon' => '👤', 'color' => 'purple'],
                            ['name' => 'Financial Reports', 'count' => 24, 'icon' => '💰', 'color' => 'yellow'],
                            ['name' => 'Policies & Procedures', 'count' => 12, 'icon' => '📋', 'color' => 'red'],
                            ['name' => 'Correspondence', 'count' => 48, 'icon' => '✉️', 'color' => 'indigo'],
                        ];
                    @endphp

                    @foreach($categories as $category)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition cursor-pointer group"
                         onclick="viewCategory('{{ $category['name'] }}')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-{{ $category['color'] }}-100 flex items-center justify-center mr-3">
                                    <span class="text-{{ $category['color'] }}-600">{{ $category['icon'] }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $category['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $category['count'] }} documents</p>
                                </div>
                            </div>
                            <span class="text-gray-400 group-hover:text-gray-600">→</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Meeting Minutes Management -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Meeting Minutes</h3>
                        <p class="text-sm text-gray-500">Recent SACCO meetings</p>
                    </div>
                    <button onclick="addMeetingMinutes()" class="text-sm text-gray-900 font-medium hover:text-gray-700">
                        + Add Minutes
                    </button>
                </div>

                <div class="space-y-4">
                    @php
                        $meetings = [
                            ['date' => '10 Apr 2024', 'title' => 'Monthly SACCO Meeting', 'attendees' => 8, 'status' => 'approved', 'size' => '2.4 MB'],
                            ['date' => '27 Mar 2024', 'title' => 'Loan Committee Meeting', 'attendees' => 5, 'status' => 'approved', 'size' => '1.8 MB'],
                            ['date' => '13 Mar 2024', 'title' => 'Monthly SACCO Meeting', 'attendees' => 8, 'status' => 'approved', 'size' => '2.1 MB'],
                            ['date' => '28 Feb 2024', 'title' => 'Emergency Meeting', 'attendees' => 6, 'status' => 'draft', 'size' => '1.5 MB'],
                        ];
                    @endphp

                    @foreach($meetings as $meeting)
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $meeting['title'] }}</p>
                                <p class="text-sm text-gray-500">{{ $meeting['date'] }} • {{ $meeting['attendees'] }} attendees</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                {{ $meeting['status'] == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($meeting['status']) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ $meeting['size'] }}</span>
                            <div class="flex space-x-2">
                                <button class="text-xs text-gray-900 hover:text-gray-700">View</button>
                                <button class="text-xs text-gray-900 hover:text-gray-700">Download</button>
                                @if($meeting['status'] == 'draft')
                                <button class="text-xs text-gray-900 hover:text-gray-700">Edit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            
        </div>
    </div>

</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Upload Document</h3>
                <button onclick="closeUploadModal()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Upload and categorize a new document</p>
        </div>

        <div class="p-6 space-y-6">
            <!-- Document Details -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Document Title *</label>
                <input type="text" id="docTitle"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       placeholder="e.g., SACCO Meeting Minutes - April 2024">
            </div>

            <!-- Category Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <button class="p-3 border border-gray-200 rounded-lg hover:border-gray-900 transition text-center doc-category"
                            onclick="selectCategory('minutes')">
                        <div class="text-2xl mb-2">📝</div>
                        <p class="text-sm font-medium">Meeting Minutes</p>
                    </button>
                    <button class="p-3 border border-gray-200 rounded-lg hover:border-gray-900 transition text-center doc-category"
                            onclick="selectCategory('loan')">
                        <div class="text-2xl mb-2">📄</div>
                        <p class="text-sm font-medium">Loan Documents</p>
                    </button>
                    <button class="p-3 border border-gray-200 rounded-lg hover:border-gray-900 transition text-center doc-category"
                            onclick="selectCategory('member')">
                        <div class="text-2xl mb-2">👤</div>
                        <p class="text-sm font-medium">Member Files</p>
                    </button>
                    <button class="p-3 border border-gray-200 rounded-lg hover:border-gray-900 transition text-center doc-category"
                            onclick="selectCategory('financial')">
                        <div class="text-2xl mb-2">💰</div>
                        <p class="text-sm font-medium">Financial Reports</p>
                    </button>
                    <button class="p-3 border border-gray-200 rounded-lg hover:border-gray-900 transition text-center doc-category"
                            onclick="selectCategory('policy')">
                        <div class="text-2xl mb-2">📋</div>
                        <p class="text-sm font-medium">Policies</p>
                    </button>
                    <button class="p-3 border border-gray-200 rounded-lg hover:border-gray-900 transition text-center doc-category"
                            onclick="selectCategory('other')">
                        <div class="text-2xl mb-2">📎</div>
                        <p class="text-sm font-medium">Other</p>
                    </button>
                </div>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select File *</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-gray-400 transition cursor-pointer"
                     onclick="document.getElementById('modalFileInput').click()">
                    <div class="text-4xl mb-4">📎</div>
                    <p class="font-medium text-gray-900 mb-2">Click to select file</p>
                    <p class="text-sm text-gray-500">Max file size: 10MB</p>
                    <input type="file" id="modalFileInput" class="hidden" onchange="handleModalFileSelect(event)">
                </div>
                <div class="mt-3" id="selectedFileInfo"></div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="docDescription" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                          placeholder="Optional description of the document..."></textarea>
            </div>

            <!-- Access Control -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Access Permissions</label>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="radio" name="access" checked class="mr-3">
                        <div>
                            <p class="font-medium text-gray-900">Committee Members Only</p>
                            <p class="text-sm text-gray-500">Chairman, Treasurer, Secretary</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="access" class="mr-3">
                        <div>
                            <p class="font-medium text-gray-900">All Members</p>
                            <p class="text-sm text-gray-500">Visible to all SACCO members</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="access" class="mr-3">
                        <div>
                            <p class="font-medium text-gray-900">Restricted</p>
                            <p class="text-sm text-gray-500">Specific members only</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <button onclick="closeUploadModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button onclick="uploadDocument()"
                        class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition flex items-center">
                    <span class="mr-2">📤</span>
                    Upload Document
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Quick Upload Functions
    let uploadQueue = [];

    function handleFileUpload(event) {
        const files = Array.from(event.target.files);
        
        files.forEach(file => {
            if (file.size > 10 * 1024 * 1024) { // 10MB limit
                alert(`File "${file.name}" exceeds 10MB limit`);
                return;
            }
            
            uploadQueue.push(file);
            addToUploadQueue(file);
        });
        
        // Clear file input
        event.target.value = '';
    }

    function addToUploadQueue(file) {
        const queue = document.getElementById('uploadQueue');
        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-3 border border-gray-200 rounded-lg';
        item.innerHTML = `
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                    📎
                </div>
                <div>
                    <p class="font-medium text-gray-900">${file.name}</p>
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
        
        // Remove from UI
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
        
        // Simulate upload
        setTimeout(() => {
            alert('Files uploaded successfully!');
            uploadQueue = [];
            document.getElementById('uploadQueue').innerHTML = '';
        }, 2000);
    }

    // Upload Modal Functions
    let selectedCategory = '';

    function openUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
        resetUploadModal();
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        resetUploadModal();
    }

    function resetUploadModal() {
        selectedCategory = '';
        document.getElementById('docTitle').value = '';
        document.getElementById('docDescription').value = '';
        document.getElementById('selectedFileInfo').innerHTML = '';
        
        // Reset category selection
        document.querySelectorAll('.doc-category').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
    }

    function selectCategory(category) {
        selectedCategory = category;
        
        // Update selection
        document.querySelectorAll('.doc-category').forEach(el => {
            el.classList.remove('border-gray-900', 'bg-gray-50');
        });
        
        event.target.closest('.doc-category').classList.add('border-gray-900', 'bg-gray-50');
    }

    function handleModalFileSelect(event) {
        const file = event.target.files[0];
        
        if (file.size > 10 * 1024 * 1024) {
            alert('File exceeds 10MB limit');
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
                        <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                    </div>
                </div>
                <button onclick="clearSelectedFile()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
        `;
    }

    function clearSelectedFile() {
        document.getElementById('modalFileInput').value = '';
        document.getElementById('selectedFileInfo').innerHTML = '';
    }

    function uploadDocument() {
        const title = document.getElementById('docTitle').value;
        
        if (!title.trim()) {
            alert('Please enter a document title');
            return;
        }
        
        if (!selectedCategory) {
            alert('Please select a category');
            return;
        }
        
        if (!document.getElementById('modalFileInput').files[0]) {
            alert('Please select a file');
            return;
        }
        
        // Show success message
        alert('Document uploaded successfully!');
        closeUploadModal();
    }

    // Other functions
    function viewAllDocuments() {
        alert('Viewing all documents...');
    }

    function addMinutes() {
        alert('Adding meeting minutes...');
        openUploadModal();
    }

    function viewLoanDocs() {
        alert('Viewing loan documents...');
    }

    function checkMemberFiles() {
        alert('Checking member files...');
    }

    function viewRecentDocs() {
        alert('Viewing recent documents...');
    }

    function manageCategories() {
        alert('Managing categories...');
    }

    function viewCategory(name) {
        alert(`Viewing category: ${name}`);
    }

    function addMeetingMinutes() {
        alert('Adding meeting minutes...');
        openUploadModal();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('uploadModal');
            if (event.target == modal) {
                closeUploadModal();
            }
        }
    });
</script>

<style>
    .doc-category.border-gray-900 {
        border-color: #111827;
        background-color: #f9fafb;
    }
    
    .file-upload:hover {
        border-color: #6b7280;
    }
    
    .storage-bar {
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .storage-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #10b981);
    }
</style>
@endsection