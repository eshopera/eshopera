<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component\Breadcrumb;

use Eshopera\Core\Lib\UI\Component;

/**
 * Breadcrumb item component
 */
class Item extends Component
{

    const DEFAULT_TEMPLATE = 'core/component/breadcrumb/item';
    const DEFAULT_CLASS = 'breadcrumb-item';

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
     * Creates new navigation item
     * @param string $link
     * @param string $label
     * @param  array $attributes - default NULL
     */
    public function __construct(string $link, string $label, array $attributes = NULL)
    {
        $this->link = $link;
        $this->label = $label;
        $this->setAttribute('class', self::DEFAULT_CLASS);

        if ($attributes) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * Sets item inactive
     * @return self
     */
    public function setActive()
    {
        $this->active = true;
        $this->appendAttribute('class', 'active');
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
}
