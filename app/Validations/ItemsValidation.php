<?php

namespace App\Validations;

use App\Repositories\Interfaces\ItemsRepository;
use InvalidArgumentException;

class ItemsValidation
{
    private ItemsRepository $itemsRepository;

    public function __construct($itemsRepository)
    {
        $this->itemsRepository = $itemsRepository;
    }

    public function validateProductDetail($itemDetail)
    {
        if (empty($itemDetail))
        {
            throw new InvalidArgumentException('Entered details are incorrect');
        }
    }
}