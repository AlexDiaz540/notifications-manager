<?php

namespace NotificationsManager\Notifications\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NotificationsControllerTest extends TestCase
{
    #[Test]
    public function notificationsAddTest(): void
    {
        $expectedResponse = '{"message":"Pending notification added successfully."}';

        $response = $this->post(route('addNotification'), [
            'id' => null,
            'customerId' => '12345',
            'operatorId' => 678,
            'orderNumber' => 'ORD123456',
            'messageType' => 'INFO',
            'createdDate' => '2024-07-03T10:00:00Z'
        ]);

        $response->assertStatus(200);
        $response->assertContent($expectedResponse);
    }
    #[Test]
    public function notificationsAddTestWithBadFormatRequest(): void
    {
        $expectedResponse = '{"message":"Invalid request format."}';

        $response = $this->post(route('addNotification'), [
            'id' => null,
            'customerId' => '12345',
            'createdDate' => '2024-07-03T10:00:00Z'
        ]);

        $response->assertStatus(400);
        $response->assertContent($expectedResponse);
    }
}
