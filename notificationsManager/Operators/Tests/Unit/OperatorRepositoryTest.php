<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Container;
use NotificationsManager\Operators\DoctrineOperatorRepository;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OperatorRepositoryTest extends TestCase
{
    private Client $client;
    private EntityManagerInterface $entityManager;
    private OperatorRepositoryInterface $operatorRepository;
    private $operatorData = '[
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

    public function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->client = $mockeryContainer->mock(Client::class);
        $this->entityManager = $mockeryContainer->mock(EntityManagerInterface::class);
        $this->operatorRepository = new DoctrineOperatorRepository($this->client, $this->entityManager);
    }

    #[Test]
    public function updatesOperator(): void
    {
        $response = new Response(200, [], $this->operatorData);
        $this->client
            ->expects('get')
            ->andReturn($response);
        $this->entityManager
            ->expects('persist')
            ->once();
        $this->entityManager
            ->expects('flush')
            ->once();

        $this->operatorRepository->update();
    }

    #[Test]
    public function updatesOperatorButFailsRetrievingOperators(): void
    {
        $response = new Response(200, [], $this->operatorData);
        $this->client
            ->expects('get')
            ->andReturn($response)
            ->andThrow(new Exception());

        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Failed to retrieve operators.');

        $this->operatorRepository->update();
    }

    #[Test]
    public function updatesOperatorButFailsUpdatingOperators(): void
    {
        $response = new Response(200, [], $this->operatorData);
        $this->client
            ->expects('get')
            ->andReturn($response);
        $this->entityManager
            ->expects('persist')
            ->andThrow(new Exception());

        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Failed to update operators.');

        $this->operatorRepository->update();
    }
}
