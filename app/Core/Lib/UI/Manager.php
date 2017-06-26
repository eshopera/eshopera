<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI;

use Eshopera\Core\Lib\Exception\UIException;
use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;

/**
 * UI components manager
 */
class Manager implements InjectionAwareInterface, EventsAwareInterface
{

    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;

    /**
     * @var \Phalcon\Events\ManagerInterface
     */
    protected $eventsManager;

    /**
     * @var array
     */
    protected $definitions = [];

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * Gets internal dependency injector
     * @param  \Phalcon\DiInterface $di
     * @return self
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * Sets internal dependency injector
     * @param  \Phalcon\DiInterface $di
     * @return self
     */
    public function setDI(DiInterface $di)
    {
        $this->di = $di;
        return $this;
    }

    /**
     * Gets internal events manager
     * @return \Phalcon\Events\ManagerInterface
     */
    public function getEventsManager()
    {
        return $this->eventsManager;
    }

    /**
     * Sets internal events manager
     * @param  \Phalcon\Events\ManagerInterface $eventsManager
     * @return self
     */
    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->eventsManager = $eventsManager;
        return $this;
    }

    /**
     * Magic getter
     * @param  string $name
     * @return \Eshopera\Core\Lib\UI\Component
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Gets UI component of given name
     * @param  string $name
     * @return \Eshopera\Core\Lib\UI\Component
     * @throws \Eshopera\Core\Lib\Exception\UIException
     */
    public function get(string $name)
    {
        if (!isset($this->definitions[$name])) {
            throw new UIException('Component "' . $name . '" is not registered');
        }

        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        $instance = $this->definitions[$name]();

        if ($instance instanceof Component) {
            $instance->setDI($this->di);
            $instance->setEventsManager($this->eventsManager);
        } else {
            throw new UIException('Component "' . $name . '" is not valid UI component');
        }

        $this->instances[$name] = $instance;

        return $instance;
    }

    /**
     * Sets UI component definition
     * @param  string $name
     * @param  \Closure $definition
     * @return self
     */
    public function set(string $name, \Closure $definition)
    {
        $this->definitions[$name] = $definition;
        return $this;
    }

    /**
     * Checks if UI component is registered
     * @param  string $name
     * @return bool
     */
    public function has(string $name)
    {
        return isset($this->definitions[$name]);
    }
}
