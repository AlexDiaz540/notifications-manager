<?php

namespace NotificationsManager\Operators;

use Exception;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\OperatorRepository;

class UpdateOperatorsService
{
    public function __construct(private readonly OperatorRepository $operatorRepository)
    {
    }

    /**
     * @param array<int> $operatorData
     * @throws Exception
     */
    public function update(array $operatorData): void
    {
        try {
            $operator = new Operator($operatorData);
            $this->operatorRepository->save($operator);
        } catch (Exception $e) {
            throw new Exception('Failed to update operator data.', 400);
        }
    }
}
