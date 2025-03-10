<?php

namespace App\Repositories;

use App\Models\User;

class AdminRepository{

    public function findByName(string $name): ?User{
        return User::where("name", $name)->first();
    }

    public function getAllUsers(){
        return User::all();
    }

    public function deleteUser(string $name){
        $user = $this->findByName($name);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    public function createUser(array $data): User{
        return User::create($data);
    }

    public function updateUser(string $name, array $data): ?User{

        $user = $this->findByName($name);

        if (!$user) {
            return null;
        }

        $user->update($data);

        return $user;
    }

}