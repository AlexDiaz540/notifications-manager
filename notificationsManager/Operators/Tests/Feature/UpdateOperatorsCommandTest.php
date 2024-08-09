<?php

namespace NotificationsManager\Operators\Tests\Feature;

use Doctrine\ORM\EntityManager;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Container;
use NotificationsManager\Operators\ApiOperatorsDataSource;
use NotificationsManager\Operators\DatabaseOperatorsDataSource;
use NotificationsManager\Operators\Tests\OperatorTestDataBuilder;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateOperatorsCommandTest extends TestCase
{
    use RefreshDatabase;

    private Client $client;
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->client = $mockeryContainer->mock(Client::class);
        $this->entityManager = $this->app->make(EntityManager::class);

        $this->app
            ->when(ApiOperatorsDataSource::class)
            ->needs(Client::class)
            ->give(fn () => $this->client);
        $this->app
            ->when(DatabaseOperatorsDataSource::class)
            ->needs(EntityManager::class)
            ->give(fn () => $this->entityManager);
    }

    #[Test]
    public function updatesAnOperator(): void
    {
        $operatorTestDataBuilder = new OperatorTestDataBuilder();
        $operatorsDataApi = $operatorTestDataBuilder->withId(3)->toApiResponse();
        $operatorInDataBase = $operatorTestDataBuilder->toDatabaseArray();
        $apiResponse = new Response(200, [], $operatorsDataApi);
        $this->client
            ->expects('get')
            ->andReturn($apiResponse);
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);

        $this->assertDatabaseHas('operators', $operatorInDataBase);
    }

    #[Test]
    public function updatesOperatorsButFailsToRetrieveOperators(): void
    {
        $this->client
            ->expects('get')
            ->once()
            ->andThrow(new Exception());
        $expectedResponse = json_encode(['message' => "Failed to retrieve operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }

    #[Test]
    public function updateOperatorsButFailsToUpdateOperators(): void
    {
        $operatorTestDataBuilder = new OperatorTestDataBuilder();
        $operatorInserted = $operatorTestDataBuilder->withId(6)->build();
        $this->entityManager->persist($operatorInserted);
        $this->entityManager->flush();
        $operatorsDataApi = $operatorTestDataBuilder->withId(6)->toApiResponse();
        $apiResponse = new Response(200, [], $operatorsDataApi);
        $this->client
            ->expects('get')
            ->andReturn($apiResponse);
        $expectedResponse = json_encode(['message' => 'Failed to update operators.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }
}
