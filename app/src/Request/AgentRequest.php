<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\FieldRequiredException;
use App\Exception\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request;

class AgentRequest
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    public function validatePost(): array
    {
        $jsonData = $this->request->getContent();
        $data = json_decode($jsonData, associative: true);

        $requiredFields = ['type', 'name', 'shortDescription', 'terms'];

        foreach ($requiredFields as $field) {
            if (false === isset($data[$field])) {
                throw new FieldRequiredException(ucfirst($field));
            }
        }

        if (
            false === isset($data['type'])
            || false === is_array($data['terms'])
            || false === is_array($data['terms']['area'])
        ) {
            throw new InvalidRequestException('The "terms" field must be an object with a property "area" which is an array.');
        }

        return $data;
    }

    public function validateUpdate(): array
    {
        return json_decode(
            json: $this->request->getContent(),
            associative: true
        );
    }
}
