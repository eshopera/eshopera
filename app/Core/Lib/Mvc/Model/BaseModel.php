<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Model;

use Eshopera\Core\Lib\Mvc\ExtendedModelInterface;
use Phalcon\Mvc\Model;
use Phalcon\Validation;

/**
 * Base model abstraction for all eshopera models
 */
abstract class BaseModel extends Model implements ExtendedModelInterface, ValidableInterface
{

    const PK_FIELDS_DELIMITER = '--';

    /**
     * {@inheritdoc}
     */
    public function getValidation()
    {
        return new Validation();
    }

    /**
     * Performs model validation
     * @return bool
     */
    public function validation()
    {
        return $this->validate($this->getValidation());
    }

    /**
     * {@inheritdoc}
     */
    public function getPk()
    {
        $attrs = $this->getModelsMetaData()->getPrimaryKeyAttributes($this);

        if (count($attrs) == 1) {
            return $this->{$attrs[0]};
        }

        $parts = [];

        foreach ($attrs as $attr) {
            $parts[] = $this->{$attr};
        }

        return implode(self::PK_FIELDS_DELIMITER, $parts);
    }

    /**
     * {@inheritdoc}
     */
    public static function findFirstByPk(string $pk, bool $forUpdate = false)
    {
        $attrs = $this->getModelsMetaData()->getPrimaryKeyAttributes($this);

        $conditions = [];
        $bind = [];

        $parts = explode(self::PK_FIELDS_DELIMITER, $pk);

        foreach ($attrs as $i => $attr) {
            if (isset($parts[$i])) {
                $conditions[] = $attr . ' = :' . $attr . ':';
                $bind[$attr] = $parts[$i];
            } else {
                $conditions[] = $attr . ' IS NULL';
            }
        }

        return self::findFirst([
                'conditions' => implode(' AND ', $conditions),
                'bind' => $bind,
                'for_update' => $forUpdate
        ]);
    }

    /**
     * Initialize model
     */
    public function initialize()
    {
        $this->useDynamicUpdate(true);
        $this->setEventsManager($this->getDI()->get('eventsManager'));
    }
}
