<?php

namespace NotificationsManager\Operators\Tests;

use NotificationsManager\Operators\Database\Entities\Operator;

class OperatorTestDataBuilder
{
    protected int $id;
    protected int $customerId;
    protected string $name;
    protected string $surname_1;
    protected string $surname_2;
    protected int $phone;
    protected string $email;
    protected bool $orderNotificationsEnabled;
    protected string $orderNotificationsEmail;
    protected bool $orderNotificationsByEmail;
    protected bool $orderNotificationsBySms;
    protected bool $orderNotificationsByPush;
    protected bool $deleted;

    /**
     * @param int $id
     * @param int $customerId
     * @param string $name
     * @param string $surname_1
     * @param string $surname_2
     * @param int $phone
     * @param string $email
     * @param bool $orderNotificationsEnabled
     * @param string $orderNotificationsEmail
     * @param bool $orderNotificationsByEmail
     * @param bool $orderNotificationsBySms
     * @param bool $orderNotificationsByPush
     * @param bool $deleted
     */
    public function __construct()
    {
        $this->id = 1;
        $this->customerId = 1234;
        $this->name = 'some_name';
        $this->surname_1 = 'some_surname_1';
        $this->surname_2 = 'some_surname_2';
        $this->phone = 13556764;
        $this->email = 'someEmail@gmail.com';
        $this->orderNotificationsEnabled = false;
        $this->orderNotificationsEmail = '';
        $this->orderNotificationsByEmail = false;
        $this->orderNotificationsBySms = false;
        $this->orderNotificationsByPush = false;
        $this->deleted = true;
    }

    public function withId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function buildInvalidOperator(): Operator
    {
        return new Operator(
            $this->id,
            $this->customerId,
        );
    }

    public function build()
    {
        return new Operator(
            $this->id,
            $this->customerId,
            $this->name,
            $this->surname_1,
            $this->surname_2,
            $this->phone,
            $this->email,
            $this->orderNotificationsEnabled,
            $this->orderNotificationsEmail,
            $this->orderNotificationsByEmail,
            $this->orderNotificationsBySms,
            $this->orderNotificationsByPush,
            $this->deleted
        );
    }

    public function toArray(): array
    {
        return [
            "sequenceNumber" => 1510105,
            "journalEntryType" => "UP",
            "customerId" => $this->customerId,
            "id" => $this->id,
            "name" => $this->name,
            "surname1" => $this->surname_1,
            "surname2" => $this->surname_2,
            "phone" => $this->phone,
            "email" => $this->email,
            "orderNotifications" => $this->orderNotificationsEnabled,
            "orderNotificationEmail" => $this->orderNotificationsEmail,
            "orderNotificationByEmail" => $this->orderNotificationsByEmail,
            "orderNotificationBySms" => $this->orderNotificationsBySms,
            "orderNotificationByPush" => $this->orderNotificationsByPush,
            "deleted" => $this->deleted,
            "object" => "SALQ9U",
            "objectSchema" => "IQSFCOMUN"
        ];
    }

    public function toApiResponse(): string
    {
        return json_encode([$this->toArray()], JSON_THROW_ON_ERROR);
    }

    public function toDatabaseArray(): array
    {
        return [
            'customer_id' => $this->customerId,
            'id' => $this->id,
            'name' => $this->name,
            'surname_1' => $this->surname_1,
            'surname_2' => $this->surname_2,
            'phone' => $this->phone,
            'email' => $this->email,
            'order_notifications_enabled' => $this->orderNotificationsEnabled,
            'order_notifications_email' => $this->orderNotificationsEmail,
            'order_notifications_by_email' => $this->orderNotificationsByEmail,
            'order_notifications_by_sms' =>  $this->orderNotificationsBySms,
            'order_notifications_by_push' =>  $this->orderNotificationsByPush,
            'deleted' => $this->deleted,
        ];
    }
}
