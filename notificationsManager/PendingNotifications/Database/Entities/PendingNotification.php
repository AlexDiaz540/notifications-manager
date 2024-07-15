<?php

namespace NotificationsManager\PendingNotifications\Database\Entities;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pending_notifications")
 */
class PendingNotification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int|null
     *
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $customerId;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $operatorId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $orderNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $messageType;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $createdDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }



    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getOperatorId(): ?int
    {
        return $this->operatorId;
    }

    public function setOperatorId(int $operatorId): self
    {
        $this->operatorId = $operatorId;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getMessageType(): ?string
    {
        return $this->messageType;
    }

    public function setMessageType(string $messageType): self
    {
        $this->messageType = $messageType;

        return $this;
    }

    public function getCreatedDate(): ?DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function setPendingNotification(array $data): void
    {
        $this->setCustomerId($data['customerId'] ?? null);
        $this->setOperatorId($data['operatorId'] ?? null);
        $this->setOrderNumber($data['orderNumber'] ?? null);
        $this->setMessageType($data['messageType'] ?? null);
        $this->setCreatedDate(isset($data['createdDate']) ? new DateTime($data['createdDate']) : null);
    }
}
