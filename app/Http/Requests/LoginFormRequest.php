<?php

namespace App\Http\Requests;

use App\Auth\PlainUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;

class LoginFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $nik = $this->input('nik');
        $password = $this->input('password');

        $user = DB::select('EXEC sp_Login :nik, :pw', [
            'nik' => $nik,
            'pw' => $password,
        ]);

        $id = DB::table('gm_user')->where('nik', $nik)->value('id');

        if (count($user) !== 1) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nik' => 'Login gagal.',
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
            'id' => $id,
        ]);

        Auth::login($authUser, $this->boolean('remember'));
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nik' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('nik')) . '|' . $this->ip());
    }
}
