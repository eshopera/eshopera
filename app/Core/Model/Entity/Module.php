<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Model\Entity;

use Eshopera\Core\Lib\Mvc\BaseModel;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 * Application module entity
 */
class Module extends BaseModel
{

    public $id;
    public $createdAt;
    public $updatedAt;
    public $version = '0.0.0';
    public $active = false;
    public $frontend = false;
    public $backend = false;
    public $api = false;

    public function initialize()
    {
        parent::initialize();
        $this->addBehavior(new Timestampable([
            'beforeCreate' => ['field' => 'createdAt', 'format' => 'Y-m-d H:i:s'],
            'beforeSave' => ['field' => 'updatedAt', 'format' => 'Y-m-d H:i:s']
        ]));
        $this->skipAttributesOnUpdate(['id', 'createdAt']);
        $this->getEventsManager()->fire('coreModel:afterModuleInitialize', $this);
    }

    public function getSource()
    {
        return 'CoreModule';
    }

    public function metaData()
    {
        return [
            MetaData::MODELS_ATTRIBUTES => [
                'id',
                'createdAt',
                'updatedAt',
                'version',
                'active',
                'frontend',
                'backend',
                'api',
            ],
            MetaData::MODELS_PRIMARY_KEY => [
                'id'
            ],
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'createdAt',
                'updatedAt',
                'version',
                'active',
                'frontend',
                'backend',
                'api',
            ],
            MetaData::MODELS_NOT_NULL => [
                'id',
                'createdAt',
                'updatedAt',
                'version',
                'active',
                'frontend',
                'backend',
                'api',
            ],
            MetaData::MODELS_DATA_TYPES => [
                'id' => Column::TYPE_VARCHAR,
                'createdAt' => Column::TYPE_DATETIME,
                'updatedAt' => Column::TYPE_DATETIME,
                'version' => Column::TYPE_VARCHAR,
                'active' => Column::TYPE_BOOLEAN,
                'frontend' => Column::TYPE_BOOLEAN,
                'backend' => Column::TYPE_BOOLEAN,
                'api' => Column::TYPE_BOOLEAN,
            ],
            MetaData::MODELS_DATA_TYPES_NUMERIC => [],
            MetaData::MODELS_IDENTITY_COLUMN => false,
            MetaData::MODELS_DATA_TYPES_BIND => [
                'id' => Column::BIND_PARAM_STR,
                'createdAt' => Column::BIND_PARAM_STR,
                'updatedAt' => Column::BIND_PARAM_STR,
                'version' => Column::BIND_PARAM_STR,
                'active' => Column::BIND_PARAM_BOOL,
                'frontend' => Column::BIND_PARAM_BOOL,
                'backend' => Column::BIND_PARAM_BOOL,
                'api' => Column::BIND_PARAM_BOOL,
            ],
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [],
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [],
            MetaData::MODELS_DEFAULT_VALUES => [],
            MetaData::MODELS_EMPTY_STRING_VALUES => []
        ];
    }
}
