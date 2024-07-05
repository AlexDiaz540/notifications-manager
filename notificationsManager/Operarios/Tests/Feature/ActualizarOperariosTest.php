<?php

namespace NotificationsManager\Operarios\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ActualizarOperariosTest extends TestCase
{
    #[Test]
    public function testActualizarOperarios(): void
    {
        $expectedResponse = '[{"sequenceNumber":1510105,"journalEntryType":"UP","customerId":26,"id":2,"name":"654654",
            "surname1":"","surname2":"","phone":0,"email":"","orderNotifications":false,"orderNotificationEmail":"",
            "orderNotificationByEmail":false,"orderNotificationBySms":false,"orderNotificationByPush":false,
            "deleted":true,"object":"SALQ9U","objectSchema":"IQSFCOMUN"}]';

        $expectedResponse = str_replace(["\r", "\n", "\t", " "], '', $expectedResponse);
        $this->artisan('update:operarios')
            ->expectsOutput($expectedResponse);
    }
}
