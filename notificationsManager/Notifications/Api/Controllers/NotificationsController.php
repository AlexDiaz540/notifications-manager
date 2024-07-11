<?php

namespace NotificationsManager\Notifications\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use NotificationsManager\Notifications\Api\Requests\NotificationAddRequest;

class NotificationsController
{
    public function __invoke(NotificationAddRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Pending notification added successfully.',
        ]);
    }
}
