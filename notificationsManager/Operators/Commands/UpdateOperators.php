<?php

namespace NotificationsManager\Operators\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http as HttpClient;
use NotificationsManager\Operators\OperatorsService;

class UpdateOperators extends Command
{
    protected $signature = 'update:operators';
    protected $description = 'Actualiza los datos de los operarios';
    private HttpClient $httpClient;

    private OperatorsService $operatorsService;

    public function __construct(HttpClient $httpClient, OperatorsService $operatorsService)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
        $this->operatorsService = $operatorsService;
    }

    public function handle(): int
    {
        $url = 'https://api.extexnal.com/operators/?sequence_number=12341234';
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
            ]
        ];

        $this->httpClient::fake([
            $url => $this->httpClient::response($operatorData, 200)
        ]);

        try {
            $response = $this->httpClient::get($url);

            if ($response->failed()) {
                throw new Exception($response, 500);
            }

            $operatorsInfo = $response->json();

            $this->operatorsService->updateOperator($operatorsInfo[0]);

            $this->info(json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            return 0;
        } catch (Exception $exception) {
            if ($exception->getCode() === 500) {
                $this->error(json_encode(['message' => 'Failed to retrieve operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            if ($exception->getCode() === 400) {
                $this->error(json_encode(['message' => 'Failed to update operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            return 1;
        }
    }
}
