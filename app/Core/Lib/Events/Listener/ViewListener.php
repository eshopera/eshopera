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

    public function beforeView()
    {
        echo 'asdf';
        die;
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

        if ($di->get('request')->isAjax()) {
            return true;
        }

        $modules = $this->application->getAppModules();
        $context = $this->application->getContext();
        $assets = $di->get('assets');

        foreach ($modules as $module) {
            $module->registerAssets($assets, $context);
        }

        $tag = $di->get('tag');

        $tag->setTitleSeparator(self::TITLE_SEPARATOR);
        $tag->appendTitle($this->application->getConfig()->name);
    }
}
