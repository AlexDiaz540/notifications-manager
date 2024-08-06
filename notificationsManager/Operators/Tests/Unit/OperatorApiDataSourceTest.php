<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Exception;
use Mockery\Container;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\OperatorsApiDataSource;
use NotificationsManager\Operators\Repositories\ApiRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OperatorApiDataSourceTest extends TestCase
{
    private OperatorsApiDataSource $operatorsApiDataSource;
    private ApiRepositoryInterface $apiRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->apiRepository = $mockeryContainer->mock(ApiRepositoryInterface::class);
        $this->operatorsApiDataSource = new OperatorsApiDataSource($this->apiRepository);
    }

    #[Test]
    public function getsOperator(): void
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
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($operatorData));
        $expectedResponse[] = new Operator($operatorData[0]);

        $operators = $this->operatorsApiDataSource->getOperators();

        $this->assertEquals($expectedResponse, $operators);
    }

    #[Test]
    public function getsOperatorButReceivesErrorMessage(): void
    {
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andThrow(new Exception());
        $this->expectException(Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Failed to retrieve operators.');

        $this->operatorsApiDataSource->getOperators();
    }
}
