<?php

namespace NotificationsManager\Operarios\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActualizarOperariosTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testActualizarOperarios(): void
    {
        $userData = [
            'customer_id' => 26,
            'id' => 2,
            'name' => '654654',
            'surname_1' => '',
            'surname_2' => '',
            'phone' => 0,
            'email' => '',
            'order_notifications_enabled' => false,
            'order_notifications_email' => '',
            'order_notifications_by_email' => false,
            'order_notifications_by_sms' => false,
            'order_notifications_by_push' => false,
            'deleted' => true,
        ];
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.']);

        $this->artisan('update:operarios')
            ->expectsOutput($expectedResponse);
        $this->assertDatabaseHas('operators', $userData);
    }
}
