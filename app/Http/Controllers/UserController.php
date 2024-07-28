<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Perbarui status notifikasi admin request menjadi dibaca
        Notification::where('type', 'admin request')
            ->where('is_read', false)
            ->update(['is_read' => true]);
    
        $users = User::with('notifications')->get(); // Pastikan notifikasi dimuat
    
        return view('pages.user-management', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        // Kirim notifikasi update
        Notification::create([
            'id' => Auth::id(),
            'type' => 'update',
            'message' => 'Updates have been made to user with ID number ' . $user->id,
        ]);

        return back()->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Menggunakan soft delete

        // Kirim notifikasi delete
        Notification::create([
            'id' => Auth::id(),
            'type' => 'delete',
            'message' => 'A deletion has been made to user with ID number ' . $user->id,
        ]);

        return redirect()->route('user-management')->with('success', 'User deleted successfully');
    }

    // fungsi validasi password di halaman profile
    public function validatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid password.']);
    }

    public function setRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully');
    }

    // Fungsi ganti role
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        // Kirim notifikasi ke admin yang mengubah role
        Notification::create([
            'id' => Auth::id(),
            'type' => 'Change Status',
            'message' => 'Change status have been made to user with ID number ' . $user->id,
        ]);

        // Kirim notifikasi ke user yang role-nya diubah
        Notification::create([
            'id' => $user->id,
            'type' => 'Change Status',
            'message' => 'Your role has been updated to ' . $user->role,
            'is_read' => false,
        ]);

        return redirect()->route('editUser', ['id' => $id])->with('success', 'Role updated successfully.');
    }
}
