<?php

namespace App\Validations;

use App\Repositories\Interfaces\UsersRepository;
use InvalidArgumentException;

class ItemsValidation
{
    private UsersRepository $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateProductDetail($itemDetail)
    {
        if (strlen($itemDetail) < 1)
        {
            throw new InvalidArgumentException('Entered details are incorrect');
        }
    }
}