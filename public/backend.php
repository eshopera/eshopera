<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Config\Adapter\Json;
use Eshopera\Core\Lib\ApplicationInterface;
use Eshopera\Core\Lib\Application\BackendApplication;

// root directory
define('ROOT_DIR', realpath(dirname(__DIR__)));

// loader
$loader = new Loader();
$loader->registerFiles([
    ROOT_DIR . '/vendor/autoload.php'
])->registerNamespaces([
    'Eshopera' => ROOT_DIR . '/app',
    'EshoperaPlugin' => ROOT_DIR . '/plugin',
])->register();

// DI container
$di = new FactoryDefault();

// add loader do DI
$di->set('loader', $loader, true);

// backend application
$application = new BackendApplication($di);
$application->setEventsManager($di->get('eventsManager'));

// add application to di
$di->set('application', $application, true);

if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application->setEnv(ApplicationInterface::ENV_DEVELOPMENT);
}

try {
    $application->setRootDir(ROOT_DIR)
        ->loadConfig()
        ->initialize()
        ->loadAppModules()
        ->registerView();
    echo $application->handle()->getContent();
} catch (\Exception $ex) {

    if ($di->has('logger')) {
        $di->get('logger')->critical(
            get_class($ex) . ': ' . $ex->getMessage() . ' at ' . $ex->getFile() .
            ':' . $ex->getLine() . ', exiting with status 503'
        );
    }

    header('HTTP/1.1 503 Service Unavailable', true, 503);
    header('Retry-After: 600');

    // display exception on development env
    if ($application->getEnv() == ApplicationInterface::ENV_DEVELOPMENT) {
        var_dump($ex);
    }
}