<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Collections\ItemsCollection;

interface ItemsRepository
{
    public function getAll(): ItemsCollection;

    public function getOne(string $id): ?Item;

    public function save(Item $item): void;

    public function delete(Item $item): void;

}