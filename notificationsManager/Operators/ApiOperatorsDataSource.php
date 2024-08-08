<?php

namespace NotificationsManager\Operators;

use Exception;
use GuzzleHttp\Client;
use NotificationsManager\Operators\Database\Entities\Operator;
use Symfony\Component\HttpFoundation\Response;

class ApiOperatorsDataSource
{
    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Operator[]
     */
    public function getOperators(): array
    {
        try {
            $url = 'http://api.extexnal.com/operators/?sequence_number=12341234';
            $response = $this->client->get($url);
            $operatorsData = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            $operators = [];
            foreach ($operatorsData as $operatorData) {
                $operators[] = Operator::fromArray($operatorData);
            }
            return $operators;
        } catch (Exception) {
            throw new Exception('Failed to retrieve operators.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
