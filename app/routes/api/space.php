<?php

declare(strict_types=1);

use App\Controller\Api\EventApiController;
use App\Controller\Api\SpaceApiController;
use Symfony\Component\HttpFoundation\Request;

return [
    '/api/v2/spaces' => [
        Request::METHOD_GET => [SpaceApiController::class, 'getList'],
        Request::METHOD_POST => [SpaceApiController::class, 'createSpace'],
    ],
    '/api/v2/spaces/{id}' => [
        Request::METHOD_GET => [SpaceApiController::class, 'getOne'],
        Request::METHOD_DELETE => [SpaceApiController::class, 'deleteSpace'],
    ],
    '/api/v2/spaces/{id}/events' => [
        Request::METHOD_GET => [EventApiController::class, 'getEventsBySpace'],
    ],
];
