<?php

namespace NotificationsManager\Operators;

use Exception;
use NotificationsManager\Operators\Repositories\OperatorRepository;

readonly class UpdateOperatorsService
{
    public function __construct(
        private OperatorsApiDataSource $operatorsApiDataSource,
        private OperatorRepository $operatorRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {
        $operators = $this->operatorsApiDataSource->getOperators();
        try {
            foreach ($operators as $operator) {
                $this->operatorRepository->save($operator);
            }
        } catch (Exception) {
            throw new Exception('Failed to update operators.', 400);
        }
    }
}
