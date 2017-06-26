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
 * Navigation item component
 */
class Item extends Component
{

    use Component\Traits\AttributesTrait;

    const DEFAULT_TEMPLATE = 'core/component/navigation/item';
    const DEFAULT_LINK_CLASS = 'nav-link';

    /**
     * @var string
     */
    public $link;

    /**
     * @var string
     */
    public $label;

    /**
     * @var bool
     */
    public $active = false;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $linkClass = self::DEFAULT_LINK_CLASS;

    /**
     * Creates new navigation item
     * @param string $link
     * @param string $label
     * @param  array $attributes - default NULL
     */
    public function __construct(string $link, string $label, array $attributes = NULL)
    {
        $this->link = $link;
        $this->label = $label;
        $this->setAttribute('class', 'nav-item');

        if ($attributes) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * Sets link active
     * @return self
     */
    public function setActive()
    {
        $this->active = true;
        return $this;
    }

    /**
     * Sets item icon
     * @param  string $icon
     * @return self
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Sets item link class
     * @param  string $class
     * @return self
     */
    public function setLinkClass(string $class)
    {
        $this->linkClass = $class;
        return $this;
    }
}
