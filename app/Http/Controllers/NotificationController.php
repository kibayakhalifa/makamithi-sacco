<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function open(Notification $notification)
    {
        // Security: ensure user owns the notification
        abort_if($notification->user_id !== Auth::id(), 403);

        // ✅ STEP 4 HAPPENS HERE
        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        // Redirect to the actual communication
        return redirect($notification->link ?? route('member.dashboard'));
    }
}
