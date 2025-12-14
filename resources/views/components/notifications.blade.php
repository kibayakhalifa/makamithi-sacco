@php
    $user = auth()->user();
    $notifications = $user->notifications()->latest()->take(10)->get();
@endphp

<div class="relative">
    <button class="relative">
        Notifications
        @if($notifications->where('read_at', null)->count() > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">
                {{ $notifications->where('read_at', null)->count() }}
            </span>
        @endif
    </button>

    <div class="absolute right-0 mt-2 w-80 bg-white border rounded shadow-lg z-50">
        @forelse($notifications as $notification)
            <a href="{{ $notification->link }}" class="block p-2 hover:bg-gray-100 {{ is_null($notification->read_at) ? 'font-bold' : '' }}">
                {{ $notification->message }}
                <span class="text-xs text-gray-400 float-right">{{ $notification->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <p class="p-2 text-gray-500">No notifications</p>
        @endforelse
    </div>
</div>
