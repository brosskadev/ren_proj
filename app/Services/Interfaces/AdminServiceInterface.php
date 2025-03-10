<?php

namespace App\Services\Interfaces;

interface AdminServiceInterface{
    public function getUserByName(string $name);

    public function getAllUsers();

    public function deleteUser(string $name);

    public function createUser(array $data);
    
    public function updateUser(string $name, array $data);
}