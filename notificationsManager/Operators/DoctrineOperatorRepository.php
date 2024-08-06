<?php

namespace NotificationsManager\Operators;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Client;
use NotificationsManager\Operators\Database\Entities\Operator;
use NotificationsManager\Operators\Repositories\OperatorRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class DoctrineOperatorRepository implements OperatorRepositoryInterface
{
    private Client $client;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->client = new Client();
        $this->entityManager = $entityManager;
    }

    public function update(): void
    {
        try {
            $url = 'http://api.extexnal.com/operators/?sequence_number=12341234';
            $response = $this->client->get($url);
            $operatorsData = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $exception) {
            throw new Exception('Failed to retrieve operators.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            foreach ($operatorsData as $operatorData) {
                $operator = new Operator($operatorData);
                $this->entityManager->persist($operator);
            }
            $this->entityManager->flush();
        } catch (Exception) {
            throw new Exception('Failed to update operators.', Response::HTTP_BAD_REQUEST);
        }
    }
}
