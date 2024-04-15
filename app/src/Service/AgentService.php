<?php

declare(strict_types=1);

namespace App\Service;

class AgentService
{
    public const FILE_TYPES = '/src/conf/agent-types.php';

    public function getTypes(): array
    {
        $typesFromConf = (require dirname(__DIR__, 3).self::FILE_TYPES)['items'] ?? [];

        return array_map(
            fn ($key, $item) => ['id' => $key, 'name' => $item['name']], 
            array_keys($typesFromConf),
            $typesFromConf
        );
    }
}