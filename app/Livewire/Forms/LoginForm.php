<?php

namespace App\Livewire\Forms;

use App\Http\Controllers\Auth\PlainUser;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $nik = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = DB::table('gm_user')->where('nik', $this->nik)->first();

        if (! $user || $user->password !== $this->password) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.nik' => 'Login gagal.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Login manual tanpa Auth::attempt
        $authUser = new PlainUser([
            'id' => $user->id,
            'nik' => $user->nik,
            'password' => $user->password,
        ]);
        
        Auth::guard('web')->login($authUser); 
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.nik' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->nik).'|'.request()->ip());
    }
}
