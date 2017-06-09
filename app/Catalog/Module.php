<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Catalog;

use Eshopera\Core\Lib\Application\Module\BaseModule;

/**
 * Product catalog module
 */
class Module extends BaseModule
{

    const MODULE_DIR = __DIR__;
    const MODULE_VER = '1.0';

    /**
     * {@inheritdoc}
     */
    public function getInstaller()
    {
        return new Installer($this, $this->getDI()->get('db'));
    }
}
