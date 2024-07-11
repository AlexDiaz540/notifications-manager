<?php

namespace NotificationsManager\Status;

use Carbon\Laravel\ServiceProvider;

class StatusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Api/Routes/StatusRoutes.php');
    }

    public function boot(): void
    {
    }
}
