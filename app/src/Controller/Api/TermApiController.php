<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\Interface\TermRepositoryInterface;
use App\Service\TermService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TermApiController extends AbstractApiController
{
    public function __construct(
        private readonly TermRepositoryInterface $repository,
        private readonly TermService $service
    ) {
    }

    public function getList(): JsonResponse
    {
        $terms = $this->repository->findAll();

        return new JsonResponse($terms);
    }

    public function getOne(array $params): JsonResponse
    {
        $id = $this->extractIdParam($params);
        $term = $this->repository->find($id);

        return new JsonResponse($term);
    }

    public function remove(array $params): JsonResponse
    {
        $id = $this->extractIdParam($params);
        $this->service->removeById($id);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
