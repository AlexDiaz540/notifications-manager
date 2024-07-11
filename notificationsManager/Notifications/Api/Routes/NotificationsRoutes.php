<?php

namespace Notifications\Api\Routes;

use Illuminate\Support\Facades\Route;
use NotificationsManager\Notifications\Api\Controllers\NotificationsController;

Route::post('/notifications/add', NotificationsController::class)->name('addNotification');
