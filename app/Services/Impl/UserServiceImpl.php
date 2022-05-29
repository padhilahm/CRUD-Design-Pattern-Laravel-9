<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{

    public function login(string $email, string $password): bool
    {
        // cek apakah email dan password benar
        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            return true;
        }

        return false;
    }

    public function logout(): bool
    {
        auth()->logout();

        return true;
    }
}
