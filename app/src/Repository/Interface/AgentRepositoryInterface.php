<?php

declare(strict_types=1);

namespace App\Repository\Interface;

use MapasCulturais\Entities\Agent;

interface AgentRepositoryInterface
{
    public function find(int $id): Agent;

    public function findAll(): array;

    public function save(Agent $agent): void;

    public function softDelete(Agent $agent): void;
}
