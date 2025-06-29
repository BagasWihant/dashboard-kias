<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\DB;

class CustomUserProvider implements UserProvider
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function retrieveById($identifier)
    {
        // Ambil user berdasarkan ID dari database
        $userData = DB::table('gm_user')->where('id', $identifier)->first();

        if (!$userData) {
            return null;
        }

        $spData = session('sp_user_data', []);

        // instance  model class
        $modelClass = $this->model;

        return new $modelClass([
            'id' => $userData->id,
            'nik' => $userData->nik,
            'nama' => $spData['nama'] ?? 'No Name',
            'section' => $spData['section'] ?? 'No Section',
            'role' => $spData['role'] ?? 'No Role',
            'role_id' => $spData['role_id'] ?? 'No Role',
        ]);
    }

    public function retrieveByToken($identifier, $token)
    {
        // Tidak digunakan untuk remember token
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Tidak digunakan untuk remember token
    }

    public function retrieveByCredentials(array $credentials)
    {
        // Tidak digunakan dalam kasus ini karena login manual
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Tidak digunakan dalam kasus ini karena validasi manual
        return true;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // Tidak digunakan
    }
}
