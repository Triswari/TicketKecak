<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Pastikan model User diimpor
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallBack()
    {
        try {
            $user = Socialite::driver('google')->user();

            $findUser = User::where('id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('pages.dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                    'email_verified_at' => now(),
                ]);

                Auth::login($newUser);
                return redirect()->intended('pages.dashboard');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
