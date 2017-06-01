<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\ApplicationInterface;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

/**
 * Backend aka admin application
 */
final class BackendApplication extends Application implements ApplicationInterface
{

    const CONTEXT = ApplicationInterface::CONTEXT_BACKEND;
    const DEFAULT_BASE_PATH = '/admin/';

    use ConfigTrait;
    use ModulesTrait;

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $di = $this->getDI();

        $this->setEventsManager($di->get('eventsManager'));

        $basePath = $this->getBasePath();

        $router = new Router(false);
        $router->setDefaultModule('core');
        $router->add('^(' . $basePath . '|' . rtrim($basePath, '/') . ')$', [
            'namespace' => 'Eshopera\\Core\\Controller\\Backend',
        ]);
        $router->notFound([
            'namespace' => 'Eshopera\\Core\\Controller\\Backend',
            'controller' => 'error',
            'action' => 'notFound'
        ]);

        $di->set('router', $router, true);
        $di->get('url')->setBaseUri($this->getBaseUri());

        return $this;
    }

    /**
     * Registers backend view
     * @return self
     */
    public function registerView()
    {
        $app = $this;

        $this->getDI()->set('view', function () use ($app) {
            $cfg = $app->getConfig();
            $view = new View();
            $dirs = [];
            foreach ($app->getAppModules() as $alias => $module) {
                $dirs[] = $module->getDir() . '/resources/backend/views';
            }
            $view->setViewsDir($dirs);
            $view->setEventsManager($this->getEventsManager());
            $view->registerEngines([
                '.volt' => function ($view, $di) use ($cfg) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions([
                        'compiledPath' => (empty($cfg->cacheDir) ? ROOT_DIR . '/temp/volt/' : $cfg->cacheDir),
                        'compiledSeparator' => '_',
                        'compileAlways' => (empty($cfg->compileAlways) ? false : $cfg->compileAlways),
                        'stat' => true
                    ]);
                    return $volt;
                }
            ]);
            return $view;
        });

        return $this;
    }
}
