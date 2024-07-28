<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required', 
                'min:8', 
                'regex:/[a-z]/',      // harus ada huruf kecil
                'regex:/[A-Z]/',      // harus ada huruf besar
                'regex:/[0-9]/',      // harus ada angka
                'regex:/[@$!%*#?&]/'  // harus ada karakter spesial
            ],
            'terms' => 'required'
        ]);

        
        $user = User::create([
            'username' => $attributes['username'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
            'role' => 'user', // Atur default role saat pendaftaran
        ]);
        auth()->login($user);

        return redirect('/dashboard');
    }
}