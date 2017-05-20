<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
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
class BackendController extends Controller
{

    /**
     * Checks privileged access
     * @param  \Phalcon\Mvc\DispatcherInterface $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(DispatcherInterface $dispatcher)
    {
        echo 'BackencController';
        die;
    }
}
