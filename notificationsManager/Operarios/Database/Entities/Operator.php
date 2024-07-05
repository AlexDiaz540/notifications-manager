<?php

namespace NotificationsManager\Operarios\Database\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="operators")
 */
class Operator
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $customerId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected string $surname_1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected string $surname_2;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected string $email;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $orderNotificationsEnabled;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected string $orderNotificationsEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $orderNotificationsByEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $orderNotificationsBySms;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $orderNotificationsByPush;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    protected datetime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected datetime $updatedAt;

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $surname_1
     */
    public function setSurname1($surname_1): void
    {
        $this->surname_1 = $surname_1;
    }

    /**
     * @param mixed $surname_2
     */
    public function setSurname2($surname_2): void
    {
        $this->surname_2 = $surname_2;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $orderNotificationsEnabled
     */
    public function setOrderNotificationsEnabled($orderNotificationsEnabled): void
    {
        $this->orderNotificationsEnabled = $orderNotificationsEnabled;
    }

    /**
     * @param mixed $orderNotificationsEmail
     */
    public function setOrderNotificationsEmail($orderNotificationsEmail): void
    {
        $this->orderNotificationsEmail = $orderNotificationsEmail;
    }

    /**
     * @param mixed $orderNotificationsByEmail
     */
    public function setOrderNotificationsByEmail($orderNotificationsByEmail): void
    {
        $this->orderNotificationsByEmail = $orderNotificationsByEmail;
    }

    /**
     * @param mixed $orderNotificationsBySms
     */
    public function setOrderNotificationsBySms($orderNotificationsBySms): void
    {
        $this->orderNotificationsBySms = $orderNotificationsBySms;
    }

    /**
     * @param mixed $orderNotificationsByPush
     */
    public function setOrderNotificationsByPush($orderNotificationsByPush): void
    {
        $this->orderNotificationsByPush = $orderNotificationsByPush;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


    /**
     * @param array<int> $data
     * @return void
     */
    public function setOperator(array $data): void
    {
        $this->setId($data['id']);
        $this->setCustomerId($data['customerId'] ?? null);
        $this->setName($data['name'] ?? null);
        $this->setSurname1($data['surname1'] ?? null);
        $this->setSurname2($data['surname2'] ?? null);
        $this->setPhone($data['phone'] ?? null);
        $this->setEmail($data['email'] ?? null);
        $this->setOrderNotificationsEnabled($data['orderNotificationsEnabled'] ?? false);
        $this->setOrderNotificationsEmail($data['orderNotificationsEmail'] ?? '');
        $this->setOrderNotificationsByEmail($data['orderNotificationsByEmail'] ?? false);
        $this->setOrderNotificationsBySms($data['orderNotificationsBySms'] ?? false);
        $this->setOrderNotificationsByPush($data['orderNotificationsByPush'] ?? false);
        $this->setDeleted($data['deleted'] ?? false);
    }
}
