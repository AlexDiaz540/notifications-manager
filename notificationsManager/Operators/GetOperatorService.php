<?php

namespace NotificationsManager\Operators;

use Exception;
use Illuminate\Support\Facades\Http as HttpClient;

class GetOperatorService
{
    public const string URL = 'https://api.extexnal.com/operators/?sequence_number=12341234';

    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return array<array<string, mixed>>
     * @throws Exception
     */
    public function getOperators(): array
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
            ]
        ];
        $this->httpClient::fake([
            self::URL => $this->httpClient::response($operatorData, 200)
        ]);
        $response = $this->httpClient::get(self::URL);

        if ($response->failed()) {
            throw new Exception($response, 500);
        }

        return $response->json();
    }
}
