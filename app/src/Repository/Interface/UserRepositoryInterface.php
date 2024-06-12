<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use MapasCulturais\Entities\User;

interface UserRepositoryInterface
{
    public function find(int $id): User;

    public function findAll(): array;

    public function save(User $user): void;
}
