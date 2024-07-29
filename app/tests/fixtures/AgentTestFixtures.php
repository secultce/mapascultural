<?php

declare(strict_types=1);

namespace App\Tests\fixtures;

final class AgentTestFixtures extends AbstractTestFixtures implements TestFixtures
{
    public static function partial(): self
    {
        return new self([
            'name' => 'Agent Test',
            'shortDescription' => 'A test agent.',
            'terms' => [
                'area' => ['Antropologia'],
            ],
            'type' => 2,
        ]);
    }

    public static function complete(): array
    {
        return [
            'name' => 'Agent Test',
            'shortDescription' => 'A test agent.',
            'longDescription' => 'A test agent for the Mapas Culturais.',
            'site' => 'https://mapasculturais.org',
            'cpf' => '123.456.789-00',
            'cnpj' => '12.345.678/0001-99',
            'emailPrivado' => 'nome@exemplo.com',
            'telefonePublico' => '(85) 99999-9999',
            'emailPublico' => 'agent@gmail.com',
            'telefone1' => '(11) 2345-6789',
            'telefone2' => '(11) 2345-6789',
            'En_CEP' => '12345-678',
            'type' => 2,
            'status' => 1,
            'terms' => [
                'area' => ['Antropologia', 'Artes Visuais'],
            ],
            'escolaridade' => 'Superior Completo',
            'instagram' => 'agent',
            'linkedin' => 'agent',
            'twitter' => 'agent',
            'vimeo' => 'agent',
            'youtube' => 'agent',
            'spotify' => 'agent',
            'pinterest' => 'agent',
        ];
    }

    public static function completeInstance(): self
    {
        return new self(self::complete());
    }

}
