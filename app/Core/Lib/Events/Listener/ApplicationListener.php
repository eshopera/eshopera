<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Events\Listener;

use Eshopera\Core\Lib\ApplicationInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\ViewInterface;

/**
 * Listener for application events
 */
class ApplicationListener
{

    /**
     * @var \Phalcon\Mvc\Dispatcher
     */
    private $dispatcher;

    /**
     * Dependency injection
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Add module path to view render
     * @param  \Phalcon\Events\Event $event
     * @param  \Eshopera\Core\Lib\ApplicationInterface $app
     * @param  \Phalcon\Mvc\ViewInterface $view
     * @return boolean
     */
    public function viewRender(Event $event, ApplicationInterface $app, ViewInterface $view)
    {
        $path = $this->dispatcher->getModuleName() . '/' . $this->dispatcher->getControllerName();
        $view->render($path, $this->dispatcher->getActionName(), $this->dispatcher->getParams());
        return false;
    }
}
