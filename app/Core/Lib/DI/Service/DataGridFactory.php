<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\DI\Service;

use Eshopera\Core\Lib\ApplicationInterface;
use Eshopera\Core\Lib\Exception\ApplicationException;
use Phalcon\Text;

/**
 * Factory for creating data grid objects
 */
class DataGridFactory
{

    /**
     * @var \Eshopera\Core\Lib\ApplicationInterface
     */
    private $application;

    /**
     * Dependency injection
     * @param \Eshopera\Core\Lib\ApplicationInterface
     */
    public function __construct(ApplicationInterface $application)
    {
        $this->application = $application;
    }

    /**
     * Creates data grid for given module and controller
     * @param  string $moduleName
     * @param  string $controllerName
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid
     * @throws \Eshopera\Core\Lib\Exception\ApplicationException
     */
    public function create(string $moduleName, string $controllerName)
    {
        $module = $this->application->getAppModule($moduleName);

        if (empty($module)) {
            throw new ApplicationException('Module "' . $moduleName . '" not found');
        }

        $className = $module->getNamespace()
            . '\\DataGrid\\'
            . ucfirst($this->application->getContext())
            . '\\' . Text::camelize($controllerName) . 'DataGrid';

        if (!class_exists($className)) {
            throw new ApplicationException('Class "' . $className . '" not found');
        }

        return new $className();
    }
}
