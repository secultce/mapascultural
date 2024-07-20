<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Enum\AuthProviderEnum;
use App\Enum\EntityStatusEnum;
use Doctrine\Persistence\ObjectManager;
use MapasCulturais\Entities\PermissionCache;
use MapasCulturais\Entities\User;
use MapasCulturais\Entities\UserMeta;
use MapasCulturais\Entities\UserPermissionCache;

class UserFixtures extends Fixture
{
    public const USER_ID_PREFIX = 'user';
    public const USER_ID_1 = 1;
    public const USER_ID_2 = 2;
    public const USER_ID_3 = 3;
    public const USER_ID_4 = 4;
    public const USER_ID_5 = 5;
    public const USER_ID_6 = 6;

    public const USERS = [
        [
            'id' => self::USER_ID_1,
            'email' => 'Admin@local',
            'auth_provider' => AuthProviderEnum::OPEN_ID,
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::USER_ID_2,
            'email' => 'user2@email.com',
            'auth_provider' => AuthProviderEnum::OPEN_ID,
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::USER_ID_3,
            'email' => 'user3@email.com',
            'auth_provider' => AuthProviderEnum::OPEN_ID,
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::USER_ID_4,
            'email' => 'user4@email.com',
            'auth_provider' => AuthProviderEnum::OPEN_ID,
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::USER_ID_5,
            'email' => 'user5@email.com',
            'auth_provider' => AuthProviderEnum::OPEN_ID,
            'status' => EntityStatusEnum::ENABLED,
        ],
        [
            'id' => self::USER_ID_6,
            'email' => 'user6@email.com',
            'auth_provider' => AuthProviderEnum::OPEN_ID,
            'status' => EntityStatusEnum::ENABLED,
        ],
    ];

    public const USER_META = [
        [
            'key' => 'localAuthenticationPassword',
            'value' => '123456',
            'owner' => self::USER_ID_1,
        ],
        [
            'key' => 'localAuthenticationPassword',
            'value' => '123456',
            'owner' => self::USER_ID_2,
        ],
        [
            'key' => 'localAuthenticationPassword',
            'value' => '123456',
            'owner' => self::USER_ID_3,
        ],
        [
            'key' => 'localAuthenticationPassword',
            'value' => '123456',
            'owner' => self::USER_ID_4,
        ],
        [
            'key' => 'localAuthenticationPassword',
            'value' => '123456',
            'owner' => self::USER_ID_5,
        ],
        [
            'key' => 'localAuthenticationPassword',
            'value' => '123456',
            'owner' => self::USER_ID_6,
        ],
    ];

    public const PERMISSION_CACHE = [
        [
            'user_id' => self::USER_ID_1,
            'object_id' => self::USER_ID_1,
        ],
        [
            'user_id' => self::USER_ID_2,
            'object_id' => self::USER_ID_2,
        ],
        [
            'user_id' => self::USER_ID_3,
            'object_id' => self::USER_ID_3,
        ],
        [
            'user_id' => self::USER_ID_4,
            'object_id' => self::USER_ID_4,
        ],
        [
            'user_id' => self::USER_ID_5,
            'object_id' => self::USER_ID_5,
        ],
        [
            'user_id' => self::USER_ID_6,
            'object_id' => self::USER_ID_6,
        ],
    ];

    public const ACTIONS = [
        'deleteAccount',
        'view',
        'modify',
        'remove',
        'viewPrivateData',
        'destroy',
    ];

    public function load(ObjectManager $manager): void
    {
        $this->deleteAllDataFromTable(User::class);
        $this->deleteAllDataFromTable(UserMeta::class);
        $this->deleteAllDataFromTable(PermissionCache::class);

        foreach (self::USERS as $userData) {
            $user = new User();
            $user->email = $userData['email'];
            $user->setStatus($userData['status']->getValue());
            $user->setAuthProvider($userData['auth_provider']->getValue());
            $user->setAuthUid($userData['email']);

            $this->setReference(sprintf('%s-%s', self::USER_ID_PREFIX, $userData['id']), $user);
            $manager->persist($user);
        }

        foreach (self::USER_META as $userMetaData) {
            $userMeta = new UserMeta();
            $userMeta->key = $userMetaData['key'];
            $encryptedValue = password_hash($userMetaData['value'], PASSWORD_BCRYPT);
            $userMeta->value = $encryptedValue;
            $userMeta->owner = $this->getReference(sprintf('%s-%s', self::USER_ID_PREFIX, $userMetaData['owner']));

            $manager->persist($userMeta);
        }

        $objectType = 'MapasCulturais\Entities\User';
        foreach (self::PERMISSION_CACHE as $permissionCacheData) {
            $userReference = $this->getReference(UserFixtures::USER_ID_PREFIX.'-'.$permissionCacheData['user_id']);
            $objectIdReference = $this->getReference(UserFixtures::USER_ID_PREFIX.'-'.$permissionCacheData['object_id']);

            foreach (self::ACTIONS as $action) {
                $permissionCache = new UserPermissionCache();
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
