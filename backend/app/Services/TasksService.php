<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Task;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use App\Services\Interfaces\TasksServiceInterface;
use App\Services\Interfaces\UsersServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TasksService implements TasksServiceInterface
{
    public function __construct(
        private TasksRepositoryInterface $tasksRepository,
        private UsersServiceInterface $userService
    ) {
    }

    public function findAll($title = '', $desc = ''): LengthAwarePaginator
    {
        return $this->tasksRepository->findAll($title, $desc);
    }

    public function find(int $id): Task
    {
        //try and catch necessary to prevent Eloquent from sending its own exception to whoever is consuming the API
        try {
            return $this->tasksRepository->find($id);
        } catch (\Exception $e) {
            throw new NotFoundException("Task not found with ID: $id");
        }
    }

    public function findDone(int $userID, $title = '', $desc = ''): LengthAwarePaginator
    {
        return $this->tasksRepository->findDone($userID, $title, $desc);
    }

    public function findNotDone(int $userID, $title = '', $desc = ''): LengthAwarePaginator
    {
        return $this->tasksRepository->findNotDone($userID, $title, $desc);
    }

    public function findByUser(int $id, $title = '', $desc = ''): LengthAwarePaginator
    {
        $this->userService->find($id);
        return $this->tasksRepository->findByUser($id, $title, $desc);
    }

    public function create(Task $taskDTO): Task
    {
        $task = new Task();
        $task->fill($taskDTO->toArray());

        return $this->tasksRepository->create($task);
    }

    public function update(int $id, Task $taskDTO): Task
    {
        $task = $this->find($id);
        $task->fill($taskDTO->toArray());

        return $this->tasksRepository->update($id, $task);
    }

    public function delete(int $id): void
    {
        $this->find($id);
        $this->tasksRepository->delete($id);
    }
}
