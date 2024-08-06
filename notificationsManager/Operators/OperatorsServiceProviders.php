<?php

namespace NotificationsManager\Operators;

use Carbon\Laravel\ServiceProvider;
use NotificationsManager\Operators\Commands\UpdateOperatorsCommand;
use NotificationsManager\Operators\Repositories\ApiRepositoryInterface;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;

class OperatorsServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/2024_07_05_072043_create_operators_table.php');
        $this->app->bind(OperatorRepositoryInterface::class, DoctrineOperatorRepository::class);
        $this->app->bind(ApiRepositoryInterface::class, FakeApiRepository::class);
    }

    public function boot(): void
    {
        $this->commands(UpdateOperatorsCommand::class);
    }
}
