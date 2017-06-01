<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

//use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\DiInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\RouterInterface;
use Phalcon\Assets\Manager as AssetsManager;

/**
 * Interface for eshopera modules
 */
interface ModuleInterface
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
     * Returns true if module works under given context
     * @return bool
     */
    public function hasContext(string $appContext);

    /**
     * Register autoloaders
     * @param \Phalcon\DiInterface $di
     * @param string $appContext
     */
    public function registerAutoloaders(DiInterface $di, string $appContext);

    /**
     * Register services
     * @param \Phalcon\DiInterface $di
     * @param string $appContext
     */
    public function registerServices(DiInterface $di, string $appContext);

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
     * Register assets
     * @param \Phalcon\Assets\Manager $assetsManager
     * @param string $appContext - application context
     */
    public function registerAssets(AssetsManager $assetsManager, string $appContext);

    /**
     * Gets module installer
     * @return \Eshopera\Core\Lib\Application\Module\InstallerInterface
     */
    public function getInstaller();
}
