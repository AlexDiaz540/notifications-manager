<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use NotificationsManager\Operators\DatabaseOperatorsDataSource;
use NotificationsManager\Operators\Tests\OperatorTestDataBuilder;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DatabaseOperatorsDataSourceTest extends TestCase
{
    use RefreshDatabase;

    private DatabaseOperatorsDataSource $databaseOperatorsDataSource;

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseOperatorsDataSource = $this->app->make(DatabaseOperatorsDataSource::class);
    }

    #[Test]
    public function savesOperators(): void
    {
        $operatorTestDataBuilder = new OperatorTestDataBuilder();
        $operators = [];
        $operators[] = $operatorTestDataBuilder->build();

        $this->databaseOperatorsDataSource->save($operators);

        $this->assertDatabaseHas('operators', $operatorTestDataBuilder->toDatabaseArray());
    }

    #[Test]
    public function failsToSaveOperators(): void
    {
        $operatorTestDataBuilder = new OperatorTestDataBuilder();
        $operators = [];
        $operators[] = $operatorTestDataBuilder->buildInvalidOperator();

        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Failed to update operators.');

        $this->databaseOperatorsDataSource->save($operators);
    }
}
