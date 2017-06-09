<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component\DataGrid;

use Eshopera\Core\Lib\UI\Component;

/**
 * Abstract data grid column
 */
abstract class Column extends Component
{

    const TYPE = 'unknown';

    /**
     * @var string - unique column ID
     */
    protected $id;

    /**
     * @var string - column label
     */
    protected $label;

    /**
     * @var string - column value
     */
    protected $value;

    /**
     * @var string - search query
     */
    protected $query;

    /**
     * @var string - additional CSS classes
     */
    protected $css;

    /**
     * @var array - binding filters
     */
    protected $filters = [];

    /**
     * @var bool - default data grid visibility
     */
    protected $show = true;

    /**
     * @var bool - allow advanced filter search
     */
    protected $searchable = true;

    /**
     * @var bool - allow sorting
     */
    protected $sortable = true;

    /**
     * @var bool - allow quick search
     */
    protected $quicksearch = false;

    /**
     * @var bool - allow quick edit, possible values null | permanent | ondemand
     */
    protected $quickedit;

    /**
     * @var callable - callback for value setter, value = function($value, $column, $row)
     */
    protected $valueCallback;

    /**
     * @var callable - callback for value render, value = function($value, $column)
     */
    protected $renderCallback;

    /**
     * Creates new column of given ID, label and options
     * @param  string $id
     * @param  string $label - default NULL
     * @param  array $options - default NULL
     */
    public function __construct(string $id, string $label = NULL, array $options = NULL)
    {
        $this->id = $id;
        $this->label = (empty($label) ? $id : $label);

        if ($options) {
            foreach ($options as $attr => $val) {
                $this->$attr = $val;
            }
        }
    }

    /**
     * Gets column type
     * @return string
     */
    public function getType()
    {
        return static::TYPE;
    }

    /**
     * Gets column ID
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets column ID
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Gets column value
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets column value
     * @param  mixed $value
     * @return self
     */
    public function setValue($value, $entity = null)
    {
        if (is_callable($this->valueCallback)) {
            $this->value = $this->valueCallback($value, $this, $row);
        } else {
            $this->value = $value;
        }
    }

    /**
     * Gets column filters
     * @return  array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Sets column filters
     * @param  \Phalcon\FilterInterface[] $filters
     * @return self
     */
    public function setFilters(Array $filters)
    {
        $this->_filters = $filters;
        return $this;
    }

    /**
     * Binds column value to given entity
     * Filters are processed before bind
     *
     * @author  David Hübner <david.hubner at google.com>
     * @param   mixed $value
     * @param  \Eshopera\Mvc\Model $entity
     * @return self
     */
    public function bind($value, $entity)
    {
        // filtering value
        if (!empty($this->filters)) {
            $value = $this->filter->sanitize($value, $this->filters);
        }

        $value = $this->parseValue($value);

        if (is_object($entity)) {
            $method = 'set' . ucfirst($this->id);
            if (method_exists($entity, 'set' . ucfirst($this->id))) {
                $entity->$method($value);
            } else {
                $entity->{$this->id} = $value;
            }
        } elseif (is_array($entity)) {
            $entity[$this->id] = $value;
        }

        // setting internal value
        $this->setValue($value, $entity);

        return $this;
    }

    /**
     * Parses localized value
     * @return string
     */
    protected function parseValue($value)
    {
        return $value;
    }

    /**
     * Renders data grid column
     * @return string
     */
    public function render()
    {
        if ($this->quickedit == 'permanent') {
            return $this->renderQuickEditPermanent();
        } elseif ($this->quickedit == 'ondemand') {
            return $this->renderQuickEditOndemand();
        } else {
            return $this->renderValue();
        }
    }

    /**
     * Renders data grid column as simple value
     * @return string
     */
    protected function renderValue()
    {
        if (is_callable($this->renderCallback)) {
            return $this->renderCallback($this->value, $this);
        } else {
            return $this->formatValue();
        }
    }

    /**
     * Renders data grid column as permanent quick edit
     * @return string
     */
    protected function renderQuickEditPermanent()
    {
        return $this->renderValue();
    }

    /**
     * Renders data grid column as on demand quick edit
     * @return string
     */
    protected function renderQuickEditOndemand()
    {
        return $this->renderValue();
    }

    /**
     * Formats value to localized
     * @return string
     */
    protected function formatValue()
    {
        return $this->value;
    }
}
