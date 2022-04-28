<?php

namespace App\Interfaces;

interface AvatarRepositoryInterface 
{
    public function getAvatarById($avatarId);
    public function createAvatar($avatar, $userData);
    public function deleteAvatar($avatarId);
}
