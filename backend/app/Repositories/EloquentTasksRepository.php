<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TasksRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentTasksRepository implements TasksRepositoryInterface
{
    private int $paginate;

    public function __construct()
    {
        $this->paginate = 10;
    }

    public function findAll($title = '', $desc = ''): LengthAwarePaginator
    {
        $query = Task::query();

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($desc) {
            $query->where('desc', 'like', '%' . $desc . '%');
        }

        return $query->paginate($this->paginate);
    }

    public function find(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function findByUser(int $id, $title = '', $desc = ''): LengthAwarePaginator
    {
        $query = Task::where('user_id', $id);

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($desc) {
            $query->where('desc', 'like', '%' . $desc . '%');
        }

        return $query->paginate($this->paginate);
    }

    public function findDone(int $userID, $title = '', $desc = ''): LengthAwarePaginator
    {
        $query = Task::where('user_id', $userID)->where('done', 1);

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($desc) {
            $query->where('desc', 'like', '%' . $desc . '%');
        }

        return $query->paginate($this->paginate);
    }

    public function findNotDone(int $userID, $title = '', $desc = ''): LengthAwarePaginator
    {
        $query = Task::where('user_id', $userID)->where('done', 0);
        
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($desc) {
            $query->where('desc', 'like', '%' . $desc . '%');
        }
       

        return $query->paginate($this->paginate);
    }

    public function create(Task $task): Task
    {
        $task->save();
        return $task;
    }

    public function update(int $id, Task $task): Task
    {
        $existingTask = Task::findOrFail($id);
        
        $existingTask->fill($task->toArray());

        $existingTask->save();
        
        return $existingTask;
    }

    public function delete(int $id): void
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}