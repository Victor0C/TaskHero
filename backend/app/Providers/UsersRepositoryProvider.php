<?php

namespace App\Providers;

use App\Repositories\EloquentUsersRepository;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class UsersRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        UsersRepositoryInterface::class => EloquentUsersRepository::class
    ];
}
