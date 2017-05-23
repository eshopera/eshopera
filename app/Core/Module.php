<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core;

use Eshopera\Core\Lib\Application\BaseModule;
use Eshopera\Core\Lib\DI\Service\Session;
use Eshopera\Core\Lib\DI\Service\Identity;
use Eshopera\Core\Lib\Http\AjaxResponse;
use Phalcon\DiInterface;
use Phalcon\Http\Response;

/**
 * Administration core module
 */
class Module extends BaseModule
{

    const MODULE_DIR = __DIR__;

    public function registerServices(DiInterface $di)
    {
        $di->set('response', function () use ($di) {
            if ($di->get('request')->isAjax()) {
                return new AjaxResponse();
            } else {
                return new Response();
            }
        }, true);

        $di->set('session', function () use ($di) {
            $config = $di->get('application')->getConfig();
            return new Session($di->get('request'), (empty($config->session) ? null : $config->session));
        }, true);

        $di->set('identity', function () use ($di) {
            return new Identity($di->get('session'));
        }, true);
    }
}
