<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\ApplicationInterface;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\RouterInterface;

/**
 * Abstract module for creating eshopera modules
 */
abstract class BaseModule implements ModuleInterface, InjectionAwareInterface
{

    /**
     * @var string
     */
    protected $alias;

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
        $this->di = $di;
    }

    /**
     * Returns the internal dependency injector
     * @return \Phalcon\DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * Sets the dependency injector
     * @param  \Phalcon\DiInterface $di
     * @return self
     */
    public function setDI(DiInterface $di)
    {
        $this->di = $di;
        return $this;
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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getDir()
    {
        return realpath(__DIR__);
    }

    /**
     * {@inheritdoc}
     */
    public function registerAutoloaders(DiInterface $di = null)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function registerServices(DiInterface $di)
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
        if ($appContext == ApplicationInterface::CONTEXT_FRONTEND) {

        } elseif ($appContext == ApplicationInterface::CONTEXT_BACKEND) {

        }
    }
}
