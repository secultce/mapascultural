<?php

declare(strict_types=1);

namespace App\Request;

use Exception;
use Symfony\Component\HttpFoundation\Request;

class OpportunityRequest
{
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function validatePost(): array
    {
        $jsonData = $this->request->getContent();
        $data = json_decode($jsonData, true);

        $requiredFields = ['opportunityType', 'title', 'area'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new Exception(ucfirst($field).' is required.');
            }
        }

        $linkFields = ['project', 'event', 'space', 'agent'];
        foreach ($linkFields as $field) {
            if (isset($data[$field]) && !is_array($data[$field])) {
                throw new Exception(ucfirst($field).' must be an array if provided.');
            }
        }

        return $data;
    }

    public function validateDelete(array $params): Opportunity
    {
        if (!isset($params['id'])) {
            throw new Exception('ID is required.');
        }

        $opportunity = $this->repository->find((int) $params['id']);

        if (!$opportunity || $opportunity->status === -10) {
            throw new Exception('Opportunity not found or already deleted.');
        }

        return $opportunity;
    }
}