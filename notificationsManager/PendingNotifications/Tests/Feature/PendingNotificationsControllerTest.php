<?php

namespace NotificationsManager\PendingNotifications\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use NotificationsManager\PendingNotifications\Database\Entities\PendingNotification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PendingNotificationsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testNotificationsAddSuccesfull(): void
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
    public function testWithBadFormatRequest(): void
    {
        $expectedResponse = '{"message":"Invalid request format."}';
        $notificationData = [
            'id' => null,
            'customerId' => '12345',
            'createdDate' => '2024-07-03T10:00:00Z'
        ];

        $response = $this->post(route('addNotification'), $notificationData);

        $response->assertStatus(400);
        $response->assertContent($expectedResponse);
    }

    #[Test]
    public function testWithEntityManagerError(): void
    {
        $expectedResponse = '{"message":"Failed to add pending notification."}';
        $notificationData = [
            'id' => null,
            'customerId' => '12345',
            'operatorId' => 678,
            'orderNumber' => 'ORD123456',
            'messageType' => 'INFO',
            'createdDate' => '2024-07-03T10:00:00Z'
        ];
        $this->mock(EntityManagerInterface::class, function ($mock) {
            $mock->shouldReceive('persist')->andThrow(new Exception('Database error'));
            $mock->shouldReceive('flush')->andThrow(new Exception('Database error'));
        });

        $response = $this->post(route('addNotification'), $notificationData);

        $response->assertStatus(500);
        $response->assertContent($expectedResponse);
    }

    #[Test]
    public function testWithEntityError(): void
    {
        $expectedResponse = '{"message":"Failed to add pending notification."}';
        $notificationData = [
            'id' => null,
            'customerId' => '12345',
            'operatorId' => 678,
            'orderNumber' => 'ORD123456',
            'messageType' => 'INFO',
            'createdDate' => '2024-07-03T10:00:00Z'
        ];
        $this->mock(PendingNotification::class, function ($mock) {
            $mock->shouldReceive('setPendingNotification')->andThrow(new Exception('Entity error'));
        });

        $response = $this->post(route('addNotification'), $notificationData);

        $response->assertStatus(500);
        $response->assertContent($expectedResponse);
    }
}
