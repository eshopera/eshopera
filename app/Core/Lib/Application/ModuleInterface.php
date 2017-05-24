<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\RouterInterface;

/**
 * Interface for eshopera modules
 */
interface ModuleInterface extends ModuleDefinitionInterface
{

    /**
     * Gets unique module alias
     * @return string
     */
    public function getAlias();

    /**
     * Gets current module version
     * @return string
     */
    public function getVersion();

    /**
     * Gets module namespace
     * @return string
     */
    public function getNamespace();

    /**
     * Gets module directory path
     * @return string
     */
    public function getDir();

    /**
     * Gets module configuration
     * @return \Phalcon\Config
     */
    public function getConfig();

    /**
     * Register event listeners
     * @param \Phalcon\Events\ManagerInterface $eventsManager
     * @param string $appContext
     */
    public function registerEventListeners(ManagerInterface $eventsManager, string $appContext);

    /**
     * Register routes
     * @param \Phalcon\Mvc\RouterInterface $router
     * @param string $appContext - application context
     */
    public function registerRoutes(RouterInterface $router, string $appContext);

    /**
     * Gets module installer
     * @return \Eshopera\Core\Lib\Application\Module\InstallerInterface
     */
    public function getInstaller();
}
