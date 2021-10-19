<?php

namespace App\Repositories\Interfaces;


use App\Models\Collections\RelationsCollection;
use App\Models\Relation;

interface RelationsRepository
{
    //public function getAll(): RelationsCollection;

    public function getOne(string $id): ?Relation;

    //public function save(Relation $relation): void;

    //public function delete(Relation $relation): void;
}