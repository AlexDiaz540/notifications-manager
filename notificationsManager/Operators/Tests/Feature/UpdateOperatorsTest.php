<?php

namespace NotificationsManager\Operators\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as HttpClient;
use Mockery\Container;
use NotificationsManager\Operators\Commands\UpdateOperators;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateOperatorsTest extends TestCase
{
    use RefreshDatabase;

    private Response $response;
    private HttpClient $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->httpClient = new HttpClient();
        $this->response = $mockeryContainer->mock(Response::class);
        $this->app
            ->when(UpdateOperators::class)
            ->needs(Response::class)
            ->give(fn () => $this->response);
    }
    #[Test]
    public function updateOneOperator(): void
    {
        $operatorData = [
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
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
        $this->assertDatabaseHas('operators', $operatorData);
    }

    #[Test]
    public function updateMultipleOperators(): void
    {
        $operatorsData = [
            [
                'sequenceNumber' => 1510105,
                'journalEntryType' => 'UP',
                'customerId' => 22,
                'id' => 4,
                'name' => '674654',
                'surname1' => '',
                'surname2' => '',
                'phone' => 0,
                'email' => '',
                'orderNotifications' => false,
                'orderNotificationEmail' => '',
                'orderNotificationByEmail' => false,
                'orderNotificationBySms' => false,
                'orderNotificationByPush' => false,
                'deleted' => true,
                'object' => 'SALQ9U',
                'objectSchema' => 'IQSFCOMUN'
            ],
            [
                'sequenceNumber' => 1510133,
                'journalEntryType' => 'UP',
                'customerId' => 23,
                'id' => 3,
                'name' => '654234',
                'surname1' => '',
                'surname2' => '',
                'phone' => 0,
                'email' => '',
                'orderNotifications' => false,
                'orderNotificationEmail' => '',
                'orderNotificationByEmail' => false,
                'orderNotificationBySms' => false,
                'orderNotificationByPush' => false,
                'deleted' => true,
                'object' => 'SALQ9U',
                'objectSchema' => 'IQSFCOMUN'
            ]
        ];

        $operatorsInDatabase = [
            [
                'customer_id' => 22,
                'id' => 4,
                'name' => '674654',
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
            ],
            [
                'customer_id' => 23,
                'id' => 3,
                'name' => '654234',
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
            ]
        ];

        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response($operatorsData, 200)
        ]);
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
        foreach ($operatorsInDatabase as $operator) {
            $this->assertDatabaseHas('operators', $operator);
        }
    }

    #[Test]
    public function updateOperatorsWithNoOperatorsReceived(): void
    {
        $operatorsData = [];
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response($operatorsData, 200)
        ]);
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
    }

    #[Test]
    public function updateOpertatorsWhenApiRequestFails(): void
    {
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response([], 500)
        ]);
        $expectedResponse = json_encode(['message' => "Failed to retrieve operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }

    #[Test]
    public function updateOperatorsWhenInsertInDataBaseFails(): void
    {
        $operatorsData = [
            [
                'sequenceNumber' => 1510105,
                'journalEntryType' => 'UP',
                'customerId' => 26,
                'id' => 2,
                'name' => '654654',
                'surname1' => '',
                'surname2' => '',
                'phone' => 0,
                'email' => '',
                'orderNotifications' => false,
                'orderNotificationEmail' => '',
                'orderNotificationByEmail' => false,
                'orderNotificationBySms' => false,
                'orderNotificationByPush' => false,
                'deleted' => true,
                'object' => 'SALQ9U',
                'objectSchema' => 'IQSFCOMUN'
            ]
        ];
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response($operatorsData, 200)
        ]);
        $this->mock(EntityManagerInterface::class, function ($mock) {
            $mock->shouldReceive('persist')->andThrow(new Exception('Database error'));
            $mock->shouldReceive('flush')->andThrow(new Exception('Database error'));
        });
        $expectedResponse = json_encode(['message' => "Failed to update operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }

    #[Test]
    public function updateOperatorsWhenCreateEntityOperatorFails(): void
    {
        $operatorsData = [
            [
                'email' => '',
                'orderNotifications' => false,
                'orderNotificationEmail' => '',
                'orderNotificationByEmail' => false,
                'orderNotificationBySms' => false,
                'orderNotificationByPush' => false,
                'deleted' => true,
                'object' => 'SALQ9U',
                'objectSchema' => 'IQSFCOMUN'
            ]
        ];
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response($operatorsData, 200)
        ]);
        $expectedResponse = json_encode(['message' => "Failed to update operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }
}
