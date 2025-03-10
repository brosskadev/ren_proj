<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface{
    protected $authRepo;

    public function __construct(AuthRepository $authRepo){
        $this->authRepo = $authRepo;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->authRepo->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }

        Auth::login($user);
        return true;
    }

    public function logout(): void
    {
        Auth::logout();
    }
}