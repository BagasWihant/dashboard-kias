<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Pages\Dashboard\AppsHome;
use App\Livewire\Pages\Dashboard\AppsInMenu;
use App\Livewire\Pages\Dashboard\Index;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    
    Route::get('/', Index::class)->name('dashboard');
    Route::get('/apps/{id}', AppsHome::class)->name('apps-home');
    Route::get('/apps/{id1}/{id2}', AppsInMenu::class)->name('apps-in-menu');

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
