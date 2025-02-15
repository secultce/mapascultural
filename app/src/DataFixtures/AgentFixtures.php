<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Enum\AgentTypeEnum;
use App\Enum\EntityStatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use MapasCulturais\Entities\Agent;
use MapasCulturais\Entities\AgentPermissionCache;

class AgentFixtures extends Fixture implements DependentFixtureInterface
{
    public const AGENT_ID_PREFIX = 'agent';
    public const AGENT_ID_1 = 1;
    public const AGENT_ID_2 = 2;
    public const AGENT_ID_3 = 3;
    public const AGENT_ID_4 = 4;
    public const AGENT_ID_5 = 5;
    public const AGENT_ID_6 = 6;

    public const AGENTS = [
        [
            'id' => self::AGENT_ID_1,
            'name' => 'Admin@local',
            'type' => AgentTypeEnum::ADMIN,
            'shortDescription' => 'Admin@local',
            'longDescription' => '',
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::AGENT_ID_2,
            'name' => 'Alessandro Feitoza',
            'type' => AgentTypeEnum::DEFAULT,
            'shortDescription' => 'Agente Feitoza',
            'longDescription' => '',
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::AGENT_ID_3,
            'name' => 'Henrique Lima',
            'type' => AgentTypeEnum::DEFAULT,
            'shortDescription' => 'Agente Lima',
            'longDescription' => '',
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::AGENT_ID_4,
            'name' => 'Anna Kelly Moura',
            'type' => AgentTypeEnum::DEFAULT,
            'shortDescription' => 'Agente Moura',
            'longDescription' => '',
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::AGENT_ID_5,
            'name' => 'Sara Camilo',
            'type' => AgentTypeEnum::DEFAULT,
            'shortDescription' => 'Agente Camilo',
            'longDescription' => '',
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::AGENT_ID_6,
            'name' => 'Talyson Soares',
            'type' => AgentTypeEnum::DEFAULT,
            'shortDescription' => 'Agente Soares',
            'longDescription' => 'talyson soares',
            'status' => EntityStatusEnum::ENABLED,
        ],
    ];

    public const PERMISSION_CACHE = [
        [
            'user_id' => self::AGENT_ID_1,
            'object_id' => self::AGENT_ID_1,
        ],
        [
            'user_id' => self::AGENT_ID_2,
            'object_id' => self::AGENT_ID_2,
        ],
        [
            'user_id' => self::AGENT_ID_3,
            'object_id' => self::AGENT_ID_3,
        ],
        [
            'user_id' => self::AGENT_ID_4,
            'object_id' => self::AGENT_ID_4,
        ],
        [
            'user_id' => self::AGENT_ID_5,
            'object_id' => self::AGENT_ID_5,
        ],
        [
            'user_id' => self::AGENT_ID_6,
            'object_id' => self::AGENT_ID_6,
        ],
    ];

    public const ACTIONS = [
        '@control',
        'create',
        'view',
        'modify',
        'viewPrivateFiles',
        'viewPrivateData',
        'createAgentRelation',
        'createAgentRelationWithControl',
        'removeAgentRelation',
        'removeAgentRelationWithControl',
        'unarchive',
    ];

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->deleteAllDataFromTable(Agent::class);

        foreach (self::AGENTS as $agentData) {
            $user = $this->getReference(UserFixtures::USER_ID_PREFIX.'-'.$agentData['id']);

            $agent = new Agent($user);
            $agent->name = $agentData['name'];
            $agent->shortDescription = $agentData['shortDescription'];
            $agent->longDescription = $agentData['longDescription'];
            $agent->setType($agentData['type']->getValue());
            $agent->setStatus($agentData['status']->getValue());

            $this->setReference(sprintf('%s-%s', self::AGENT_ID_PREFIX, $agentData['id']), $agent);
            $manager->persist($agent);

            $this->setProperty($user, 'profile', $agent);
            $manager->persist($user);
        }

        $objectType = 'MapasCulturais\Entities\Agent';
        foreach (self::PERMISSION_CACHE as $permissionCacheData) {
            $userReference = $this->getReference(UserFixtures::USER_ID_PREFIX.'-'.$permissionCacheData['user_id']);
            $objectIdReference = $this->getReference(self::AGENT_ID_PREFIX.'-'.$permissionCacheData['object_id']);

            foreach (self::ACTIONS as $action) {
                $permissionCache = new AgentPermissionCache();
                $permissionCache->user = $userReference;
                $permissionCache->action = $action;
                $permissionCache->objectType = $objectType;
                $permissionCache->owner = $objectIdReference;

                $manager->persist($permissionCache);
            }
        }

        $manager->flush();
    }
}
