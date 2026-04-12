<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect($notification->data['url'] ?? url('/'));
    }

    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function destroyAll()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->notifications()->delete();

        return back()->with('success', 'All notifications cleared.');
    }
}
