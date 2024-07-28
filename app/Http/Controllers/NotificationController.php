<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function notif()
    {
        $userId = Auth::id();
        
        // Atur status berdasarkan session
        if (!session()->has('notifications_read')) {
            Notification::where('id', $userId)
                        ->where('is_read', false)
                        ->update(['is_read' => true]);
    
            // Set session untuk menandai bahwa notifikasi telah dibaca
            session(['notifications_read' => true]);
        }
    
        $hasNewNotifications = Notification::where('id', $userId)
                                            ->where('is_read', false)
                                            ->exists();
    
        $unreadNotificationsCount = Notification::where('id', $userId)
                                                ->where('is_read', false)
                                                ->count();
    
        // Dapatkan semua notifikasi
        $notifications = Notification::where('id', $userId)
                                     ->orderBy('created_at', 'desc')
                                     ->get();
    
        return view('pages.notification', compact('notifications', 'hasNewNotifications', 'unreadNotificationsCount'));
    }

    public function adminRequestNotification()
    {
        // Mengambil jumlah notifikasi admin request yang belum dibaca
        $unreadAdminRequestsCount = Notification::where('type', 'admin request')
            ->where('is_read', false)
            ->count();

        // Kirimkan data ke view
        return view('layouts/navbars/auth/sidenav', compact('unreadAdminRequestsCount'));
    }


    
    public function destroy($id_notification)
    {

        $notification = Notification::findOrFail($id_notification);
        $notification->delete();

        return redirect()->route('notifications.notif')->with('success', 'Notification deleted successfully');
    }
}
