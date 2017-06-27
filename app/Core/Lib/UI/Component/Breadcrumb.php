<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component;

use Eshopera\Core\Lib\UI\Component;
use Eshopera\Core\Lib\UI\Component\Breadcrumb\Item;

/**
 * Breadcrumb UI component
 */
class Breadcrumb extends Component
{

    const DEFAULT_TEMPLATE = 'core/component/breadcrumb';
    const DEFAULT_CLASS = 'breadcrumb';

    /**
     * Creates breadcrumb component
     * @param  array $attributes - default null
     */
    public function __construct(array $attributes = null)
    {
        $this->setAttribute('class', self::DEFAULT_CLASS);
        if ($attributes) {
            $this->setAttributes($attributes);
        }
        $this->beforeRender(function($component) {
            $cnt = count($component);
            if ($cnt > 0) {
                $component[($cnt - 1)]->setActive();
            }
        });
    }

    /**
     * Adds navigation item
     * @param  string $link
     * @param  string $label
     * @param  array $attributes - default null
     * @return \Eshopera\Core\Lib\UI\Component\Breadcrumb\Item
     */
    public function addItem(string $link, string $label, array $attributes = null)
    {
        return $this->add(new Item($link, $label, $attributes));
    }
}
