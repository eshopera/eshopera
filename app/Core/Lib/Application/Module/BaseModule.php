<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application\Module;

use Eshopera\Core\Lib\Application\ModuleInterface;
use Eshopera\Core\Lib\ApplicationInterface;
use Eshopera\Core\Lib\UI\Manager as UIManager;
use Eshopera\Core\Lib\UI\Component\Navigation;
use Phalcon\Di\Injectable;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\RouterInterface;
use Phalcon\Assets\Manager as AssetsManager;
use Phalcon\Text;

/**
 * Abstract module for creating eshopera modules
 */
abstract class BaseModule extends Injectable implements ModuleInterface
{

    const HAS_FRONTEND = false;
    const HAS_BACKEND = false;
    const HAS_API = false;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * Create new module
     * @param string $alias
     * @param \Phalcon\Config $config
     * @param \Phalcon\DiInterface $di
     */
    public function __construct(string $alias, Config $config, DiInterface $di)
    {
        $this->alias = $alias;
        $this->config = $config;
        $this->setDI($di);

        $ns = explode('\\', static::class);
        array_pop($ns);

        $this->namespace = implode('\\', $ns);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return static::MODULE_VER;
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function getDir()
    {
        return static::MODULE_DIR;
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
    public function hasContext(string $appContext)
    {
        if ($appContext == ApplicationInterface::CONTEXT_FRONTEND) {
            return static::HAS_FRONTEND;
        } elseif ($appContext == ApplicationInterface::CONTEXT_BACKEND) {
            return static::HAS_BACKEND;
        } elseif ($appContext == ApplicationInterface::CONTEXT_API) {
            return static::HAS_API;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerAutoloaders(DiInterface $di, string $appContext)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function registerServices(DiInterface $di, string $appContext)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function registerEventListeners(ManagerInterface $eventsManager, string $appContext)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function registerRoutes(RouterInterface $router, string $appContext)
    {
        if ($appContext == ApplicationInterface::CONTEXT_BACKEND) {
            $basePath = $this->getDI()->get('application')->getBasePath();
            $module = Text::uncamelize($this->alias, '-');
            $namespace = $this->namespace . '\\Controller\\Backend';
            $router->add($basePath . $module, [
                'namespace' => $namespace,
                'module' => $this->alias
            ]);
            $router->add($basePath . $module . '/:controller', [
                'namespace' => $namespace,
                'module' => $this->alias,
                'controller' => 1
            ]);
            $router->add($basePath . $module . '/:controller/:action', [
                'namespace' => $namespace,
                'module' => $this->alias,
                'controller' => 1,
                'action' => 2
            ]);
            $router->add($basePath . $module . '/:controller/:action/:params', [
                'namespace' => $namespace,
                'module' => $this->alias,
                'controller' => 1,
                'action' => 2,
                'params' => 3
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerAssets(AssetsManager $assetsManager, string $appContext)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function registerUI(UIManager $uiManager, string $appContext)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function registerMenu(Navigation $menu, string $appContext)
    {

    }
}
