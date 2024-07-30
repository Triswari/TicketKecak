<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallBack()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Mencari pengguna berdasarkan google_id
            $findUser = User::where('google_id', $googleUser->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect('/dashboard');
            } else {
                // Gunakan nama pengguna dari Google atau alamat email sebagai username
                $username = $googleUser->name ?? $googleUser->email;

                // Buat pengguna baru
                $newUser = User::create([
                    'username' => $username,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                ]);

                Auth::login($newUser);
                return redirect('/dashboard');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}

