<?php


namespace App\Models;

use Carbon\Carbon;

class Item
{
    private string $id;
    private string $name;
    private string $category;
    private int $quantity;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $category,
        int $quantity,
        ?string $createdAt = null,
        ?string $updatedAt = null
    )

    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt ?? Carbon::now();
        $this->updatedAt = $updatedAt ?? Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCreatedAt() : string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getName(),
            'category' => $this->getCategory(),
            'quantity' => $this->getQuantity(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }

}