<?php

namespace NotificationsManager\Operators\Tests\Unit;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery\Container;
use NotificationsManager\Operators\ApiOperatorsDataSource;
use NotificationsManager\Operators\Tests\OperatorTestDataBuilder;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApiOperatorsDataSourceTest extends TestCase
{
    private Client $client;
    private ApiOperatorsDataSource $apiDataSource;

    public function setUp(): void
    {
        parent::setUp();
        $mockeryContainer = new Container();
        $this->client = $mockeryContainer->mock(Client::class);

        $this->apiDataSource = new ApiOperatorsDataSource($this->client);
    }

    #[Test]
    public function getsOperators(): void
    {
        $operatorTestDataBuilder = new OperatorTestDataBuilder();
        $expectedResponse = [];
        $expectedResponse[] = $operatorTestDataBuilder->withId(3)->build();
        $operatorsDataApi = $operatorTestDataBuilder->withId(3)->toApiResponse();
        $apiResponse = new Response(200, [], $operatorsDataApi);
        $this->client
            ->expects('get')
            ->andReturn($apiResponse);

        $response = $this->apiDataSource->getOperators();

        $this->assertEquals($expectedResponse, $response);
    }

    #[Test]
    public function failsToGetOperators(): void
    {
        $this->client
            ->expects('get')
            ->andThrow(new Exception());

        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Failed to retrieve operators.');

        $this->apiDataSource->getOperators();
    }
}
