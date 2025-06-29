<?php

namespace App\Livewire\Forms;

use App\Auth\PlainUser;
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

        $user = DB::select('EXEC sp_Login :nik, :pw', ['nik' => $this->nik, 'pw' => $this->password]);
        $id = DB::table('gm_user')->where('nik', $this->nik)->value('id');

        if (count($user) !== 1) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.nik' => 'Login gagal.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        session([
            'sp_user_data' => [
                'nama' => $user[0]->nama,
                'section' => $user[0]->Section,
                'role' => $user[0]->Role,
                'role_id' => $user[0]->role_id,
            ]
        ]);

        $authUser = new PlainUser([
            'section' => $user[0]->Section,
            'role_id' => $user[0]->role_id,
            'role' => $user[0]->Role,
            'nik' => $user[0]->nik,
            'nama' => $user[0]->nama,
            'id' => $id
        ]);

        Auth::login($authUser);
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
        return Str::transliterate(Str::lower($this->nik) . '|' . request()->ip());
    }
}
