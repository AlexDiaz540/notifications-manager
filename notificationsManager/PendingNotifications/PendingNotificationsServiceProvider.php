<?php

namespace NotificationsManager\PendingNotifications;

use Carbon\Laravel\ServiceProvider;

class PendingNotificationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Api/Routes/PendingNotificationsRoutes.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/2024_07_11_111825_create_pending_notifications.php');
    }

    public function boot(): void
    {
    }
}
