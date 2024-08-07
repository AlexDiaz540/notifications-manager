<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Container;
use NotificationsManager\DatabaseOperatorsDataSource;
use NotificationsManager\Operators\Database\Entities\Operator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DatabaseOperatorsDataSourceTest extends TestCase
{
    use RefreshDatabase;

    private DatabaseOperatorsDataSource $databaseOperatorsDataSource;
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

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseOperatorsDataSource = $this->app->make(DatabaseOperatorsDataSource::class);
    }

    #[Test]
    public function savesOperators(): void
    {
        $operators = [];
        $operators[] = new Operator($this->operatorData);

        $this->databaseOperatorsDataSource->save($operators);

        $this->assertDatabaseHas('operators', $this->operatorInDataBase);
    }
}
