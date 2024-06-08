<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\OpportunityRepository;
use App\Request\OpportunityRequest;
use App\Service\OpportunityService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OpportunityApiController extends AbstractApiController
{
    public function __construct(
        private OpportunityRequest $opportunityRequest,
        private OpportunityService $opportunityService,
        private OpportunityRepository $repository
    ) {
    }

    public function getList(): JsonResponse
    {
        $opportunities = $this->repository->findAll();

        return new JsonResponse($opportunities);
    }

    public function getOne(array $params): JsonResponse
    {
        $id = $this->extractIdParam($params);
        $opportunity = $this->repository->find($id);

        return new JsonResponse($opportunity);
    }

    public function post(): JsonResponse
    {
        $opportunityData = $this->opportunityRequest->validatePost();
        $opportunity = $this->opportunityService->create((object) $opportunityData);

        $responseData = [
            'id' => $opportunity->getId(),
            'name' => $opportunity->getName(),
            'terms' => $opportunity->getTerms(),
            '_type' => $opportunity->getType(),
        ];

        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    public function getOpportunitiesByAgent(array $params): JsonResponse
    {
        $agentId = $this->extractIdParam($params);
        $opportunities = $this->repository->findOpportunitiesByAgentId($agentId);

        return new JsonResponse($opportunities);
    }

    public function patch(array $params): JsonResponse
    {
        $id = $this->extractIdParam($params);
        $opportunityData = $this->opportunityRequest->validateUpdate();
        $opportunity = $this->opportunityService->update($id, (object) $opportunityData);

        return new JsonResponse($opportunity, Response::HTTP_CREATED);
    }

    public function delete(array $params): JsonResponse
    {
        $id = $this->extractIdParam($params);
        $this->repository->softDelete($id);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
