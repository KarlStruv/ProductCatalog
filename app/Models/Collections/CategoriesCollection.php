<?php

namespace App\Models\Collections;

use App\Models\Category;


class CategoriesCollection
{
    private array $categories = [];

    public function __construct(array $categories)
    {
        foreach ($categories as $category) {
            $this->add(
                new Category(
                    $category['id'],
                    $category['name']
                )
            );
        }
    }

    public function add(Category $category): void
    {
        $this->categories[$category->getId()] = $category;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

}