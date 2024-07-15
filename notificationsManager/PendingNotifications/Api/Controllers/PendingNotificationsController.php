<?php

namespace NotificationsManager\PendingNotifications\Api\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use NotificationsManager\PendingNotifications\Database\Entities\PendingNotification;
use Illuminate\Http\JsonResponse;
use NotificationsManager\PendingNotifications\Api\Requests\PendingNotificationAddRequest;

class PendingNotificationsController
{
    private EntityManagerInterface $entityManager;
    private PendingNotification $pendingNotification;

    /**
     * @param EntityManagerInterface $entityManager
     * @param PendingNotification $pendingNotification
     */
    public function __construct(EntityManagerInterface $entityManager, PendingNotification $pendingNotification)
    {
        $this->entityManager = $entityManager;
        $this->pendingNotification = $pendingNotification;
    }

    public function __invoke(PendingNotificationAddRequest $request): JsonResponse
    {
        try {
            $pendingNotificationData = $request->all();
            $this->pendingNotification->setPendingNotification($pendingNotificationData);
            $this->entityManager->persist($this->pendingNotification);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw new HttpResponseException(response()->json(
                ['message' => "Failed to add pending notification."],
                500,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            ));
        }

        return response()->json([
            'message' => 'Pending notification added successfully.',
        ]);
    }
}
