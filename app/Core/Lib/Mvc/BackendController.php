<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\DispatcherInterface;

/**
 * Backend base controller
 */
class BackendController extends Controller
{

    /**
     * @var \Eshopera\Core\Lib\ApplicationInterface
     */
    protected $application;

    /**
     * @var \Eshopera\Core\Lib\DI\Service\Identity
     */
    protected $user;

    /**
     * @var \Phalcon\Translate\AdapterInterface
     */
    protected $translate;

    /**
     * Initialize controller attributes
     */
    public function onConstruct()
    {
        $di = $this->getDI();
        $this->application = $di->get('application');
        $this->user = $di->get('user');
        $this->translate = $di->get('translate');
    }

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
        if ($this->user->isLoggedIn()) {
            return true;
        }

        $dispatcher->setReturnedValue($this->response->redirect($this->url->get('core/auth'), true));

        return false;
    }
}
