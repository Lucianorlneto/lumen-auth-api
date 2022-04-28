<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers() {
        return User::with('avatar')->orderBy('id')->get();
    }

    public function getUserById($userId){
        return User::with('avatar')->findOrFail($userId);
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
