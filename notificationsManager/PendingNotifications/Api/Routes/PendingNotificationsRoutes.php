<?php

namespace Notifications\Api\Routes;

use Illuminate\Support\Facades\Route;
use NotificationsManager\PendingNotifications\Api\Controllers\PendingNotificationsController;

Route::post('/notifications/add', PendingNotificationsController::class)->name('addNotification');
