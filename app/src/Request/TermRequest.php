<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

class TermRequest
{
    public function __construct(
        private Request $request
    ) {
    }
}
