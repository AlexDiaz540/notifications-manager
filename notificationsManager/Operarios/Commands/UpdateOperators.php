<?php

namespace NotificationsManager\Operarios\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http as HttpClient;
use NotificationsManager\Operarios\Database\Entities\Operator;

class UpdateOperators extends Command
{
    protected $signature = 'update:operators';
    protected $description = 'Actualiza los datos de los operarios';
    private HttpClient $httpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClient $httpClient, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
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
                throw new RequestException($response);
            }

            $operatorsInfo = $response->json();

            $this->updateOperator($operatorsInfo[0]);

            $this->info(json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            return 0;
        } catch (RequestException $exception) {
            $this->error(json_encode(['message' => 'Failed to retrieve operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            return 1;
        } catch (Exception $exception) {
            $this->error(json_encode(['message' => 'Failed to update operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            return 1;
        }
    }

    /**
     * @param array<int> $operatorData
     * @return void
     * @throws Exception
     */
    private function updateOperator(array $operatorData): void
    {
        try {
            $operator = new Operator();
            $operator->setOperator($operatorData);
            $this->entityManager->persist($operator);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new Exception('Failed to update operator data.', 500);
        }
    }
}
