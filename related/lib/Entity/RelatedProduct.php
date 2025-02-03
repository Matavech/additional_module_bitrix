<?php

namespace Bitrix\Related\Entity;

use Bitrix\Main\Type\DateTime;

class RelatedProduct implements EntityInterface
{
    private ?int $id = null;
    private DateTime $createdAt;

    public function __construct(
        private int $dealId,
        private string $title,
        private float $price
    )
    {
        $this->createdAt = new DateTime();
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->id,
            'TITLE' => $this->title,
            'PRICE' => $this->price,
            'DEAL_ID' => $this->dealId,
            'CREATED_AT' => $this->createdAt->toString(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDealId(): int
    {
        return $this->dealId;
    }

    public function setDealId(int $dealId): self
    {
        $this->dealId = $dealId;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $dateTime): self
    {
        $this->createdAt = $dateTime;

        return $this;
    }
}