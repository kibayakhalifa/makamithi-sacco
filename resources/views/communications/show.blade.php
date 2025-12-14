@extends('components.dashboard-layout')

@section('title', $communication->title)

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <a href="{{ route('communications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2 mb-3">
                    <span>←</span> Back to Notifications
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 {{ $communication->type === 'announcement' ? 'bg-green-100' : ($communication->type === 'notice' ? 'bg-blue-100' : 'bg-purple-100') }} rounded-xl flex items-center justify-center">
                        <span class="{{ $communication->type === 'announcement' ? 'text-green-600' : ($communication->type === 'notice' ? 'text-blue-600' : 'text-purple-600') }} font-bold">
                            {{ $communication->type === 'announcement' ? '📢' : ($communication->type === 'notice' ? '📋' : '📝') }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">{{ $communication->title }}</h1>
                        <p class="text-gray-500 text-sm md:text-base">Notification Details</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $communication->type === 'announcement' ? 'bg-green-100 text-green-800 border border-green-200' : ($communication->type === 'notice' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-purple-100 text-purple-800 border border-purple-200') }}">
                    {{ ucfirst($communication->type) }}
                </span>
                @if(auth()->user()->role !== 'member')
                <button onclick="openDeleteModal()"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
                    <span>🗑️</span> Delete
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Notification Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Message Content</h3>
                <div class="prose max-w-none">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $communication->body }}</p>
                </div>
            </div>

            <!-- Audience Information -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Audience Information</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <span class="text-gray-700">👥</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Target Audience</p>
                                <p class="text-sm text-gray-500">
                                    @if($communication->audience_type === 'all')
                                        All Members
                                    @elseif($communication->audience_type === 'committee')
                                        Committee Members Only
                                    @elseif($communication->audience_type === 'role')
                                        Specific Roles
                                    @else
                                        Specific Users
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($communication->audience_type === 'role' && $communication->allowed_roles)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Selected Roles:</p>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $allowedRoles = json_decode($communication->allowed_roles, true) ?: [];
                            @endphp
                            @foreach($allowedRoles as $role)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full border border-blue-200">
                                {{ ucfirst($role) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($communication->audience_type === 'specific' && $communication->specific_users)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Selected Users:</p>
                        <div class="space-y-2">
                            @php
                                $specificUsers = json_decode($communication->specific_users, true) ?: [];
                            @endphp
                            @foreach($specificUsers as $userId)
                                @php
                                    $user = \App\Models\User::find($userId);
                                @endphp
                                @if($user)
                                <div class="flex items-center justify-between p-2 border border-gray-100 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-gray-700 text-sm font-medium">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ $user->name }}</p>
                                            <p class="text-gray-500 text-xs">{{ $user->employee_number ?? 'N/A' }} • {{ ucfirst($user->role) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Sender Information -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sender Information</h3>
                <div class="flex items-center gap-3 p-3 border border-gray-100 rounded-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 text-lg font-medium">
                            {{ strtoupper(substr($communication->creator->name ?? 'System', 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $communication->creator->name ?? 'System' }}</p>
                        <p class="text-gray-500 text-sm">{{ ucfirst($communication->creator->role ?? 'System') }}</p>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                            <span class="text-green-600 text-sm">📤</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Sent</p>
                            <p class="text-gray-500 text-sm">{{ $communication->created_at->format('d M Y, h:i A') }}</p>
                            <p class="text-gray-400 text-xs">{{ $communication->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($communication->updated_at->gt($communication->created_at))
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-1">
                            <span class="text-blue-600 text-sm">✏️</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Last Updated</p>
                            <p class="text-gray-500 text-sm">{{ $communication->updated_at->format('d M Y, h:i A') }}</p>
                            <p class="text-gray-400 text-xs">{{ $communication->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    @if(auth()->user()->role !== 'member')
                    <a href="{{ route('communications.edit', $communication->id) }}"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium flex items-center justify-center gap-2 text-sm transition">
                        <span>✏️</span> Edit Notification
                    </a>
                    @endif
                    <button onclick="window.print()"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2.5 rounded-lg font-medium flex items-center justify-center gap-2 text-sm transition">
                        <span>🖨️</span> Print
                    </button>
                    <button onclick="copyToClipboard()"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2.5 rounded-lg font-medium flex items-center justify-center gap-2 text-sm transition">
                        <span>📋</span> Copy Link
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Delete Notification</h3>
                <button onclick="closeDeleteModal()"
                    class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <span class="text-gray-500 hover:text-gray-700">✕</span>
                </button>
            </div>
        </div>

        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <span class="text-red-600 text-lg">⚠️</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Are you sure?</p>
                    <p class="text-gray-500 text-sm">This action cannot be undone.</p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <p class="text-gray-900 font-medium mb-1">{{ $communication->title }}</p>
                <p class="text-gray-500 text-sm">{{ Str::limit($communication->body, 100) }}</p>
                <p class="text-gray-400 text-xs mt-2">Created: {{ $communication->created_at->format('d M Y') }}</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()"
                    class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    Cancel
                </button>
                <form action="{{ route('communications.destroy', $communication->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center gap-2">
                        <span>🗑️</span> Delete Notification
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Delete Modal Functions
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside or pressing Escape
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }

    function printNotification() {
        const printContent = `
            <div style="padding: 20px; font-family: Arial, sans-serif;">
                <h1 style="color: #111827; margin-bottom: 10px;">${document.title}</h1>
                <hr style="margin: 20px 0;">
                <div style="margin-bottom: 20px;">
                    <strong>Title:</strong> {{ $communication->title }}<br>
                    <strong>Type:</strong> {{ ucfirst($communication->type) }}<br>
                    <strong>Sent:</strong> {{ $communication->created_at->format('d M Y, h:i A') }}<br>
                    <strong>By:</strong> {{ $communication->creator->name ?? 'System' }}
                </div>
                <hr style="margin: 20px 0;">
                <div style="margin-bottom: 20px;">
                    <strong>Message:</strong><br>
                    {{ $communication->body }}
                </div>
                <hr style="margin: 20px 0;">
                <div style="font-size: 12px; color: #6b7280; text-align: center; margin-top: 40px;">
                    Printed from Makamithi SACCO System on {{ date('d M Y, h:i A') }}
                </div>
            </div>
        `;
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print - {{ $communication->title }}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        @media print { body { margin: 0; padding: 20px; } }
                    </style>
                </head>
                <body>${printContent}</body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    // Override window.print to use custom print function
    window.print = printNotification;
</script>
@endsection