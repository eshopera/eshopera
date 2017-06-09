<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Controller\Backend;

use Eshopera\Core\Lib\Mvc\Controller\BackendController;

/**
 * Backend default controller
 */
class IndexController extends BackendController
{

    public function indexAction()
    {
        $this->view->bodyClass = 'app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden';
    }
}
