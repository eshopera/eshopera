<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc;

use Phalcon\Mvc\ModelInterface;

/**
 * Extended model interface for models
 */
interface ExtendedModelInterface extends ModelInterface
{

    /**
     * Gets string representation of model primary key
     * @return string
     */
    public function getPk();

    /**
     * Finds first record by string representation of primary key
     * @param  string $pk
     * @param  bool $forUpdate - default false
     * @return \Eshopera\Core\Lib\Mvc\Model\BaseModel | null
     */
    public static function findFirstByPk(string $pk, bool $forUpdate = false);
}
