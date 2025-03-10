<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface{
    public function login(string $email, string $password);

    public function logout();
}