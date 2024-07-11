<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\Interfaces\UsersServiceInterface;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function __construct(private UsersServiceInterface $usersService)
    {
        
    }

    public function index(): JsonResponse
    {
        $users = $this->usersService->findAll();
        
        return response()->json($users);
    }

    public function store(UserRequest $userRequest): JsonResponse
    {
        $userDTO = new User();
        $userDTO->fill($userRequest->all());

        $createdUser = $this->usersService->create($userDTO);

        return response()->json($createdUser, 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->usersService->find((int)$id);
        return response()->json($user);
    }

    public function update(UserRequest $userRequest, string $id): JsonResponse
    {
        $userDTO = new User();
        $userDTO->fill($userRequest->all());

        $updatedUser= $this->usersService->update((int)$id, $userDTO);

        return response()->json($updatedUser);
    }

    public function destroy(string $id)
    {
        $this->usersService->delete((int)$id);

        return response()->json(status: 204);
    }
}
