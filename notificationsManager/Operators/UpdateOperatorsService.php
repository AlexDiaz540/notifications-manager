<?php

namespace NotificationsManager\Operators;

use Exception;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\OperatorRepository;
use NotificationsManager\Operators\Repositories\OperatorsRequestRepository;

readonly class UpdateOperatorsService
{
    public function __construct(
        private OperatorRepository $operatorRepository,
        private OperatorsRequestRepository $operatorsRequestRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {
        $operatorsData = $this->operatorsRequestRepository->getOperators();
        try {
            $operator = new Operator($operatorsData[0]);
            $this->operatorRepository->save($operator);
        } catch (Exception $e) {
            throw new Exception('Failed to update operator data.', 400);
        }
    }
}
