<?php

declare(strict_types=1);

namespace App\Tests\fixtures;

final class EventTestFixtures extends AbstractTestFixtures implements TestFixtures
{
    public static function partial(): self
    {
        return new self([
            'name' => 'Event Test',
            'shortDescription' => 'Event Test Description',
            'longDescription' => 'Event Test Long Description',
            'rules' => 'Event Test Rules',
            'subTitle' => 'Event Test Subtitle',
            'registrationInfo' => 'Event Test Registration Info',
            'classificacaoEtaria' => 'livre',
            'telefonePublico' => '(85) 99999-9999',
            'preco' => 'R$ 50,00',
            'traducaoLibras' => 'Sim',
            'descricaoSonora' => 'Não',
            'site' => 'https://mapasculturais.org',
            'facebook' => 'event',
            'instagram' => 'event',
            'linkedin' => 'event',
            'twitter' => 'event',
            'vimeo' => 'event',
            'youtube' => 'event',
            'spotify' => 'event',
            'pinterest' => 'event',
            'event_attendance' => 50,
            'terms' => [
                'tag' => ['teste'],
                'linguagem' => ['Artes Circenses'],
            ],
        ]);
    }

    public static function complete(): array
    {
        return [];
    }
}
