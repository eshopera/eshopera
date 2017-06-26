<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\DispatcherInterface;

/**
 * Backend base controller
 */
abstract class BackendController extends Controller
{

    /**
     * Checks privileged access
     * @param  \Phalcon\Mvc\DispatcherInterface $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(DispatcherInterface $dispatcher)
    {
        // allow access for core auth controller
        if ($dispatcher->getModuleName() == 'core' && $dispatcher->getControllerName() == 'auth') {
            return true;
        }

        // allow authenticated user
        if ($this->getDI()->get('user')->isLoggedIn()) {
            return true;
        }

        $dispatcher->setReturnedValue($this->response->redirect($this->url->get('core/auth'), true));

        return false;
    }
}
