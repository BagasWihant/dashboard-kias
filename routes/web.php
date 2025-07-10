<?php

use App\Http\Controllers\BladeController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Actions\Logout;
use App\Livewire\Pages\Dashboard\AppsHome;
use App\Livewire\Pages\Dashboard\AppsInMenu;
use App\Livewire\Pages\Dashboard\Index;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->group(function () {
    
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/apps/{id}', [DashboardController::class,'appHome'])->name('apps-home');
    Route::get('/apps/{id1}/{id2}', AppsInMenu::class)->name('apps-in-menu');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::post('/logout', [BladeController::class,'login'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [BladeController::class,'login'])->name('login');
    Route::post('/login', [BladeController::class,'loginPost'])->name('loginPost');

});

// require __DIR__.'/auth.php';
