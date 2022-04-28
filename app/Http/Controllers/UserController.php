<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\AvatarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository, AvatarRepositoryInterface $avatarRepository){
        $this->userRepository = $userRepository;
        $this->avatarRepository = $avatarRepository;
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
        ]);

        if($request->has('avatar')){
            $avatarId = $this->avatarRepository->createAvatar($request->file('avatar'), $userData);
            $userData['avatar_id'] = $avatarId->id;
        }

        return response()->json([
            'data' => $this->userRepository->createUser($userData)
        ]);
    }

    public function update($userId, Request $request){
        $newUserData = $request->only([
            'nome',
            'data_nascimento',
        ]);


        if($request->has('avatar')){
            $currentUser = $this->userRepository->getUserById($userId);

            if($request->input('avatar') == 'remove'){
                $newUserData['avatar_id'] = null;
                $updatedUser = $this->userRepository->updateUser($userId, $newUserData);
                $this->avatarRepository->deleteAvatar($currentUser->avatar_id);
            }else{
                $avatarId = $this->avatarRepository->createAvatar($request->file('avatar'), $newUserData);
                $newUserData['avatar_id'] = $avatarId->id;
                $updatedUser = $this->userRepository->updateUser($userId, $newUserData);
                $this->avatarRepository->deleteAvatar($currentUser->avatar_id);
            }

            return response()->json([
                'data' => $updatedUser,
            ]);
        }

        // return response()->json([
        //     'data' => $this->userRepository->updateUser($userId, $newUserData)
        // ]);
    }

    public function delete($userId): JsonResponse {
        $user = $this->userRepository->getUserById($userId);

        $this->userRepository->deleteUser($userId);

        if($user->avatar_id){
            $this->avatarRepository->deleteAvatar($user->avatar_id);
        }

        return response()->json(['data' => 'usuário removido']);
    }
}