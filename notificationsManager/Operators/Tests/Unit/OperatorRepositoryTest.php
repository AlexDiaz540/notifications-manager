<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Doctrine\ORM\EntityManagerInterface;
use Mockery\Container;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OperatorRepositoryTest extends TestCase
{
    private OperatorRepositoryInterface $operatorRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->operatorRepository = $mockeryContainer->mock(OperatorRepositoryInterface::class);
    }

    #[Test]
    public function updateWhenOneOperatorGiven(): void
    {
        $operatorData = [
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
        $operatorInDataBase = [
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
        $operator = new Operator($operatorData);

        $this->operatorRepository
            ->shouldReceive('save')
            ->with($operator)
            ->once();

        $this->assertDatabaseHas('operators', $operatorInDataBase);
    }

    #[Test]
    public function updateWhenMultipleOperatorsGiven(): void
    {
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

        $this->operatorRepository
            ->shouldReceive('save')
            ->twice();

        foreach ($operatorsInDatabase as $operator) {
            $this->assertDatabaseHas('operators', $operator);
        }
    }
}
