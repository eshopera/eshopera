<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\ApplicationInterface;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;

/**
 * Backend aka admin application
 */
final class BackendApplication extends Application implements ApplicationInterface
{

    const CONTEXT = ApplicationInterface::CONTEXT_BACKEND;

    use ConfigTrait;
    use ModulesTrait;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $router = new Router(false);
        $router->setDefaultModule('core');
        $this->getDI()->set('router', $router, true);
        return $this;
    }
}
