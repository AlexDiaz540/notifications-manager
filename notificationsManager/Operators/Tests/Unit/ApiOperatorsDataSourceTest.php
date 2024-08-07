<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Container;
use NotificationsManager\ApiOperatorsDataSource;
use NotificationsManager\Operators\Database\Entities\Operator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApiOperatorsDataSourceTest extends TestCase
{
    private Client $client;
    private ApiOperatorsDataSource $apiDataSource;
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

    public function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->client = $mockeryContainer->mock(Client::class);

        $this->apiDataSource = new ApiOperatorsDataSource($this->client);
    }

    #[Test]
    public function getsOperators(): void
    {
        $expectedResponse = [];
        $apiResponse = new Response(200, [], $this->operatorDataApi);
        $this->client
            ->expects('get')
            ->andReturn($apiResponse);
        $expectedResponse[] = new Operator($this->operatorData);

        $response = $this->apiDataSource->getOperators();

        $this->assertEquals($expectedResponse, $response);
    }

    #[Test]
    public function failsToRetrieveOperators(): void
    {
        $this->client
            ->expects('get')
            ->andThrow(new Exception());

        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Failed to retrieve operators.');

        $this->apiDataSource->getOperators();
    }
}
