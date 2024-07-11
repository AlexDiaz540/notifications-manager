<?php

namespace NotificationsManager\Notifications;

use Carbon\Laravel\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Api/Routes/NotificationsRoutes.php');
    }

    public function boot(): void
    {
    }
}
