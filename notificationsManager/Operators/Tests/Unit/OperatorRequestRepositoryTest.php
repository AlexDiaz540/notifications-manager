<?php

namespace NotificationsManager\Operators\Tests\Unit;

use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\OperatorsApiDataSource;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Support\Facades\Http as HttpClient;

class OperatorRequestRepositoryTest extends TestCase
{
    private HttpClient $httpClient;
    private OperatorsApiDataSource $operatorsApiDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->operatorsApiDataSource = new OperatorsApiDataSource();
        $this->httpClient = new HttpClient();
    }

    #[Test]
    public function getSingleOperator(): void
    {
        $expectedResponse = [];
        $operatorData = [
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
        $expectedResponse[] = new Operator($operatorData[0]);

        $operators = $this->operatorsApiDataSource->getOperators();

        $this->assertEquals($expectedResponse, $operators);
    }

    #[Test]
    public function getMultipleOperators(): void
    {
        $expectedResponse = [];
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
            ],
            [
                'sequenceNumber' => 1510105,
                'journalEntryType' => 'UP',
                'customerId' => 24,
                'id' => 4,
                'name' => '654314',
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
        $expectedResponse[] = new Operator($operatorsData[0]);
        $expectedResponse[] = new Operator($operatorsData[1]);

        $operators = $this->operatorsApiDataSource->getOperators();

        $this->assertEquals($expectedResponse, $operators);
    }

    #[Test]
    public function getOperatorsWithNoOperatorsReceived(): void
    {
        $expectedResponse = [];
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response([], 200)
        ]);

        $operators = $this->operatorsApiDataSource->getOperators();

        $this->assertEquals($expectedResponse, $operators);
    }

    #[Test]
    public function apiRequestFails(): void
    {
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response([], 500)
        ]);
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(500);

        $this->operatorsApiDataSource->getOperators();
    }
}
