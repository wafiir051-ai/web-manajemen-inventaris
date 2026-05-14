<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    // Fungsi untuk mengarahkan ke Google
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    // Fungsi untuk menerima data dari Google
    public function handleGoogleCallback() {
        $googleUser = Socialite::driver('google')->user();

        // Cari user berdasarkan email, kalau tidak ada buat baru
        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'password' => bcrypt(str()->random(16)), // Password acak karena login via Google
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}
