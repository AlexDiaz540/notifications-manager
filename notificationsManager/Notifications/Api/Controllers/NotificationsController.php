<?php

namespace NotificationsManager\Notifications\Api\Controllers;

class NotificationsController
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }
}
