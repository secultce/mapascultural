<?php

declare(strict_types=1);

namespace App\DataFixtures;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use MapasCulturais\Entities\EventOpportunity;
use MapasCulturais\Entities\Opportunity;
use MapasCulturais\Entities\ProjectOpportunity;
use MapasCulturais\Entities\User;
use ReflectionClass;

class OpportunityFixtures extends Fixture implements DependentFixtureInterface
{
    public const OPPORTUNITY_ID_PREFIX = 'opportunity';
    public const OPPORTUNITY_ID_1 = 1;
    public const OPPORTUNITY_ID_2 = 2;
    public const OPPORTUNITY_ID_3 = 3;
    public const OPPORTUNITY_ID_4 = 4;

    public const EVENT_OPPORTUNITIES = [
        [
            'id' => self::OPPORTUNITY_ID_1,
            'name' => 'Concurso Teste',
            'shortDescription' => 'Desperte sua criatividade e mostre seu talento no Concurso de Artes! Inscreva suas obras originais e concorra a prêmios incríveis.',
            'publishedRegistrations' => false,
            'metadata' => [
                'twitter' => 'concurso_1',
                'instagram' => 'concurso_1',
            ],
            'terms' => [
                'area' => ['Arquivo'],
                'tag' => [
                    'Concurso',
                    'Artes',
                ],
            ],
            'type' => 23,
        ],
        [
            'id' => self::OPPORTUNITY_ID_2,
            'name' => 'Concurso Teste 2',
            'shortDescription' => 'Desperte sua criatividade e mostre seu talento no Concurso de Artes! Inscreva suas obras originais e concorra a prêmios incríveis.',
            'publishedRegistrations' => false,
            'metadata' => [
                'twitter' => 'concurso_2',
                'instagram' => 'concurso_2',
            ],
            'terms' => [
                'area' => ['Arquitetura-Urbanismo'],
                'tag' => [
                    'Teste',
                ],
            ],
            'type' => 24,
        ],
    ];

    public const PROJECT_OPPORTUNITIES = [
        [
            'id' => self::OPPORTUNITY_ID_3,
            'name' => 'Projeto de Verão',
            'shortDescription' => 'Desperte sua criatividade e mostre seu talento no Concurso de Artes! Inscreva suas obras originais e concorra a prêmios incríveis.',
            'publishedRegistrations' => false,
            'metadata' => [
                'instagram' => 'summer_project',
            ],
            'terms' => [
                'area' => ['Arquitetura-Urbanismo'],
            ],
            'type' => 1,
        ],
        [
            'id' => self::OPPORTUNITY_ID_4,
            'name' => 'O Projeto de verão falhou',
            'shortDescription' => 'Desperte sua criatividade e mostre seu talento no Concurso de Artes! Inscreva suas obras originais e concorra a prêmios incríveis.',
            'publishedRegistrations' => false,
            'metadata' => [
                'twitter' => 'the_summer_project',
            ],
            'terms' => [
                'area' => ['Arquitetura-Urbanismo'],
            ],
            'type' => 2,
        ],
    ];

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            EventFixtures::class,
            ProjectFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->deleteAllDataFromTable(Opportunity::class);

        $agent = $this->getReference(AgentFixtures::AGENT_ID_PREFIX.'-'.AgentFixtures::AGENT_ID_1);
        $event = $this->getReference(EventFixtures::EVENT_ID_PREFIX.'-'.EventFixtures::EVENT_ID_1);
        $project = $this->getReference(ProjectFixtures::PROJECT_ID_PREFIX.'-'.ProjectFixtures::PROJECT_ID_1);

        foreach (self::EVENT_OPPORTUNITIES as $opportunityData) {
            $opportunity = new EventOpportunity();

            $opportunity->name = $opportunityData['name'];
            $opportunity->shortDescription = $opportunityData['shortDescription'];

            self::setProperty($opportunity, 'publishedRegistrations', $opportunityData['publishedRegistrations']);

            $opportunity->setTerms($opportunityData['terms']);

            foreach ($opportunityData['metadata'] as $key => $data) {
                $opportunity->setMetadata($key, $data);
            }

            $opportunity->setRegistrationTo(new DateTime());
            $opportunity->setRegistrationFrom(new DateTime());
            $opportunity->setOwnerEntity($event);

            self::setProperty($opportunity, '_type', $opportunityData['type']);
            self::setProperty($opportunity, 'owner', $agent);

            $this->setReference(sprintf('%s-%s', self::OPPORTUNITY_ID_PREFIX, $opportunityData['id']), $opportunity);

            $reflection = new ReflectionClass($this->getApp()->auth);
            $method = $reflection->getMethod('_setAuthenticatedUser');

            $user = $manager->getRepository(User::class)->findOneBy(['id' => 1]);
            $method->invoke($this->getApp()->auth, $user);

            $manager->persist($opportunity);
        }

        foreach (self::PROJECT_OPPORTUNITIES as $opportunityData) {
            $opportunity = new ProjectOpportunity();

            $opportunity->name = $opportunityData['name'];
            $opportunity->shortDescription = $opportunityData['shortDescription'];
            self::setProperty($opportunity, 'publishedRegistrations', $opportunityData['publishedRegistrations']);

            $opportunity->setTerms($opportunityData['terms']);

            foreach ($opportunityData['metadata'] as $key => $data) {
                $opportunity->setMetadata($key, $data);
            }

            $opportunity->setRegistrationTo(new DateTime());
            $opportunity->setRegistrationFrom(new DateTime());
            $opportunity->setOwnerEntity($project);

            self::setProperty($opportunity, '_type', $opportunityData['type']);
            $this->setProperty($opportunity, 'owner', $agent);

            $this->setReference(sprintf('%s-%s', self::OPPORTUNITY_ID_PREFIX, $opportunityData['id']), $opportunity);

            $this->authenticate();

            $manager->persist($opportunity);
        }

        $manager->flush();
    }

    private function authenticate(): void
    {
        $reflection = new ReflectionClass($this->getApp()->auth);
        $method = $reflection->getMethod('_setAuthenticatedUser');

        $user = $this->getApp()->em->getRepository(User::class)->findOneBy(['id' => 1]);
        $method->invoke($this->getApp()->auth, $user);
    }
}
