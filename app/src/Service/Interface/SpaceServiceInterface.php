<?php

declare(strict_types=1);

namespace App\Service\Interface;

use MapasCulturais\Entities\Space;

interface SpaceServiceInterface
{
    public function create(mixed $data): Space;

    public function getTypes(): array;

    public function update(int $id, object $data): Space;
}
