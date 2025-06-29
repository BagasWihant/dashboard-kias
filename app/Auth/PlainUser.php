<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class PlainUser implements Authenticatable
{
    public string $nama;
    public int $id;
    public string $role_id;
    public string $role;
    public string $nik;
    public string $section;
    public string $password;

    public function __construct(array $data)
    {
        $this->section = $data['section'] ?? '';
        $this->nik = $data['nik'] ?? '';
        $this->nama = $data['nama'] ?? '';
        $this->role_id = $data['role_id'] ?? '';
        $this->role = $data['role'] ?? '';
        $this->id = $data['id'] ?? 0;
    }

    public function __serialize(): array
    {
        return [
            'nama' => $this->nama,
            'role_id' => $this->role_id,
            'role' => $this->role,
            'nik' => $this->nik,
            'section' => $this->section,
            'id' => $this->id,
        ];
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
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
