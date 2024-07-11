<?php

namespace App\Services\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TasksServiceInterface
{
    public function findAll($title = '', $desc = ''): LengthAwarePaginator;
    public function findDone(int $userID, $title = '', $desc = ''): LengthAwarePaginator;
    public function findNotDone(int $userID, $title = '', $desc = ''): LengthAwarePaginator;
    public function findByUser(int $id, $title = '', $desc = ''): LengthAwarePaginator;
    public function find(int $id): Task;
    public function create(Task $task): Task;
    public function update(int $id, Task $task): Task;
    public function delete(int $id): void;
}