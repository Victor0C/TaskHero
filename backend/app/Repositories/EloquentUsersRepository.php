<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentUsersRepository implements UsersRepositoryInterface
{
    public function findAll(): Collection
    {
        $user = User::all();
        return $user;
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function create(User $user): User
    {
        $user->save();
        return $user;
    }

    public function update(int $id, User $user): User
    {
        $existingUser = User::findOrFail($id);
        
        $existingUser->fill($user->toArray());

        $existingUser->save();
        
        return $existingUser;
    }

    public function delete(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
