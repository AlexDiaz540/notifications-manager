<?php

namespace NotificationsManager\Operators\Tests\Unit;

use NotificationsManager\Operators\IlluminateOperatorsRequestRepository;
use NotificationsManager\Operators\Repositories\OperatorsRequestRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Support\Facades\Http as HttpClient;

class OperatorRequestRepositoryTest extends TestCase
{
    private HttpClient $httpClient;
    private OperatorsRequestRepository $operatorsRequestRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->operatorsRequestRepository = new IlluminateOperatorsRequestRepository();
        $this->httpClient = new HttpClient();
    }

    #[Test]
    public function getSingleOperator(): void
    {
        $expectedResponse = [
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

        $operators = $this->operatorsRequestRepository->getOperators();

        $this->assertEquals($expectedResponse, $operators);
    }

    #[Test]
    public function getMultipleOperators(): void
    {
        $expectedResponse = [
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
            'https://api.extexnal.com/operators/*' => $this->httpClient::response($expectedResponse, 200)
        ]);

        $operators = $this->operatorsRequestRepository->getOperators();

        $this->assertEquals($expectedResponse, $operators);
    }

    #[Test]
    public function getOperatorsWithNoOperatorsReceived(): void
    {
        $expectedResponse = [];
        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response([], 200)
        ]);

        $operators = $this->operatorsRequestRepository->getOperators();

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

        $this->operatorsRequestRepository->getOperators();
    }
}
