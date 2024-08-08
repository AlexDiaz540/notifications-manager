<?php

namespace NotificationsManager\Operators;

use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;

class ApiAndDoctrineOperatorRepository implements OperatorRepositoryInterface
{
    private ApiOperatorsDataSource $apiOperatorsDataSource;
    private DatabaseOperatorsDataSource $databaseOperatorsDataSource;

    public function __construct(ApiOperatorsDataSource $apiOperatorsDataSource, DatabaseOperatorsDataSource $databaseOperatorsDataSource)
    {
        $this->apiOperatorsDataSource  = $apiOperatorsDataSource;
        $this->databaseOperatorsDataSource  = $databaseOperatorsDataSource;
    }

    public function update(): void
    {
        $operators = $this->apiOperatorsDataSource->getOperators();
        $this->databaseOperatorsDataSource->save($operators);
    }
}
