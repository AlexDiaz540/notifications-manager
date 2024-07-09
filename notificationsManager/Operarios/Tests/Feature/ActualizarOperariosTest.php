<?php

namespace NotificationsManager\Operarios\Tests\Feature;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as HttpClient;
use Mockery\Container;
use NotificationsManager\Operarios\Commands\ActualizarOperarios;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActualizarOperariosTest extends TestCase
{
    use RefreshDatabase;

    private Response $response;
    private Container $mockeryContainer;
    private HttpClient $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockeryContainer = new Container();
        $this->httpClient = new HttpClient();
        $this->response = $this->mockeryContainer->mock(Response::class);
        $this->app
            ->when(ActualizarOperarios::class)
            ->needs(Response::class)
            ->give(fn () => $this->response);
    }
    #[Test]
    public function testActualizarOperarios(): void
    {
        $userData = [
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
        $expectedResponse = json_encode(['message' => 'Operators updated successfully.']);

        $this->artisan('update:operarios')
            ->expectsOutput($expectedResponse);
        $this->assertDatabaseHas('operators', $userData);
    }

    public function testWhenApiFails(): void
    {
        $this->response
            ->shouldReceive('failed')
            ->with()
            ->once()
            ->andReturn(true);

        $this->httpClient::fake([
            'https://api.extexnal.com/operators/*' => $this->httpClient::response([], 500)
        ]);
        $expectedResponse = json_encode(['message' => "Failed to retrieve operators."]);

        $this->artisan('update:operarios')
            ->expectsOutput($expectedResponse);
    }
}
