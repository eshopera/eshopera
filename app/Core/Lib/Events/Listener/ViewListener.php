<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Events\Listener;

use Eshopera\Core\Lib\ApplicationInterface;
use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use Phalcon\Assets\Filters;

/**
 * Listener for view events
 */
class ViewListener
{

    const TITLE_SEPARATOR = ' - ';

    /**
     * @var \Eshopera\Core\Lib\ApplicationInterface
     */
    private $application;

    /**
     * Dependency injection
     * @param \Eshopera\Core\Lib\ApplicationInterface $app
     */
    public function __construct(ApplicationInterface $application)
    {
        $this->application = $application;
    }

    /**
     * Register global variables and assets
     * @param  \Phalcon\Events\Event $event
     * @param  \Phalcon\Mvc\View $view
     * @return bool
     */
    public function beforeRender(Event $event, View $view)
    {
        $di = $this->application->getDI();

        $view->cdn = '/static';

        foreach ($modules as $module) {
            $module->registerUI($ui, $context);
        }

        if ($di->get('request')->isAjax()) {
            return true;
        }

        $assetsConfig = $this->application->getConfig()->assets;
        $rootDir = $this->application->getRootDir();
        $assets = $di->get('assets');

        $css = $assets->collection('css')
            ->setPrefix($assetsConfig->prefix)
            ->setSourcePath($rootDir . '/')
            ->setTargetPath($rootDir . '/public/static/css/app-' . $assetsConfig->cssVersion . '.css')
            ->setTargetUri('css/app-' . $assetsConfig->cssVersion . '.css')
            ->join(true);

        $js = $assets->collection('js')
            ->setPrefix($assetsConfig->prefix)
            ->setSourcePath($rootDir . '/')
            ->setTargetPath($rootDir . '/public/static/js/app-' . $assetsConfig->jsVersion . '.js')
            ->setTargetUri('js/app-' . $assetsConfig->jsVersion . '.js')
            ->join(true);

        $modules = $this->application->getAppModules();
        $context = $this->application->getContext();
        $ui = $di->get('ui');

        foreach ($modules as $module) {
            $module->registerAssets($assets, $context);
            $module->registerMenu($ui->get('menu'), $context);
        }

        if (empty($assetsConfig->minimize)) {
            $css->addFilter(new Filters\None());
            $js->addFilter(new Filters\None());
        } else {
            $css->addFilter(new Filters\Cssmin());
            $js->addFilter(new Filters\Jsmin());
        }

        $tag = $di->get('tag');

        $tag->setTitleSeparator(self::TITLE_SEPARATOR);
        $tag->appendTitle($this->application->getConfig()->name);

        if (!isset($view->bodyClass)) {
            $view->bodyClass = '';
        }
    }
}
