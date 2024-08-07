<?php

namespace NotificationsManager;

use Doctrine\ORM\EntityManager;
use Exception;
use NotificationsManager\Operators\Database\Entities\Operator;
use Symfony\Component\HttpFoundation\Response;

class DatabaseOperatorsDataSource
{
    private EntityManager $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array<Operator> $operators
     */
    public function save($operators): void
    {
        try {
            foreach ($operators as $operator) {
                $this->entityManager->persist($operator);
            }
            $this->entityManager->flush();
        } catch (Exception) {
            throw new Exception('Failed to update operators.', Response::HTTP_BAD_REQUEST);
        }
    }
}
