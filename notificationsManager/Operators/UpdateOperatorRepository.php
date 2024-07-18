<?php

namespace NotificationsManager\Operators;

use Doctrine\ORM\EntityManagerInterface;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\OperatorRepository;

class UpdateOperatorRepository implements OperatorRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function save(array $operatorData): void
    {
        $operator = new Operator();
        $operator->setOperator($operatorData);
        $this->entityManager->persist($operator);
        $this->entityManager->flush();
    }
}
