<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\ApplicationInterface;
use Eshopera\Core\Lib\Tag;
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
            foreach ($app->getAppModules() as $module) {
                $dirs[] = $module->getDir() . '/resources/backend/views';
            }
            $view->setViewsDir($dirs);
            $view->setEventsManager($this->getEventsManager());
            $view->disableLevel([View::LEVEL_LAYOUT => true]);
            $view->registerEngines([
                '.volt' => function ($view, $di) use ($cfg) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions([
                        'compiledPath' => (empty($cfg->cacheDir) ? ROOT_DIR . '/temp/volt/' : $cfg->cacheDir),
                        'compiledSeparator' => '_',
                        'compileAlways' => (empty($cfg->compileAlways) ? true : $cfg->compileAlways),
                        'stat' => true
                    ]);

                    // adding translate support to volt
                    $compiler = $volt->getCompiler();
                    $compiler->addFunction(
                        '_', function ($resolvedArgs, $exprArgs) {
                            return 'Eshopera\Core\Lib\Tag::_(' . $resolvedArgs . ')';
                        });
                    $compiler->addFunction(
                        'cutstr', function ($resolvedArgs, $exprArgs) {
                            return 'Eshopera\Core\Lib\Tag::cutstr(' . $resolvedArgs . ')';
                        });

                    Tag::setDI($di);

                    return $volt;
                }
            ]);
            return $view;
        });

        return $this;
    }
}
