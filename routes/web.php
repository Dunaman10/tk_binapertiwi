<?php

use Illuminate\Support\Facades\Route;

use App\Models\Gallery;
use App\Models\Profil;

Route::get('/', function () {
    $profile = Profil::first();
    $galleries = Gallery::latest()->take(5)->get();
    return view('index', compact('profile', 'galleries'));
});

Route::get('/login', function () {
    return redirect()->route('filament.auth.auth.login');
})->name('login');
