<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentTasksRepository;
use App\Repositories\Interfaces\TasksRepositoryInterface;

class TaskRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        TasksRepositoryInterface::class => EloquentTasksRepository::class
    ];
}
