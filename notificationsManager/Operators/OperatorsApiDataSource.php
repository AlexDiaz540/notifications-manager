<?php

namespace NotificationsManager\Operators;

use Exception;
use Illuminate\Support\Facades\Http as HttpClient;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\ApiRepositoryInterface;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OperatorsApiDataSource
{
    public const string URL = 'http://api.extexnal.com/operators/?sequence_number=12341234';
    public function __construct(
        private readonly ApiRepositoryInterface $apiRepository,
    ) {
    }

    /**
     * @return array<Operator>
     * @throws Exception
     */
    public function getOperators(): array
    {
        try {
            $jsonResponse = $this->apiRepository->fetchData(self::URL);
            $operatorsData = json_decode($jsonResponse, true);
        } catch (Exception) {
            throw new Exception('Failed to retrieve operators.', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
        try {
            $operators = [];
            foreach ($operatorsData as $operatorData) {
                $operators[] = new Operator($operatorData);
            }
            return $operators;
        } catch (Exception $e) {
            throw new Exception('Failed to update operators.', 400);
        }
    }
}
