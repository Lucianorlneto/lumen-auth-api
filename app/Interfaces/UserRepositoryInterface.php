<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById($userId);
    public function createUser($user);
    public function updateUser($userId, $newUserData);
    public function deleteUser($userId);
}
