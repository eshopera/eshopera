<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc;

use Phalcon\Mvc\ModelInterface;

/**
 * Extended interface for model
 */
interface ExtendedModelInterface extends ModelInterface
{

    /**
     * Gets model validation
     * @return \Phalcon\ValidationInterface
     */
    public function getValidation();
}
