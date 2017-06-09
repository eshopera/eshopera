<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI;

use Phalcon\Mvc\User\Component as BaseComponent;

/**
 * Abstract UI component
 */
abstract class Component extends BaseComponent implements RenderableInterface
{

    /**
     * @var \Eshopera\Core\Lib\UI\Component[]
     */
    protected $components = [];

    /**
     * Add nested component
     * @param  \Eshopera\Core\Lib\UI\Component $component
     * @return self
     */
    public function add(Component $component)
    {
        $this->components[] = $component;
        return $this;
    }
}
