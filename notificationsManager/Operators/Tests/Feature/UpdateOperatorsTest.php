<?php

namespace NotificationsManager\Operators\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Mockery\Container;
use NotificationsManager\Operators\Commands\UpdateOperatorsCommand;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateOperatorsTest extends TestCase
{
    use RefreshDatabase;

    private OperatorRepositoryInterface $operatorRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->operatorRepository = $mockeryContainer->mock(OperatorRepositoryInterface::class);

        $this->app
            ->when(UpdateOperatorsCommand::class)
            ->needs(OperatorRepositoryInterface::class)
            ->give(fn () => $this->operatorRepository);
    }
    #[Test]
    public function updatesAnOperator(): void
    {
        $this->operatorRepository
            ->expects('update')
            ->once();
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(0);
    }

    #[Test]
    public function updatesOperatorsWhenApiRequestFails(): void
    {
        $this->operatorRepository
            ->expects('update')
            ->once()
            ->andThrow(new Exception('Failed to retrieve operators.', Response::HTTP_INTERNAL_SERVER_ERROR));
        $expectedResponse = json_encode(['message' => "Failed to retrieve operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }

    #[Test]
    public function updatesOperatorsWhenOperatorRepositoryFails(): void
    {
        $this->operatorRepository
            ->expects('update')
            ->once()
            ->andThrow(new Exception('Failed to update operators.', Response::HTTP_BAD_REQUEST));
        $expectedResponse = json_encode(['message' => "Failed to update operators."], JSON_THROW_ON_ERROR);

        $this->artisan('update:operators')
            ->expectsOutput($expectedResponse)
            ->assertExitCode(1);
    }
}
