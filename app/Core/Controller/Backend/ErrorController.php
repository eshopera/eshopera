<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Controller\Backend;

use Eshopera\Core\Lib\Mvc\BackendController;

/**
 * Backend error controller
 */
class ErrorController extends BackendController
{

    /**
     * No matching route found
     */
    public function notFoundAction()
    {
        $this->view->pick('core/index/index');
    }
}
