<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Controller\Backend;

use Eshopera\Core\Lib\Mvc\Controller\BackendController;
use Eshopera\Core\Lib\Exception\ApplicationException;
use Phalcon\Text;

/**
 * Backend CRUD controller
 */
abstract class CrudController extends BackendController
{

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var string - unique alias
     */
    protected $alias;

    /**
     * Properties init
     */
    public function initialize()
    {
        $this->moduleName = $this->dispatcher->getModuleName();
        $this->controllerName = $this->dispatcher->getControllerName();
        $this->alias = Text::camelize($this->moduleName . '-' . $this->controllerName, '-_');
    }

    /**
     * Module list
     */
    public function indexAction()
    {
        $dataGrid = $this->dataGridFactory->create($this->moduleName, $this->controllerName);
        $dataGrid->appendAttribute('class', 'mb-0');

        $title = $this->translate->t(strtoupper($this->moduleName) . '_' . strtoupper($this->controllerName));

        $this->tag->prependTitle($title);

        $this->view->dataGrid = $dataGrid;
        $this->view->title = $title;
        $this->view->bodyClass = 'app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden';

        $this->ui->breadcrumb->addItem($this->url->get(''), $this->translate->t('CORE_NAV_HOME'));
        $this->ui->breadcrumb->addItem($this->url->get($this->moduleName . '/' . $this->controllerName), $title);
    }

    /**
     *
     * @return
     * @throws \Eshopera\Core\Lib\Exception\ApplicationException
     */
    protected function getFacade()
    {
        $di = $this->getDI();

        if ($di->has('facade' . $this->alias)) {
            return $di->get('facade' . $this->alias);
        }

        throw new ApplicationException('Facade "facade' . $this->alias . '" not found');
    }
}
