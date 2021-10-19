<?php


namespace App\Models\Collections;

use App\Models\Relation;


class RelationsCollection
{
    private array $relations = [];

    public function __construct(array $relations)
    {
        foreach ($relations as $relation) {
            $this->add(
                new Relation(
                    $relation['relation_id'],
                    $relation['product_id'],
                    $relation['category_id']
                )
            );
        }
    }

    public function add(Relation $relation): void
    {
        $this->relations[$relation->getRelationId()] = $relation;
    }

    public function getRelations(): array
    {
        return $this->relations;
    }

}