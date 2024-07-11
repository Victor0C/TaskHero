<?php

namespace App\Providers;

use App\Services\Interfaces\UsersServiceInterface;
use App\Services\UsersService;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UsersServiceInterface::class => UsersService::class
    ];
}

