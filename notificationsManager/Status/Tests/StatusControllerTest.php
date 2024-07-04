<?php

namespace NotificationsManager\Status\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group("Integration")]
class StatusControllerTest extends TestCase
{
    #[Test]
    public function checkStatusOk(): void
    {
        $expectedResponse = '{"status":"ok"}';

        $response = $this->get(route("status"));

        $response->assertStatus(200);
        $response->assertContent($expectedResponse);
    }
}
