<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera;

/**
 * Defines interface for all eshopera applications
 */
interface ApplicationInterface
{

    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION = 'production';
    const ENV_STAGING = 'staging';
    const ENV_TESTING = 'testing';

    /**
     * Registers application services to DI container
     * @return \Eshopera\ApplicationInterface
     * @thwows \Eshopera\Exception\ApplicationException
     */
    public function registerServices();

    /**
     * Builds config and configures application
     * @return \Eshopera\ApplicationInterface
     * @thwows \Eshopera\Exception\ApplicationException
     */
    public function configure();

    /**
     * Gets application environment
     * @return string
     */
    public function getEnv();

    /**
     * Sets application environment
     * @param  string $env
     * @return \Eshopera\ApplicationInterface
     * @thwows \Eshopera\Exception\ApplicationException
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
     * @return \Eshopera\ApplicationInterface
     */
    public function setRootDir(string $rootDir);
}
