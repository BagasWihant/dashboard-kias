<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        // Auth::guard('web')->logout();
        Auth::logout();
        session()->forget('sp_user_data');
        // session()->forget(config('auth.session'));
        Session::invalidate();
        Session::regenerateToken();
    }
}
