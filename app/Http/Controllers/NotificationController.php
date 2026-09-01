<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NotificationUpdated;
use App\Models\DeptAccount;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all'); // 'all' or 'unread'
        $limit = $request->get('limit', 20);

        // Get the authenticated account (could be User or DeptAccount)
        $account = Auth::user();
        if (!$account) {
            return redirect()->route('login');
        }

        $query = $account->notifications()->latest();

        if ($status === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->paginate($limit);

        return view('notifications.index', compact('notifications', 'status'));
    }

    public function getUnreadCount()
    {
        $account = Auth::user();
        if (!$account) {
            return response()->json(['count' => 0]);
        }
        $count = $account->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }

    public function list(Request $request)
    {
        $status = $request->get('status', 'unread'); // 'all' or 'unread'
        $limit = (int) ($request->get('limit', 10));

        $account = Auth::user();
        if (!$account) {
            return response()->json([
                'success' => true,
                'count' => 0,
                'notifications' => []
            ]);
        }

        $query = $account->notifications()->latest();

        if ($status === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->take($limit)->get();

        return response()->json([
            'success' => true,
            'count' => $account->unreadNotifications()->count(),
            'notifications' => $notifications->map(function ($notification) {
                $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->toIso8601ZuluString(),
                ];
            })
        ]);
    }

    public function markAsRead($id)
    {
        try {
            $account = Auth::user();
            if (!$account) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            // Force update via query to ensure persistence
            $account->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);

            // Broadcast update
            event(new NotificationUpdated($id, 'read', $account));

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification marked as read',
                    'unread_count' => $account->unreadNotifications()->count(),
                ]);
            }

            return back();
        } catch (\Exception $e) {
            \Log::error('MarkAsRead Error: ' . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error marking notification as read'], 500);
            }
            return back()->with('error', 'Error marking notification as read');
        }
    }

    public function markAllAsRead()
    {
        try {
            $account = Auth::user();
            if (!$account) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            // Direct DB update for reliability
            $account->unreadNotifications()->update(['read_at' => now()]);

            // Broadcast update - other tabs will receive unread_count: 0
            event(new NotificationUpdated(null, 'all_read', $account));

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
                'unread_count' => 0,
            ]);
        } catch (\Exception $e) {
            \Log::error('MarkAllAsRead Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error marking all notifications as read'], 500);
        }
    }

    public function clear($id)
    {
        try {
            $account = Auth::user();
            if (!$account) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            $notification = $account->notifications()->findOrFail($id);

            // Delete the notification
            $notification->delete();

            // Broadcast update
            event(new NotificationUpdated($id, 'cleared', $account));

            return response()->json([
                'success' => true,
                'message' => 'Notification cleared',
                'unread_count' => $account->unreadNotifications()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error clearing notification'], 500);
        }
    }

    public function clearAll()
    {
        try {
            $account = Auth::user();
            if (!$account) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            // Delete all notifications
            $account->notifications()->delete();

            // Broadcast update
            event(new NotificationUpdated(null, 'all_cleared', $account));

            return response()->json([
                'success' => true,
                'message' => 'All notifications cleared',
                'unread_count' => 0,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error clearing all notifications'], 500);
        }
    }
}