<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\ApplicationInterface;
use Eshopera\Core\Lib\Exception\ApplicationException;
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
     * @var \Phalcon\Config
     */
    private $config;

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return self::CONTEXT;
    }

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
        $this->errorReporting();

        return $this;
    }

    /**
     * Sets error reporting level depending current environment
     */
    private function errorReporting()
    {
        if ($this->env == ApplicationInterface::ENV_DEVELOPMENT || $this->env == ApplicationInterface::ENV_TESTING) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 'On');
            ini_set('display_startup_errors', 'On');
        }
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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function loadConfig(string $configDir = null)
    {
        if ($configDir) {
            $configPath = rtrim($configDir, '/') . '/app.json';
            $envConfigPath = rtrim($configDir, '/') . '/app.' . $this->env . '.json';
        } else {
            $configPath = $this->rootDir . '/config/app.json';
            $envConfigPath = $this->rootDir . '/config/app.' . $this->env . '.json';
        }

        if (!is_file($configPath)) {
            throw new ApplicationException('Configuration "config/app.json" does not exist');
        }

        $this->config = new Json($configPath);

        if (is_file($envConfigPath)) {
            $this->config->merge(new Json($envConfigPath));
        }

        return $this;
    }
}
