<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Mvc\Model;

use Eshopera\Core\Lib\Mvc\Model\BaseModel;

/**
 * Interface for model crud facade
 */
interface CrudFacadeInterface
{

    /**
     * Creates new entity
     * @return \Eshopera\Core\Lib\Mvc\ExtendedModelInterface
     */
    public function newEntity();

    /**
     * Creates new model query
     * @return \Phalcon\Mvc\Model\CriteriaInterface
     */
    public function query();

    /**
     * Finds first entity by its primary key
     * @param string $pk
     * @return \Eshopera\Core\Lib\Mvc\Model\BaseModel | null
     */
    public function findFirstByPk($pk);

    /**
     * Creates new entity
     * @param \Eshopera\Core\Lib\Mvc\Model\BaseModel $entity
     */
    public function create(BaseModel $entity);

    /**
     * Updates existing entity
     * @param \Eshopera\Core\Lib\Mvc\Model\BaseModel $entity
     */
    public function update(BaseModel $entity);
}
