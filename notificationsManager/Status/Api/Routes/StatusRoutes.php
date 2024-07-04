<?php

namespace NotificationsManager\Status\Api\Routes;

use Illuminate\Support\Facades\Route;
use NotificationsManager\Status\Api\Controllers\StatusControler;

Route::get('/status', StatusControler::class)->name('status');
