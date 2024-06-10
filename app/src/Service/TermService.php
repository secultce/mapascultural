<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\TermRepository;

class TermService
{
    public function __construct(
        private readonly TermRepository $repository
    ) {
    }

    public function removeById(int $id): void
    {
        $term = $this->repository->find($id);
        $this->repository->delete($term);
    }
}
