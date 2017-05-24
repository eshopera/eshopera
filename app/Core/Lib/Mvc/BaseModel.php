<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc;

use Phalcon\Mvc\Model;
use Phalcon\Validation;

/**
 * Base model abstraction for all eshopera models
 */
abstract class BaseModel extends Model implements ExtendedModelInterface
{

    /**
     * {@inheritdoc}
     */
    public function getValidation()
    {
        return new Validation();
    }

    /**
     * Performs model validation
     * @return bool
     */
    public function validation()
    {
        return $this->validate($this->getValidation());
    }

    /**
     * Initialize model
     */
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
