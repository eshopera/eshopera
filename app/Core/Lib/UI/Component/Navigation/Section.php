<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component\Navigation;

use Eshopera\Core\Lib\UI\Component;

/**
 * Navigation section component
 */
class Section extends Component
{

    const DEFAULT_TEMPLATE = 'core/component/navigation/section';
    const DEFAULT_CLASS = 'nav-item nav-dropdown';
    const DEFAULT_LINK_CLASS = 'nav-link nav-dropdown-toggle';
    const DEFAULT_ITEMS_CLASS = 'nav-dropdown-items';

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $linkClass = self::DEFAULT_LINK_CLASS;

    /**
     * @var string
     */
    public $itemsClass = self::DEFAULT_ITEMS_CLASS;

    /**
     * Creates new navigation section
     * @param string $label
     * @param  array $attributes - default NULL
     */
    public function __construct(string $label, array $attributes = NULL)
    {
        $this->label = $label;
        $this->setAttribute('class', self::DEFAULT_CLASS);
        if ($attributes) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * Sets section as active
     * @return self
     */
    public function setActive()
    {
        $this->appendAttribute('class', 'open');
        return $this;
    }

    /**
     * Sets section icon
     * @param  string $icon
     * @return self
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Sets section link class
     * @param  string $class
     * @return self
     */
    public function setLinkClass(string $class)
    {
        $this->linkClass = $class;
        return $this;
    }

    /**
     * Sets section items class
     * @param  string $class
     * @return self
     */
    public function setItemsClass(string $class)
    {
        $this->itemsClass = $class;
        return $this;
    }

    /**
     * Adds navigation section
     * @param  string $label
     * @param  string $id - default NULL
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\Navigation\Section
     */
    public function addSection(string $label, string $id = null, array $attributes = null)
    {
        return $this->add(new self($label, $attributes), $id);
    }

    /**
     * Adds navigation item
     * @param  string $link
     * @param  string $label
     * @param  string $id - default NULL
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\Navigation\Item
     */
    public function addItem(string $link, string $label, string $id = null, array $attributes = NULL)
    {
        return $this->add(new Item($link, $label, $attributes), $id);
    }
}
