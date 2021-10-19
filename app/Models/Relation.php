<?php

namespace App\Models;

class Relation
{
    private string $relationId;
    private string $productId;
    private string $categoryId;

    public function __construct(string $relationId, string $productId, string $categoryId)
    {
        $this->productId = $relationId;
        $this->productId = $productId;
        $this->categoryId = $categoryId;
    }

    public function getRelationId(): string
    {
        return $this->relationId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }
}