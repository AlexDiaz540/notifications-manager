<?php

namespace NotificationsManager\Operators\Tests\Feature;

use Doctrine\ORM\EntityManager;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Container;
use NotificationsManager\ApiOperatorsDataSource;
use NotificationsManager\DatabaseOperatorsDataSource;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateOperatorsTest extends TestCase
{
    use RefreshDatabase;

    private Client $client;
    private EntityManager $entityManager;
    private $operatorDataApi = '[
        {
            "sequenceNumber": 1510105,
            "journalEntryType": "UP",
            "customerId": 26,
            "id": 2,
            "name": "654654",
            "surname1": "",
            "surname2": "",
            "phone": 0,
            "email": "",
            "orderNotifications": false,
            "orderNotificationEmail": "",
            "orderNotificationByEmail": false,
            "orderNotificationBySms": false,
            "orderNotificationByPush": false,
            "deleted": true,
            "object": "SALQ9U",
            "objectSchema": "IQSFCOMUN"
        }
    ]';
    private $operatorData = [
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
    ];
    private $operatorInDataBase = [
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

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->client = $mockeryContainer->mock(Client::class);
        $this->entityManager = $this->app->make(EntityManager::class);

        $this->app
            ->when(ApiOperatorsDataSource::class)
            ->needs(Client::class)
            ->give(fn () => $this->client);
        $this->app
            ->when(DatabaseOperatorsDataSource::class)
            ->needs(EntityManager::class)
            ->give(fn () => $this->entityManager);
    }

    #[Test]
    public function updatesAnOperator(): void
    {
        $apiResponse = new Response(200, [], $this->operatorDataApi);
        $this->client
            ->expects('get')
            ->andReturn($apiResponse);
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);

        $this->assertDatabaseHas('operators', $this->operatorInDataBase);
    }

    #[Test]
    public function updatesOperatorsButFailsToRetrieveOperators(): void
    {
        $this->client
            ->expects('get')
            ->once()
            ->andThrow(new Exception());
        $expectedResponse = json_encode(['message' => "Failed to retrieve operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }
}
