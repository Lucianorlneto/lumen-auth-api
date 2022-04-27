<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private function handleFileUpload(Request $request, $userData){
        $avatarName = $request->file('avatar')->getClientOriginalName();

        $avatarHash = hash('md5', "{$userData['nome']} ${userData['data_nascimento']} ${avatarName}").".png";

        Storage::putFileAs('public/images.png', $request->file('avatar'), $avatarHash);

        return $avatarHash;
    }

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    public function index(): JsonResponse {
        return response()->json([
            'data' => $this->userRepository->getAllUsers()
        ]);
    }

    public function show($userId): JsonResponse {
        return response()->json([
            'data' => $this->userRepository->getUserById($userId)
        ]);
    }

    public function create(Request $request): JsonResponse {
        $userData = $request->only([
            'nome',
            'data_nascimento',
            'avatar'
        ]);

        $userData['avatar'] = Storage::url("public/images.png/{$this->handleFileUpload($request, $userData)}");

        return response()->json([
            'data' => $this->userRepository->createUser($userData)
        ]);
    }

    public function update($userId, Request $request): JsonResponse {
        $newUserData = $request->only([
            'nome',
            'data_nascimento',
        ]);

        // $currentUser = $this->userRepository->getUserById($userId);
        // $currentAvatarAux = explode('/', $currentUser->avatar);
        // $currentAvatar = $currentAvatarAux[count($currentAvatarAux)-1];
        
        // if(Storage::exists("public/images.png/{$currentAvatar}")){
        //     $newAvatar = $this->handleFileUpload($request, $newUserData);
        //     $currentAvatarAux = explode('/', $currentUser->avatar);
        //     $currentAvatar = $currentAvatarAux[count($currentAvatarAux)-1];
        // }

        return response()->json([
            'data' => $this->userRepository->updateUser($userId, $newUserData)
        ]);
    }

    public function delete($userId): JsonResponse {
        $currentUser = $this->userRepository->getUserById($userId);
        $currentAvatarAux = explode('/', $currentUser->avatar);
        $currentAvatar = $currentAvatarAux[count($currentAvatarAux)-1];
        
        if(Storage::exists("public/images.png/{$currentAvatar}")){
            Storage::delete("public/images.png/{$currentAvatar}");
        }

        $this->userRepository->deleteUser($userId);

        return response()->json(['data' => 'usuário removido']);
    }
}