<?php

namespace NotificationsManager\Operators;

use Exception;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;

readonly class UpdateOperatorsService
{
    public function __construct(
        private OperatorRepositoryInterface $operatorRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {
        $this->operatorRepository->update();
    }
}
