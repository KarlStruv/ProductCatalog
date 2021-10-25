<?php

namespace App\Validations;

use App\Repositories\Interfaces\UsersRepository;
use InvalidArgumentException;

class UsersValidation
{
    private UsersRepository $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateName(string $name)
    {
        if ($this->userRepository->getOne($name) != null)
        {
            throw new InvalidArgumentException('Username already exists');
        }

        if (empty($name))
        {
            throw new InvalidArgumentException('Enter a username');
        }
    }

    public function validateEmail(string $email)
    {
        if ($this->userRepository->getOne($email) != null)
        {
            throw new InvalidArgumentException('Email already registered');
        }

        if (empty($email))
        {
            throw new InvalidArgumentException('Enter an email');
        }
    }

    public function validatePassword(string $password)
    {
        if (strlen($password) < 6 )
        {
            throw new InvalidArgumentException('Password must be at least 6 characters long');
        }
    }
}