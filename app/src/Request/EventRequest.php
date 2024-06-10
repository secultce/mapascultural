<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\FieldRequiredException;
use App\Exception\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request;

class EventRequest
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    public function validatePost(): array
    {
        $jsonData = $this->request->getContent();
        $data = json_decode($jsonData, true);

        $requiredFields = ['name', 'shortDescription', 'classificacaoEtaria', 'terms'];
        foreach ($requiredFields as $field) {
            if (false === isset($data[$field])) {
                throw new FieldRequiredException(ucfirst($field));
            }
        }

        if (
            false === isset($data['terms']['linguagem'])
            || false === is_array($data['terms'])
            || false === is_array($data['terms']['linguagem'])
        ) {
            throw new InvalidRequestException('The "terms" field must be an object with a property "linguagem" which is an array.');
        }

        return $data;
    }

    public function validateUpdate(): array
    {
        $jsonData = $this->request->getContent();
        $data = json_decode($jsonData, associative: true);

        return $data;
    }
}
