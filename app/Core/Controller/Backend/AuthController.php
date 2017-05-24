<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Controller\Backend;

use Eshopera\Core\Lib\Mvc\BackendController;

/**
 * Backend authorization controller
 */
class AuthController extends BackendController
{

    /**
     * Login page
     */
    public function indexAction()
    {
        var_dump($this->getDI()->get('session')->get('aaa', 'a'));
        die;
    }
}
