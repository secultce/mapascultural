<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\Interface\UserRepositoryInterface;
use App\Service\Interface\UserServiceInterface;
use MapasCulturais\Entities\User;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function find(int $id): User
    {
        return $this->repository->find($id);
    }
}
