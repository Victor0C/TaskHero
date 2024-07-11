<?php

namespace App\Providers;

use App\Services\Interfaces\TasksServiceInterface;
use App\Services\TasksService;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TasksServiceInterface::class => TasksService::class
    ];
}
