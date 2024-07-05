<?php

namespace NotificationsManager\Operarios\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http as HttpClient;

class ActualizarOperarios extends Command
{
    protected $signature = 'update:operarios';

    protected $description = 'Actualiza los datos de los operarios';

    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
    }

    public function handle(): void
    {
        $url = 'https://api.extexnal.com/operators/?sequence_number=12341234';

        $this->httpClient::fake([
            $url => $this->httpClient::response([
                [
                    'sequenceNumber' => '12341234',
                ]
            ], 200)
        ]);

        $response = $this->httpClient::get($url);
        $operatorsInfo = $response->json();
        foreach ($operatorsInfo as $operator) {
            $this->info("Sequence Number: " . $operator['sequenceNumber']);
        }
    }
}
