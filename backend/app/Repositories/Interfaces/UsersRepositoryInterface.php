<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UsersRepositoryInterface
{
    public function findAll(): Collection;
    public function find(int $id): User;
    public function create(User $task): User;
    public function update(int $id, User $task): User;
    public function delete(int $id): void;
}
