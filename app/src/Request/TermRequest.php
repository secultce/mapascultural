<?php

declare(strict_types=1);

namespace App\Request;

use App\Enum\EntityStatusEnum;
use App\Repository\TermRepository;
use Exception;
use MapasCulturais\Entities\Term;
use Symfony\Component\HttpFoundation\Request;

class TermRequest
{
    protected Request $request;
    private TermRepository $repository;

    public function __construct()
    {
        $this->request = new Request();
        $this->repository = new TermRepository();
    }

    public function validateTermExistent(array $params): Term
    {
        $term = $this->repository->find((int) $params['id']);

        if (!$term || EntityStatusEnum::TRASH->getValue() === $term->status) {
            throw new Exception('Term not found.');
        }

        return $term;
    }
}
