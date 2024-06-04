<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

final class TermDto
{
    #[Sequentially([new NotBlank(), new Type('string')], groups: ['post'])]
    #[Type('string', groups: ['patch'])]
    public mixed $taxonomy;

    #[Sequentially([new NotBlank(), new Type('string')], groups: ['post'])]
    #[Type('string', groups: ['patch'])]
    public mixed $term;

    #[Sequentially([new NotBlank(), new Type('string')], groups: ['post'])]
    #[Type('string', groups: ['patch'])]
    public mixed $description;
}
