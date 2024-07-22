<?php

namespace NotificationsManager\Operators\Repositories;

use NotificationsManager\Operators\Database\Entities\Operator;

interface OperatorRepository
{
    public function save(Operator $operator): void;
}
