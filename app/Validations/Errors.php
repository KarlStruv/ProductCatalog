<?php

namespace App\Validations;

class Errors
{
    public array $errors = [];

    public function add($error): void
    {
        $this->errors[] = $error;
    }

    public function get(): array
    {
        return $this->errors;
    }
}