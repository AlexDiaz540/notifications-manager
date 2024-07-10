<?php

namespace NotificationsManager\Operators;

use Carbon\Laravel\ServiceProvider;
use NotificationsManager\Operators\Commands\UpdateOperators;

class OperatorsServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/2024_07_05_072043_create_operators_table.php');
    }

    public function boot(): void
    {
        $this->commands(UpdateOperators::class);
    }
}
