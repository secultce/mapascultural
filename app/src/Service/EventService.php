<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\EntityStatusEnum;
use App\Repository\Interface\EventRepositoryInterface;
use MapasCulturais\Entities\Event;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;

class EventService
{
    public const FILE_TYPES = '/src/conf/event-types.php';

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EventRepositoryInterface $repository,
    ) {
    }

    public function getTypes(): array
    {
        $typesFromConf = (require dirname(__DIR__, 3).self::FILE_TYPES)['items'] ?? [];

        return array_map(fn ($key, $item) => ['id' => $key, 'name' => $item['name']], array_keys($typesFromConf), $typesFromConf);
    }

    public function create($data): Event
    {
        $event = new Event();

        $event->setName($data->name);
        $event->setShortDescription($data->shortDescription);
        $event->setMetadata('classificacaoEtaria', $data->classificacaoEtaria);
        $event->terms['linguagem'] = $data->terms['linguagem'];

        $this->repository->save($event);

        return $event;
    }

    public function update(int $id, object $data): Event
    {
        $eventFromDB = $this->repository->find($id);

        if (null === $eventFromDB || EntityStatusEnum::TRASH->getValue() === $eventFromDB->status) {
            throw new ResourceNotFoundException('Event not found or already deleted.');
        }

        $eventUpdated = $this->serializer->denormalize(
            data: $data,
            type: Event::class,
            context: ['object_to_populate' => $eventFromDB]
        );
        $eventUpdated->saveTerms();

        $this->repository->update($eventUpdated);

        return $eventUpdated;
    }
}
