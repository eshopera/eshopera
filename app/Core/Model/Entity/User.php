<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Model\Entity;

use Eshopera\Core\Lib\Mvc\BaseModel;
use Eshopera\Core\Lib\Auth\IdentityInterface;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use PhalconExt\Mvc\Model\Traits;

/**
 * User entity
 */
class User extends BaseModel implements IdentityInterface
{

    use Traits\SoftDeleteTrait,
        Traits\RateLimitLoginTrait;

    const MAX_FAILED_LOGIN_ATTEMPTS = 10;
    const ACCOUNT_LOCK_DURATION = 900;
    const COLUMN_EMAIL_LENGTH = 100;
    const COLUMN_NAME_LENGTH = 200;
    const COLUMN_EXTERNAL_ID_LENGTH = 50;
    const COLUMN_PREF_LANG_LENGTH = 2;
    const COLUMN_PREF_LOCALE_LENGTH = 6;
    const COLUMN_PREF_TIMEZONE_LENGTH = 50;
    const COLUMN_PASSWORD_MIN_LENGTH = 4;
    const COLUMN_PASSWORD_MAX_LENGTH = 100;

    public $id;
    public $createdAt;
    public $updatedAt;
    public $active = false;
    public $email;
    public $name;
    public $externalId;
    public $prefLang;
    public $prefLocale;
    public $prefTimezone;
    private $passwdHash;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrefLang()
    {
        return $this->prefLang;
    }

    public function getPrefLocale()
    {
        return $this->prefLocale;
    }

    public function getPrefTimezone()
    {
        return $this->prefTimezone;
    }

    public function getPasswdHash()
    {
        return $this->passwdHash;
    }

    public function setPasswd($passwd)
    {
        $this->passwdHash = $this->getDI()->get('crypt')->encryptBase64(
            $this->getDI()->get('security')->hash($passwd)
        );
        return $this;
    }

    public function isValidPassword($passwd)
    {
        $decrypted = $this->getDI()->get('crypt')->decryptBase64($this->passwdHash);
        return $this->getDI()->get('security')->checkHash($passwd, $decrypted);
    }

    public function initialize()
    {
        parent::initialize();
        $this->addBehavior(new Timestampable([
            'beforeCreate' => ['field' => 'createdAt', 'format' => 'Y-m-d H:i:s'],
            'beforeSave' => ['field' => 'updatedAt', 'format' => 'Y-m-d H:i:s']
        ]));
        $this->skipAttributesOnUpdate(['id', 'createdAt']);
        $this->getEventsManager()->fire('coreModel:afterUserInitialize', $this);
    }

    public function getSource()
    {
        return 'CoreUser';
    }

    public function metaData()
    {
        return [
            MetaData::MODELS_ATTRIBUTES => [
                'id',
                'createdAt',
                'updatedAt',
                'email',
                'name',
                'externalId',
                'passwdHash',
                'active',
                'trash',
                'failedLoginAttempts',
                'failedLoginTs',
                'lastLoginTs',
                'lastLoginIp',
                'prefLang',
                'prefLocale',
                'prefTimezone',
            ],
            MetaData::MODELS_PRIMARY_KEY => [
                'id'
            ],
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'createdAt',
                'updatedAt',
                'email',
                'name',
                'externalId',
                'passwdHash',
                'active',
                'trash',
                'failedLoginAttempts',
                'failedLoginTs',
                'lastLoginTs',
                'lastLoginIp',
                'prefLang',
                'prefLocale',
                'prefTimezone',
            ],
            MetaData::MODELS_NOT_NULL => [
                'id',
                'createdAt',
                'updatedAt',
                'email',
                'name',
                'passwdHash',
                'active',
                'trash',
                'failedLoginAttempts',
                'failedLoginTs',
            ],
            MetaData::MODELS_DATA_TYPES => [
                'id' => Column::TYPE_INTEGER,
                'createdAt' => Column::TYPE_DATETIME,
                'updatedAt' => Column::TYPE_DATETIME,
                'email' => Column::TYPE_VARCHAR,
                'name' => Column::TYPE_VARCHAR,
                'externalId' => Column::TYPE_VARCHAR,
                'passwdHash' => Column::TYPE_VARCHAR,
                'active' => Column::TYPE_BOOLEAN,
                'trash' => Column::TYPE_BOOLEAN,
                'failedLoginAttempts' => Column::TYPE_INTEGER,
                'failedLoginTs' => Column::TYPE_INTEGER,
                'lastLoginTs' => Column::TYPE_INTEGER,
                'lastLoginIp' => Column::TYPE_VARCHAR,
                'prefLang' => Column::TYPE_CHAR,
                'prefLocale' => Column::TYPE_CHAR,
                'prefTimezone' => Column::TYPE_VARCHAR,
            ],
            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'id' => true,
                'failedLoginAttempts' => true,
                'failedLoginTs' => true,
                'lastLoginTs' => true,
            ],
            MetaData::MODELS_IDENTITY_COLUMN => 'id',
            MetaData::MODELS_DATA_TYPES_BIND => [
                'id' => Column::BIND_PARAM_INT,
                'createdAt' => Column::BIND_PARAM_STR,
                'updatedAt' => Column::BIND_PARAM_STR,
                'email' => Column::BIND_PARAM_STR,
                'name' => Column::BIND_PARAM_STR,
                'externalId' => Column::BIND_PARAM_STR,
                'passwdHash' => Column::BIND_PARAM_STR,
                'active' => Column::BIND_PARAM_BOOL,
                'trash' => Column::BIND_PARAM_BOOL,
                'failedLoginAttempts' => Column::BIND_PARAM_INT,
                'failedLoginTs' => Column::BIND_PARAM_INT,
                'lastLoginTs' => Column::BIND_PARAM_INT,
                'lastLoginIp' => Column::BIND_PARAM_STR,
                'prefLang' => Column::BIND_PARAM_STR,
                'prefLocale' => Column::BIND_PARAM_STR,
                'prefTimezone' => Column::BIND_PARAM_STR,
            ],
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [],
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [],
            MetaData::MODELS_DEFAULT_VALUES => [],
            MetaData::MODELS_EMPTY_STRING_VALUES => []
        ];
    }
}
