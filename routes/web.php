<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Pages\Dashboard\Index;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    
    Route::get('/', Index::class)->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::post('/logout', function (Logout $logout) {
        $logout();

        return redirect('/');
    })->name('logout');
});

Route::middleware('guest')->group(function () {
    Volt::route('login', 'pages.auth.login')
    ->name('login');
});

// require __DIR__.'/auth.php';
