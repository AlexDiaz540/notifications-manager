<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Container;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\DoctrineOperatorRepository;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OperatorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private OperatorRepositoryInterface $operatorRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->operatorRepository = $this->app->make(DoctrineOperatorRepository::class);
    }

    #[Test]
    public function updateOperatorInDatabase(): void
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

        $this->operatorRepository->save($operator);

        $this->assertDatabaseHas('operators', $operatorInDataBase);
    }
}
