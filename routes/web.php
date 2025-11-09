<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('filament.pages.selector-login');
})->name('login.selector');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->rol === 'veterinario') {
        return redirect('/veterinario');
    }

    return redirect('/admin');
})->middleware(['auth'])->name('dashboard');
