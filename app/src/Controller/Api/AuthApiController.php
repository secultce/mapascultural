<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Exception\InvalidCredentialsException;
use App\Request\AuthRequest;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthApiController extends AbstractApiController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly AuthRequest $authRequest
    ) {
    }

    public function auth(): JsonResponse
    {
        $request = $this->authRequest->validatePost();

        $user = $this->userService->findOneBy([
            'email' => $request['email'],
        ]);

        if (null === $user->getMetadata('localAuthenticationPassword')) {
            throw new InvalidCredentialsException();
        }

        if (false === password_verify($request['password'], $user->getMetadata('localAuthenticationPassword'))) {
            throw new InvalidCredentialsException();
        }

        $user->setAuthToken('1q2w3e'.substr(microtime(), 0, 8).$user->id);
        $this->userService->save($user);

        return new JsonResponse([
            'id' => $user->id,
            'name' => $user->profile->name,
            'token' => $user->getAuthToken(),
        ]);
    }
}
