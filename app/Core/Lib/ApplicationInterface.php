<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib;

/**
 * Defines interface for all eshopera applications
 */
interface ApplicationInterface
{

    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION = 'production';
    const ENV_STAGING = 'staging';
    const ENV_TESTING = 'testing';
    const CONTEXT_FRONTEND = 'frontend';
    const CONTEXT_BACKEND = 'backend';
    const CONTEXT_API = 'api';

    /**
     * Initializes application
     * @return self
     */
    public function initialize();

    /**
     * Gets application context
     * @return string
     */
    public function getContext();

    /**
     * Gets application configuration
     * @return \Phalcon\Config
     */
    public function getConfig();

    /**
     * Loads application configuration
     * @param  string $configDir - default null
     * @return self
     * @thwows \Eshopera\Core\Lib\Exception\ApplicationException
     */
    public function loadConfig(string $configDir = null);

    /**
     * Checks if application has registered module of given alias
     * @param  string $alias
     * @return bool
     */
    public function hasAppModule(string $alias);

    /**
     * Gets application module
     * @param  string $alias
     * @return \Eshopera\Core\Lib\Application\ModuleInterface | null
     */
    public function getAppModule($alias);

    /**
     * Gets all application modules
     * @param  string $alias
     * @return \Eshopera\Core\Lib\Application\ModuleInterface[]
     */
    public function getAppModules();

    /**
     * Loads application modules
     * @param  string $configDir - default null
     * @return self
     * @thwows \Eshopera\Core\Lib\Exception\ApplicationException
     */
    public function loadAppModules(string $configDir = null);

    /**
     * Gets application environment
     * @return string
     */
    public function getEnv();

    /**
     * Sets application environment
     * @param  string $env
     * @return self
     * @thwows \Eshopera\Core\Lib\Exception\ApplicationException
     */
    public function setEnv(string $env);

    /**
     * Gets application root directory
     * @return string
     */
    public function getRootDir();

    /**
     * Sets application root directory
     * @param  string $rootDir
     * @return self
     */
    public function setRootDir(string $rootDir);

    /**
     * Gets application base URI
     * @return string
     */
    public function getBaseUri();

    /**
     * Gets application base path
     * @return string
     */
    public function getBasePath();
}
