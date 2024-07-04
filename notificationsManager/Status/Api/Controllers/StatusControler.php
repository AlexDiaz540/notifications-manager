<?php

namespace NotificationsManager\Status\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatusControler extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }
}
