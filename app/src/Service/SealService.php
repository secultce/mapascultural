<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\Interface\AgentRepositoryInterface;
use App\Repository\Interface\SealRepositoryInterface;
use MapasCulturais\Entities\Seal;
use Symfony\Component\Serializer\SerializerInterface;

class SealService extends AbstractService
{
    public function __construct(
        private readonly AgentRepositoryInterface $agentRepository,
        private readonly SerializerInterface $serializer,
        private readonly SealRepositoryInterface $sealRepository,
    ) {
    }

    public function create(array $data): mixed
    {
        $seal = $this->serializer->denormalize($data, Seal::class);
        $this->setProperty($seal, 'owner', $this->agentRepository->find(1));
        $this->sealRepository->save($seal);

        return $seal;
    }

    public function delete(int $id): void
    {
        $this->sealRepository->softDelete($id);
    }

    public function update(int $id, object $data): Seal
    {
        $sealFromDB = $this->sealRepository->find($id);

        $sealUpdated = $this->serializer->denormalize(
            data: $data,
            type: Seal::class,
            context: ['object_to_populate' => $sealFromDB]
        );

        $this->sealRepository->save($sealUpdated);

        return $sealUpdated;
    }
}
