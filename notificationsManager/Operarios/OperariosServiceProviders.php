<?php

namespace NotificationsManager\Operarios;

use Carbon\Laravel\ServiceProvider;
use NotificationsManager\Operarios\Commands\ActualizarOperarios;

class OperariosServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Api/Routes/OperariosRoute.php');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations/2024_07_05_072043_create_operators_table.php');
    }

    public function boot(): void
    {
        $this->commands(ActualizarOperarios::class);
    }
}
