<?php

namespace NotificationsManager\Operators\Repositories;

use Exception;

interface OperatorsRequestRepository
{
    public const string URL = 'https://api.extexnal.com/operators/?sequence_number=12341234';

    /**
     * @return array<array<string, mixed>>
     * @throws Exception
     */
    public function getOperators(): array;
}
