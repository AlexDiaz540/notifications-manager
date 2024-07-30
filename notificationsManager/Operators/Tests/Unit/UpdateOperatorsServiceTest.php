<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Exception;
use Mockery\Container;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\OperatorsApiDataSource;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use NotificationsManager\Operators\UpdateOperatorsService;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class UpdateOperatorsServiceTest extends TestCase
{
    private OperatorsApiDataSource $operatorsApiDataSource;
    private OperatorRepositoryInterface $operatorRepository;
    private UpdateOperatorsService $updateOperatorsService;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->operatorsApiDataSource = $mockeryContainer->mock(OperatorsApiDataSource::class);
        $this->operatorRepository = $mockeryContainer->mock(OperatorRepositoryInterface::class);
        $this->updateOperatorsService  = new UpdateOperatorsService($this->operatorsApiDataSource, $this->operatorRepository);
    }

    #[Test]
    public function updateOperators(): void
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
        $this->operatorsApiDataSource
            ->expects('getOperators')
            ->once();
        $this->operatorRepository
            ->expects('save')
            ->once();

        $this->updateOperatorsService->update();

        $this->assertDatabaseHas('operators', $operatorData);
    }

    #[Test]
    public function getOperatorsButApiFails(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to retrieve operators.');
        $this->expectExceptionCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);

        $this->operatorsApiDataSource
            ->expects('getOperators')
            ->andThrow(new Exception('Failed to retrieve operators.', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR));

        $this->updateOperatorsService->update();
    }

    #[Test]
    public function getOperatorsButInsertFails(): void
    {
        $operators = [];
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
        $operators[] = new Operator($operatorData[0]);
        $this->operatorsApiDataSource
            ->expects('getOperators')
            ->once()
            ->andReturn($operators);
        $this->operatorRepository
            ->expects('save')
            ->andThrow(new Exception('Simulated save failure'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to update operators.');
        $this->expectExceptionCode(400);

        $this->updateOperatorsService->update();
    }
}
