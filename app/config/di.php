<?php

declare(strict_types=1);

use App\Repository\AgentRepository;
use App\Repository\EventRepository;
use App\Repository\Interface\AgentRepositoryInterface;
use App\Repository\Interface\EventRepositoryInterface;
use App\Repository\Interface\OpportunityRepositoryInterface;
use App\Repository\Interface\ProjectRepositoryInterface;
use App\Repository\Interface\SealRepositoryInterface;
use App\Repository\Interface\SpaceRepositoryInterface;
use App\Repository\Interface\TermRepositoryInterface;
use App\Repository\OpportunityRepository;
use App\Repository\ProjectRepository;
use App\Repository\SealRepository;
use App\Repository\SpaceRepository;
use App\Repository\TermRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

return [
    SerializerInterface::class => fn () => new Serializer([new ObjectNormalizer()]),
    ...repositories(),
];

function repositories(): array
{
    return [
        AgentRepositoryInterface::class => fn () => new AgentRepository(),
        EventRepositoryInterface::class => fn () => new EventRepository(),
        OpportunityRepositoryInterface::class => fn () => new OpportunityRepository(),
        ProjectRepositoryInterface::class => fn () => new ProjectRepository(),
        SealRepositoryInterface::class => fn () => new SealRepository(),
        SpaceRepositoryInterface::class => fn () => new SpaceRepository(),
        TermRepositoryInterface::class => fn () => new TermRepository(),
    ];
}
