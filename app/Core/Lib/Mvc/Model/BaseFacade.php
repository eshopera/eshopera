<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Model;

use Phalcon\Di\Injectable;
use Phalcon\DiInterface;

/**
 * Base model facade
 */
abstract class BaseFacade extends Injectable
{

    /**
     * @var \Eshopera\Core\Lib\ApplicationInterface
     */
    protected $application;

    /**
     * @var \Phalcon\Translate\AdapterInterface
     */
    protected $translate;

    /**
     * Creates new facade
     * @param \Phalcon\DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->setDI($di);
        $this->application = $di->get('application');
        $this->translate = $di->get('translate');
    }
}
