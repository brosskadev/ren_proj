<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use App\Services\Interfaces\AdminServiceInterface;

class AdminService implements AdminServiceInterface{

    protected $adminRepo;

    public function __construct(AdminRepository $adminRepo){
        $this->adminRepo = $adminRepo;
    }


    public function getUserByName(string $name){
        $user = $this->adminRepo->findByName($name);
        return $user;
    }

    public function getAllUsers(){
        $users = $this->adminRepo->getAllUsers();

        return $users;
    }

    public function deleteUser(string $name){
        return $this->adminRepo->deleteUser($name);
    }

    public function createUser(array $data){
        return $this->adminRepo->createUser( $data );
    }

    public function updateUser(string $name, array $data){
        return $this->adminRepo->updateUser( $name, $data );
    }
}