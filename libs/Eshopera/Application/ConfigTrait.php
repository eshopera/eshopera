<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Application;

use Eshopera\ApplicationInterface;
use Eshopera\Exception\ApplicationException;
use Phalcon\Config\Adapter\Json;

/**
 * Application configuration
 */
trait ConfigTrait
{

    /**
     * @var string
     */
    private $env = ApplicationInterface::ENV_PRODUCTION;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * {@inheritdoc}
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnv(string $env)
    {
        $envs = [
            ApplicationInterface::ENV_PRODUCTION,
            ApplicationInterface::ENV_DEVELOPMENT,
            ApplicationInterface::ENV_STAGING,
            ApplicationInterface::ENV_TESTING
        ];

        if (!in_array($env, $envs)) {
            throw new ApplicationException('Invalid application environment "' . $env . '"');
        }

        $this->env = $env;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * {@inheritdoc}
     */
    public function setRootDir(string $rootDir)
    {
        $this->rootDir = $rootDir;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->errorReporting();
        $this->loadConfig();
    }

    private function errorReporting()
    {
        if ($this->env == ApplicationInterface::ENV_DEVELOPMENT || $this->env == ApplicationInterface::ENV_TESTING) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 'On');
            ini_set('display_startup_errors', 'On');
        }
    }

    private function loadConfig()
    {
        $configPath = $this->rootDir . '/config/app.json';

        if (!is_file($configPath)) {
            throw new ApplicationException('Configuration "config/app.json" does not exist');
        }

        $config = new Json($configPath);

        $envConfigPath = $this->rootDir . '/config/app.' . $this->env . '.json';

        if (is_file($envConfigPath)) {
            $config->merge(new Json($envConfigPath));
        }

        $this->getDI()->set('config', $config, true);
    }
}
