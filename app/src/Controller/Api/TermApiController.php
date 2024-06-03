<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\TermRepository;
use App\Request\TermRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class TermApiController extends AbstractApiController
{
    public function __construct(
        private TermRepository $repository,
        private TermRequest $request
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
}
