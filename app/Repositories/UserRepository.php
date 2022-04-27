<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers() {
        return User::all();
    }

    public function getUserById($userId){
        return User::findOrFail($userId);
    }

    public function createUser($user) {
        return User::create($user);
    }

    public function updateUser($userId, $newUserData) {
        User::whereId($userId)->update($newUserData);;
    }

    public function deleteUser($userId) {
        return User::destroy($userId);
    }
}
