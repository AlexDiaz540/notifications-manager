<?php

namespace NotificationsManager\Operarios;

use Carbon\Laravel\ServiceProvider;
use NotificationsManager\Operarios\Commands\ActualizarOperarios;

class OperariosServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Api/Routes/OperariosRoute.php');
    }

    public function boot(): void
    {
        $this->commands(ActualizarOperarios::class);
    }
}
