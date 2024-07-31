<?php

namespace NotificationsManager\Operators\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Mockery\Container;
use NotificationsManager\Operators\OperatorsApiDataSource;
use NotificationsManager\Operators\Repositories\ApiRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateOperatorsTest extends TestCase
{
    use RefreshDatabase;

    private ApiRepositoryInterface $apiRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->apiRepository = $mockeryContainer->mock(ApiRepositoryInterface::class);

        $this->app
            ->when(OperatorsApiDataSource::class)
            ->needs(ApiRepositoryInterface::class)
            ->give(fn () => $this->apiRepository);
    }
    #[Test]
    public function updateOneOperator(): void
    {
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
            ],
        ];
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($operatorData));

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
    }

    #[Test]
    public function updateMultipleOperators(): void
    {
        $operatorsData = [
            [
                'sequenceNumber' => 1510105,
                'journalEntryType' => 'UP',
                'customerId' => 22,
                'id' => 4,
                'name' => '674654',
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
                'sequenceNumber' => 1510133,
                'journalEntryType' => 'UP',
                'customerId' => 23,
                'id' => 3,
                'name' => '654234',
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
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($operatorsData));

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
    }

    #[Test]
    public function updateOperatorsWithNoOperatorsReceived(): void
    {
        $operatorsData = [];
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($operatorsData));
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
    }

    #[Test]
    public function updateOpertatorsWhenApiRequestFails(): void
    {
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andThrow(new Exception());
        $expectedResponse = json_encode(['message' => "Failed to retrieve operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }

    #[Test]
    public function updateOperatorsWhenInsertInDataBaseFails(): void
    {
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
            ]
        ];
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($operatorsData));
        $this->mock(EntityManagerInterface::class, function ($mock) {
            $mock->shouldReceive('persist')->andThrow(new Exception('Database error'));
            $mock->shouldReceive('flush')->andThrow(new Exception('Database error'));
        });
        $expectedResponse = json_encode(['message' => "Failed to update operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }

    #[Test]
    public function updateOperatorsWhenCreateEntityOperatorFails(): void
    {
        $operatorsData = [
            [
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
            ->andReturn(json_encode($operatorsData));
        $expectedResponse = json_encode(['message' => "Failed to update operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }
}
