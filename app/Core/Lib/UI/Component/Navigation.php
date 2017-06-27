<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component;

use Eshopera\Core\Lib\UI\Component;
use Eshopera\Core\Lib\UI\Component\Navigation\Section;
use Eshopera\Core\Lib\UI\Component\Navigation\Item;

/**
 * Navigation UI component
 */
class Navigation extends Component
{

    const DEFAULT_TEMPLATE = 'core/component/navigation';

    /**
     * Creates navigation component
     * @param  array $attributes - default null
     */
    public function __construct(array $attributes = null)
    {
        $this->setAttribute('class', 'nav');
        if ($attributes) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * Adds navigation section
     * @param  string $label
     * @param  string $id - default null
     * @param  array $attributes - default null
     * @return \Eshopera\Core\Lib\UI\Component\Navigation\Section
     */
    public function addSection(string $label, string $id = null, array $attributes = null)
    {
        return $this->add(new Section($label, $attributes), $id);
    }

    /**
     * Adds navigation item
     * @param  string $link
     * @param  string $label
     * @param  string $id - default null
     * @param  array $attributes - default null
     * @return \Eshopera\Core\Lib\UI\Component\Navigation\Item
     */
    public function addItem(string $link, string $label, string $id = null, array $attributes = null)
    {
        return $this->add(new Item($link, $label, $attributes), $id);
    }
}
