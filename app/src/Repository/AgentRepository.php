<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enum\EntityStatusEnum;
use App\Exception\ResourceNotFoundException;
use App\Repository\Interface\AgentRepositoryInterface;
use Doctrine\Persistence\ObjectRepository;
use MapasCulturais\Entities\Agent;

class AgentRepository extends AbstractRepository implements AgentRepositoryInterface
{
    private ObjectRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = $this->mapaCulturalEntityManager->getRepository(Agent::class);
    }

    public function findAll(): array
    {
        return $this->repository
            ->createQueryBuilder('agent')
            ->getQuery()
            ->getArrayResult();
    }

    public function find(int $id): Agent
    {
        $agent = $this->repository->find($id);

        if (null === $agent) {
            throw new ResourceNotFoundException();
        }

        return $agent;
    }

    public function save(Agent $agent): void
    {
        $this->mapaCulturalEntityManager->persist($agent);
        $this->mapaCulturalEntityManager->flush();
    }

    public function softDelete(Agent $agent): void
    {
        $agent->setStatus(EntityStatusEnum::TRASH->getValue());
        $this->mapaCulturalEntityManager->persist($agent);
        $this->mapaCulturalEntityManager->flush();
    }
}
