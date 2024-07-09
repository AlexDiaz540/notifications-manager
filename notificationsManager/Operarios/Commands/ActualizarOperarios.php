<?php

namespace NotificationsManager\Operarios\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http as HttpClient;
use NotificationsManager\Operarios\Database\Entities\Operator;

class ActualizarOperarios extends Command
{
    protected $signature = 'update:operarios';

    protected $description = 'Actualiza los datos de los operarios';

    private HttpClient $httpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClient $httpClient, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function handle(): void
    {
        try {
            $url = 'https://api.extexnal.com/operators/?sequence_number=12341234';
            $data = [
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
                $url => $this->httpClient::response($data, 200)
            ]);

            $response = $this->httpClient::get($url);
            if ($response->failed()) {
                throw new Exception('Failed to retrieve operators.', 500);
            }

            $operatorsInfo = $response->json();
            $operator = new Operator();

            try {
                $operator->setOperator($operatorsInfo[0]);
                $this->entityManager->persist($operator);
                $this->entityManager->flush();
            } catch (Exception $e) {
                throw new Exception('Failed to update operators.', 500);
            }
            $response = [
                'message' => 'Operators updated successfully.'
            ];

            $jsonResponse = json_encode($response, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

            $this->info($jsonResponse);
        } catch (Exception $exception) {
            $response = [
                'message' => $exception->getMessage()
            ];

            $jsonResponse = json_encode($response, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
            $this->error($jsonResponse);
        }
    }
}
