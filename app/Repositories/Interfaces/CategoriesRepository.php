<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use App\Models\Collections\CategoriesCollection;

interface CategoriesRepository
{
    public function getAll(): CategoriesCollection;
    public function getOne(string $id): ?Category;
}