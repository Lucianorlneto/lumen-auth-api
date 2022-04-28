<?php

namespace App\Repositories;

use App\Interfaces\AvatarRepositoryInterface;
use App\Models\Avatar;

use Illuminate\Support\Facades\Storage;

class AvatarRepository implements AvatarRepositoryInterface 
{
    public function getAvatarById($avatarId){
        return Avatar::findOrFail($avatarId);
    }

    public function createAvatar($avatar, $userData){
        $avatarName = $avatar->getClientOriginalName();
        $time = time();
        $avatarHash = hash('md5', "{$userData['nome']} {$userData['data_nascimento']} {$time} {$avatarName}").".png";
        Storage::putFileAs('public/images.png', $avatar, $avatarHash);

        $avatarData = [
            "original_nome" => $avatarName,
            "nome" => $avatarHash,
            "path" => Storage::url("public/images.png/{$avatarHash}")
        ];

        return Avatar::create($avatarData);
    }

    public function deleteAvatar($avatarId){
        $avatar = Avatar::findOrFail($avatarId);
        Storage::delete("public/images.png/{$avatar->nome}");

        return Avatar::destroy($avatarId);
    }
}
