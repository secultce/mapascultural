<?php

declare(strict_types=1);

namespace App\Service\Interface;

use MapasCulturais\Entities\User;

interface UserServiceInterface
{
    public function find(int $id): User;
}
