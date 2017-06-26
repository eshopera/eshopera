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
abstract class Component extends BaseComponent implements RenderableInterface, \Iterator, \ArrayAccess
{

    const DEFAULT_TEMPLATE = '';

    /**
     * @var \Eshopera\Core\Lib\UI\Component[]
     */
    protected $components = [];

    /**
     * @var string custom template path
     */
    protected $template;

    /**
     * Checks if component has children
     * @return bool
     */
    public function hasChildren()
    {
        return (empty($this->components) ? false : true);
    }

    /**
     * Add nested component
     * @param  \Eshopera\Core\Lib\UI\Component $component
     * @param  string $index
     * @return \Eshopera\Core\Lib\UI\Component
     */
    public function add(Component $component, string $index = null)
    {
        if (is_null($index)) {
            $this->components[] = $component;
        } else {
            $this->components[$index] = $component;
        }
        return $component;
    }

    /**
     * Gets component template file
     * @return string
     */
    public function getTemplate()
    {
        if ($this->template) {
            return $this->template;
        } else {
            return static::DEFAULT_TEMPLATE;
        }
    }

    /**
     * Sets component template file
     * @param  string $template
     * @return self
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->view->getPartial($this->getTemplate(), ['component' => $this]);
    }

    /**
     * Returns string representation of the component
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Returns current nested component
     * @return mixed
     */
    public function current()
    {
        return current($this->components);
    }

    /**
     * Returns key of current nested component
     * @return scalar
     */
    public function key()
    {
        return key($this->components);
    }

    /**
     * Move forward to next nested component
     */
    public function next()
    {
        next($this->components);
    }

    /**
     * Rewind internal iterator to the first nested component
     */
    public function rewind()
    {
        reset($this->components);
    }

    /**
     * Checks if current position is valid
     * @return bool
     */
    public function valid()
    {
        return key($this->components) !== null;
    }

    /**
     * Checks whether an offset exists
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->components[$offset]);
    }

    /**
     * Unsets an offset
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if (isset($this->components[$offset])) {
            unset($this->components[$offset]);
        }
    }

    /**
     * Returns the subcomponent at specified offset
     * @param  mixed $offset
     * @return \Eshopera\Core\Lib\UI\Component
     */
    public function offsetGet($offset)
    {
        return (isset($this->components[$offset]) ? $this->components[$offset] : null);
    }

    /**
     * Assigns a component to the specified offset
     * @param mixed $offset
     * @param \Eshopera\Core\Lib\UI\Component $component
     */
    public function offsetSet($offset, $component)
    {
        if (is_null($offset)) {
            $this->components[] = $component;
        } else {
            $this->components[$offset] = $component;
        }
    }
}
