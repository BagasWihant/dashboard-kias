<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class PlainUser implements Authenticatable
{
    public int $id;
    public string $nik;
    public string $password;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->nik = $data['nik'];
        $this->password = $data['password'];
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getRememberToken(): ?string
    {
        return null;
    }

    public function setRememberToken($value): void
    {
        // Do nothing
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }
}
