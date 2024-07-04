<?php

namespace NotificationsManager\Status\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StatusControllerTest extends TestCase
{
    #[Test]
    public function checkStatusOk()
    {
        $expectedResponse = '{"status":"ok"}';

        $response = $this->get(route("status"));

        $response->assertStatus(200);
        $response->assertContent($expectedResponse);
    }
}
