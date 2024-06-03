<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\TermRepository;
use App\Request\TermRequest;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class TermApiController
{
    private TermRepository $repository;
    private TermRequest $request;

    public function __construct()
    {
        $this->repository = new TermRepository();
        $this->request = new TermRequest();
    }

    public function getList(): JsonResponse
    {
        $terms = $this->repository->findAll();

        return new JsonResponse($terms);
    }

    public function getOne(array $params): JsonResponse
    {
        try {
            $term = $this->request->validateTermExistent($params);

            return new JsonResponse($term);
        } catch (Exception $exceptionNotFoundTerm) {
            return new JsonResponse(['error' => $exceptionNotFoundTerm->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
