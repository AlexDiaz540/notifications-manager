<?php

namespace NotificationsManager\Operators\Repositories;

use NotificationsManager\Operators\Database\Entities\Operator;

interface OperatorRepository
{
    /**
     * @param array<int> $operatorData
     * @return void
     */
    public function save(array $operatorData): void;
}
