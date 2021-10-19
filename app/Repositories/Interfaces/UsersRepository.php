<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UsersRepository
{
    public function save(User $user): void;
}