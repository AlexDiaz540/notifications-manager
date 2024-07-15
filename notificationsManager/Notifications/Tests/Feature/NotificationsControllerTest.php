<?php

namespace NotificationsManager\Notifications\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NotificationsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function notificationsAddTest(): void
    {
        $expectedResponse = '{"message":"Pending notification added successfully."}';

        $notificationData = [
            'id' => null,
            'customerId' => '12345',
            'operatorId' => 678,
            'orderNumber' => 'ORD123456',
            'messageType' => 'INFO',
            'createdDate' => '2024-07-03T10:00:00Z'
        ];
        $databaseData = [
            'id' => 1,
            'customer_id' => '12345',
            'operator_id' => 678,
            'order_number' => 'ORD123456',
            'message_type' => 'INFO',
            'created_date' => '2024-07-03 10:00:00'
        ];
        $response = $this->post(route('addNotification'), $notificationData);

        $response->assertStatus(200);
        $response->assertContent($expectedResponse);
        $this->assertDatabaseHas('pending_notifications', $databaseData);
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
