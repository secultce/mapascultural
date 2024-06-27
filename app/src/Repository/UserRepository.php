<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enum\EntityStatusEnum;
use App\Exception\ResourceNotFoundException;
use App\Repository\Interface\UserRepositoryInterface;
use Doctrine\Persistence\ObjectRepository;
use MapasCulturais\Entities\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    private ObjectRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = $this->mapaCulturalEntityManager->getRepository(User::class);
    }

    public function findAll(): array
    {
        return $this->repository
            ->createQueryBuilder('user')
            ->where('User.status = :status')
            ->setParameter('status', EntityStatusEnum::ENABLED->getValue())
            ->getQuery()
            ->getArrayResult();
    }

    public function find(int $id): User
    {
        $user = $this->repository->findOneBy([
            'id' => $id,
            'status' => EntityStatusEnum::ENABLED->getValue(),
        ]);

        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->mapaCulturalEntityManager->persist($user);
        $this->mapaCulturalEntityManager->flush();
    }
}
