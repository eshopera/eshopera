<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component\Traits;

/**
 * Component HTML attributes
 */
trait AttributesTrait
{

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Sets HTML attribute
     * @param  string $name
     * @param  string $value
     * @return self
     */
    public function setAttribute(string $name, string $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Append value to given HTML attribute
     * @param  string $name
     * @param  string $value
     * @return self
     */
    public function appendAttribute(string $name, string $value)
    {
        if (empty($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        } else {
            $this->attributes[$name] .= ' ' . $value;
        }
        return $this;
    }

    /**
     * Sets HTML attributes
     * @param  array $attribs
     * @return self
     */
    public function setAttributes(array $attribs)
    {
        foreach ($attribs as $name => $value) {
            $this->setAttribute($name, $value);
        }
        return $this;
    }

    /**
     * Append HTML attributes
     * @param  array $attribs
     * @return self
     */
    public function appendAttributes(array $attribs)
    {
        foreach ($attribs as $name => $value) {
            $this->appendAttribute($name, $value);
        }
        return $this;
    }

    /**
     * Gets string representation
     * @return string
     */
    public function attributes()
    {
        $o = '';
        foreach ($this->attributes as $name => $value) {
            $o .= ' ' . $name . '="' . $value . '"';
        }
        return $o;
    }
}
