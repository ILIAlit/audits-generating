<?php

use App\Models\User;
use Laravel\Socialite\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/auth/google/redirect', function(Request $request){
    return Socialite::driver('google')->redirect();
})->name('google.redirect');

Route::get('/auth/google/callback', function(Request $request){
    $googleUser = Socialite::driver('google')->user();
    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'avatar' => $googleUser->avatar,
        'password' => Str::password(12),
    ]);

    Auth::login($user);

    return redirect()->route('dashboard');
});
