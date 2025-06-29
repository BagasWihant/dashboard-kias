<?php

namespace App\Providers;

use App\Auth\CustomUserProvider;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        // Auth::provider('plaintext', function ($app, array $config) {
        //     return new class($app['db']->connection(), $app['hash'], $config['table']) extends DatabaseUserProvider
        //     {
        //         public function validateCredentials($user, array $credentials)
        //         {
        //             return $credentials['password'] === $user->getAuthPassword();
        //         }

        //         public function retrieveByToken($identifier, $token)
        //         {
        //             // Abaikan token
        //             return $this->retrieveById($identifier);
        //         }
    
        //         public function updateRememberToken($user, $token): void
        //         {
        //             // Jangan update token
        //         }
        //     };
        // });

        Auth::provider('custom', function ($app, array $config) {
            return new CustomUserProvider($config['model']);
        });
    }
}
