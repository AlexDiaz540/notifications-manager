<?php

namespace NotificationsManager\Notifications\Api\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use NotificationsManager\Notifications\Database\Entities\PendingNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use NotificationsManager\Notifications\Api\Requests\NotificationAddRequest;

class NotificationsController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(NotificationAddRequest $request): JsonResponse
    {
        $pendingNotificationData = $request->all();
        $pendingNotification = new PendingNotification();
        $pendingNotification->setPendingNotification($pendingNotificationData);
        $this->entityManager->persist($pendingNotification);
        $this->entityManager->flush();

        return response()->json([
            'message' => 'Pending notification added successfully.',
        ]);
    }
}
