<?php

namespace NotificationsManager\Operators\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Mockery\Container;
use NotificationsManager\Operators\OperatorsApiDataSource;
use NotificationsManager\Operators\Repositories\ApiRepositoryInterface;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use NotificationsManager\Operators\UpdateOperatorsService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateOperatorsTest extends TestCase
{
    use RefreshDatabase;

    private $operatorData = [
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
    private ApiRepositoryInterface $apiRepository;
    private OperatorRepositoryInterface $operatorRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->apiRepository = $mockeryContainer->mock(ApiRepositoryInterface::class);
        $this->operatorRepository = $mockeryContainer->mock(OperatorRepositoryInterface::class);

        $this->app
            ->when(OperatorsApiDataSource::class)
            ->needs(ApiRepositoryInterface::class)
            ->give(fn () => $this->apiRepository);
        $this->app
            ->when(UpdateOperatorsService::class)
            ->needs(OperatorRepositoryInterface::class)
            ->give(fn () => $this->operatorRepository);
    }
    #[Test]
    public function updatesAnOperator(): void
    {
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($this->operatorData));
        $this->operatorRepository
            ->expects('save')
            ->once();

        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);
        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
    }

    #[Test]
    public function updatesOperatorsWhenApiRequestFails(): void
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
    public function updatesOperatorsWhenOperatorRepositoryFails(): void
    {
        $this->apiRepository
            ->expects('fetchData')
            ->with('http://api.extexnal.com/operators/?sequence_number=12341234')
            ->once()
            ->andReturn(json_encode($this->operatorData));
        $this->operatorRepository
            ->expects('save')
            ->once()
            ->andThrow(new Exception('Database error'));

        $expectedResponse = json_encode(['message' => "Failed to update operators."], JSON_THROW_ON_ERROR);
        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }
}
