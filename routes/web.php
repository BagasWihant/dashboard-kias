<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');




Route::middleware('auth')->group(function () {
    // Route::get('setup-apps')->middleware('auth')->name('setup-apps');
    Volt::route('setup-apps', 'pages.setup.apps')
    ->name('setup-apps');
    Volt::route('dashboard', 'pages.dashboard.dashboard')
    ->name('dashboard');

    // Route::view('dashboard', 'dashboard')
    //     ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::post('/logout', function (Logout $logout) {
        $logout();
        return redirect('/');
    })->name('logout');
});

require __DIR__ . '/auth.php';
