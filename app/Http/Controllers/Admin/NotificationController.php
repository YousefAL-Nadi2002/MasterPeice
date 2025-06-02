<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:info,success,warning,error',
            'user_id' => 'nullable|exists:users,id',
            'send_to_all' => 'required|boolean',
        ]);

        if ($validated['send_to_all']) {
            $users = User::where('is_admin', false)->get();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $validated['title'],
                    'message' => $validated['message'],
                    'type' => $validated['type'],
                    'read_at' => null,
                ]);
            }
        } else {
            Notification::create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
                'read_at' => null,
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم إرسال الإشعار بنجاح');
    }

    public function show(Notification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم حذف الإشعار بنجاح');
    }

    public function markAllAsRead()
    {
        Notification::whereNull('read_at')->update(['read_at' => now()]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read_at' => now()]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم تحديد الإشعار كمقروء');
    }
}
