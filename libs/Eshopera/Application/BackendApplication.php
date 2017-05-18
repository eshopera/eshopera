<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Application;

use Eshopera\ApplicationInterface;
use Phalcon\Mvc\Application;

/**
 * Backend aka admin application
 */
class BackendApplication extends Application implements ApplicationInterface
{

    use ConfigTrait;
    use ServicesTrait;
}
