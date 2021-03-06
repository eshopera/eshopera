<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Model;

/**
 * Validation interface for model
 */
interface ValidableInterface
{

    /**
     * Gets model validation
     * @return \Phalcon\ValidationInterface
     */
    public function getValidation();
}
