<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\Exception\ApplicationException;
use Phalcon\Config;
use Phalcon\Config\Adapter\Json;
use Phalcon\Text;

/**
 * Application modules registration
 */
trait ModulesTrait
{

    /**
     * @var array
     */
    private $appModules;

    /**
     * {@inheritdoc}
     */
    public function hasAppModule(string $alias)
    {
        $alias = $this->normalizeAppModuleAlias($alias);
        return (empty($this->appModules[strtolower($alias)]) ? false : true);
    }

    /**
     * {@inheritdoc}
     */
    public function getAppModule($alias)
    {
        $alias = $this->normalizeAppModuleAlias($alias);

        if (isset($this->appModules[$module])) {
            return $this->appModules[$module];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppModules()
    {
        return $this->appModules;
    }

    /**
     * {@inheritdoc}
     */
    public function loadAppModules(string $configDir = null)
    {
        if ($configDir) {
            $configPath = rtrim($configPath, '/') . '/modules.' . self::CONTEXT . '.json';
        } else {
            $configPath = $this->rootDir . '/config/modules.' . self::CONTEXT . '.json';
        }

        if (!is_file($configPath)) {
            throw new ApplicationException('Missing configuration "config/modules.' . self::CONTEXT . '.json"');
        }

        $this->registerAppModule('core', $this->config);

        $modules = new Json($configPath);

        foreach ($modules as $name => $config) {
            $this->registerAppModule($name, $config);
        }

        $this->registerPhalconModules();

        return $this;
    }

    /**
     * Registers concrete module
     * @param string $name
     * @param \Phalcon\Config $config
     */
    private function registerAppModule(string $name, Config $config)
    {
        $alias = $this->normalizeAppModuleAlias($name);

        if (empty($config->class)) {
            $moduleClass = 'Eshopera\\' . Text::camelize($name) . '\\Module';
        } else {
            $moduleClass = $config->class;
        }

        $di = $this->getDI();

        $module = new $moduleClass($alias, $config, $di);
        $module->registerAutoloaders($di);
        $module->registerServices($di);
        $module->registerEventListeners($di->get('eventsManager'), self::CONTEXT);
        $module->registerRoutes($di->get('router'), self::CONTEXT);

        $this->appModules[$alias] = $module;

        $di->set($alias . 'Module', $module, true);
    }

    /**
     * Register modules to phalcon application
     */
    private function registerPhalconModules()
    {
        $defs = [];

        foreach ($this->appModules as $alias => $module) {
            $defs[$alias] = function () use ($module) {
                return $module;
            };
        }

        $this->registerModules($defs);
    }

    /**
     * Normalizes module alias
     * @param  string $alias
     * @return string
     */
    private function normalizeAppModuleAlias(string $alias)
    {
        return strtolower($alias);
    }
}
