<?php

namespace NotificationsManager\Operators\Repositories;

use NotificationsManager\Operators\Database\Entities\Operator;

interface OperatorRepositoryInterface
{
    public function save(Operator $operator): void;
}
