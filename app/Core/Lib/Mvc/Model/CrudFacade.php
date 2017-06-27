<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Model;

use Eshopera\Core\Lib\Exception\ApplicationException;
use Phalcon\DiInterface;
use Phalcon\Text;

/**
 * CRUD model facade
 */
class CrudFacade extends BaseFacade implements CrudFacadeInterface
{

    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * Creates new facade
     * @param string $moduleName
     * @param string $controllerName
     * @param \Phalcon\DiInterface $di
     */
    public function __construct(string $moduleName, string $controllerName, DiInterface $di)
    {
        parent::__construct($di);

        $module = $this->application->getAppModule($moduleName);

        if (empty($module)) {
            throw new ApplicationException('Module "' . $moduleName . '" not found');
        }

        $this->className = $module->getNamespace() . '\\Model\\Entity\\' . Text::camelize($controllerName);

        if (!class_exists($this->className)) {
            throw new ApplicationException('Class "' . $this->className . '" not found');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function newEntity()
    {
        return new $this->className();
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        return $this->className::query();
    }

    /**
     * {@inheritdoc}
     */
    public function findFirstByPk(string $pk, bool $forUpdate = false)
    {
        return $this->className::findFirstByPk($pk, $forUpdate);
    }
}
