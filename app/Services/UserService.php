<?php

namespace App\Services;

interface UserService
{
    public function login(string $email, string $password): bool;
    public function logout(): bool;
}
