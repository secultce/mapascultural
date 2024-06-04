<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\Interface\TermRepositoryInterface;
use App\Service\Interface\TermServiceInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use MapasCulturais\Entities\Term;
use Symfony\Component\Serializer\SerializerInterface;

class TermService extends AbstractService implements TermServiceInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly TermRepositoryInterface $termRepository
    ) {
    }

    public function create($data): Term
    {
        try {
            $term = $this->serializer->denormalize($data, Term::class);
            $this->termRepository->save($term);
        } catch (UniqueConstraintViolationException) {
            throw new Exception('Term already exists');
        }

        $this->termRepository->save($term);

        return $term;
    }

    public function removeById(int $id): void
    {
        $term = $this->termRepository->find($id);
        $this->termRepository->delete($term);
    }
}
