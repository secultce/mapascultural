<?php

declare(strict_types=1);

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

return [
    SerializerInterface::class => function () {
        return new Serializer([new ObjectNormalizer()]);
    },
];
