<?php

namespace NotificationsManager\Operators;

use NotificationsManager\Operators\Repositories\ApiRepositoryInterface;

class FakeApiRepository implements ApiRepositoryInterface
{
    /**
     * @throws \JsonException
     */
    public function fetchData(string $url): string
    {
        $operatorData = [
            [
                'sequenceNumber' => 1510105,
                'journalEntryType' => 'UP',
                'customerId' => 22,
                'id' => 4,
                'name' => '674654',
                'surname1' => '',
                'surname2' => '',
                'phone' => 0,
                'email' => '',
                'orderNotifications' => false,
                'orderNotificationEmail' => '',
                'orderNotificationByEmail' => false,
                'orderNotificationBySms' => false,
                'orderNotificationByPush' => false,
                'deleted' => true,
                'object' => 'SALQ9U',
                'objectSchema' => 'IQSFCOMUN'
            ],
        ];

        return json_encode($operatorData, JSON_THROW_ON_ERROR);
    }
}
