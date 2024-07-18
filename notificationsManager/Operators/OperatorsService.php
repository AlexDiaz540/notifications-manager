<?php

namespace NotificationsManager\Operators;

use Exception;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\OperatorRepository;

class OperatorsService
{
    private OperatorRepository $operatorRepository;
    public function __construct(OperatorRepository $operatorRepository)
    {
        $this->operatorRepository = $operatorRepository;
    }

    /**
     * @param array<int> $operatorData
     * @return void
     * @throws Exception
     */
    public function updateOperator(array $operatorData): void
    {
        try {
            $operator = new Operator();
            $operator->setOperator($operatorData);
            $this->operatorRepository->save($operator);
        } catch (Exception $e) {
            throw new Exception('Failed to update operator data.', 400);
        }
    }
}
