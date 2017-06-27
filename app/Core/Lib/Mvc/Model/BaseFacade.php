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
     * Creates new facade
     * @param \Phalcon\DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->setDI($di);
        $this->setEventsManager($di->get('eventsManager'));
    }
}
