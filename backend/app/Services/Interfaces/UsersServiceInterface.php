<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UsersServiceInterface
{
    public function findAll(): Collection;
    public function find(int $id): User;
    public function create(User $task): User;
    public function update(int $id, User $task): User;
    public function delete(int $id): void;
}