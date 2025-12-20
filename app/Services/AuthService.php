<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function authenticate(string $username, string $password): ?User
    {
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return Auth::user();
        }

        return null;
    }
}
