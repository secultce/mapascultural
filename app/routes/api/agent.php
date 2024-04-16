<?php

declare(strict_types=1);

use App\Controller\Api\AgentApiController;
use App\Controller\Api\OpportunityApiController;
use Symfony\Component\HttpFoundation\Request;

return [
    '/api/v2/agents' => [
        Request::METHOD_GET => [AgentApiController::class, 'getList'],
    ],
    '/api/v2/agents/types' => [
        Request::METHOD_GET => [AgentApiController::class, 'getTypes'],
    ],
    '/api/v2/agents/{id}' => [
        Request::METHOD_GET => [AgentApiController::class, 'getOne'],
    ],
    '/api/v2/agents/{id}/opportunities' => [
        Request::METHOD_GET => [OpportunityApiController::class, 'getOpportunitiesByAgent'],
    ],
];
