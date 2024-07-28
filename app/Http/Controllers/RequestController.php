<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AdminRequestNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class RequestController extends Controller
{
    // Fungsi notifikasi request
    public function sendRequest()
    {
        // $user = Auth::user();
        
        // $superAdmins = User::where('role', 'super_admin')->get();

        // foreach ($superAdmins as $superAdmin) {
        //     Notification::send($superAdmin, new AdminRequestNotification($user));
        // }

        $user = Auth::user();
    
        // Kirim notifikasi kepada super_admin
        $superAdmins = User::where('role', 'super_admin')->get();
        foreach ($superAdmins as $superAdmin) {
            Notification::create([
                'id' => $superAdmin->id,
                'type' => 'Admin Request',
                'message' => 'You have received a new admin request from ' . $user->username,
                'is_read' => false,
            ]);
        }

        // Kirim notifikasi kepada pengguna dengan peran 'user'
        Notification::create([
            'id' => $user->id,
            'type' => 'Send Request',
            'message' => 'You have sent an admin request',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Request sent successfully.');
    }
}
