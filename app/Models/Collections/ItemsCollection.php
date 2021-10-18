<?php

namespace App\Models\Collections;

use App\Models\Item;

class ItemsCollection
{
    private array $items = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add(
                new Item(
                    $item['id'],
                    $item['name'],
                    $item['category'],
                    $item['quantity'],
                    $item['created_at'],
                    $item['updated_at']
                )
            );
        }
    }

    public function add(Item $item): void
    {
        $this->items[] = $item;
    }

    public function remove(Item $item)
    {
        unset($this->items[$item->getId()]);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}