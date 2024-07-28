<?php

namespace App\Http\Controllers;

use App\Mail\AccessCodeMail;
use App\Models\AccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccessCodeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            // Validasi lainnya
        ]);

        // Generate access code
        $code = Str::random(8); // Menghasilkan kode acak sepanjang 8 karakter

        // Simpan kode akses ke dalam database
        $accessCode = AccessCode::create([
            'code' => $code,
            'email' => $request->email,
        ]);

        // Kirim email ke admin baru dengan kode akses
        Mail::to($request->email)->send(new AccessCodeMail($accessCode));

        return redirect()->back()->with('success', 'Access code has been sent to the new admin.');
    }
}
