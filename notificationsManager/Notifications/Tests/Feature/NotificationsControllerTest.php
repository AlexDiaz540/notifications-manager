<?php

namespace NotificationsManager\Notifications\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NotificationsControllerTest extends TestCase
{
    #[Test]
    public function notificationsAddTest(): void
    {
        $expectedResponse = '{"":"ok"}';

        $response = $this->post(route("addNotification"));

        $response->assertStatus(200);
        $response->assertContent($expectedResponse);
    }
}
