<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\UI\Component;

use Eshopera\Core\Lib\UI\Component;
use Eshopera\Core\Lib\UI\Component\DataGrid\Column;

/**
 * Data grid UI component
 */
abstract class DataGrid extends Component
{

    use Traits\AttributesTrait;

    const DEFAULT_TEMPLATE = 'core/component/data-grid';

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $mainActions = [];

    /**
     * @var array
     */
    protected $rowActions = [];

    /**
     * @var array
     */
    protected $multiActions = [];

    /**
     * Creates new data grid component
     * @param  array $attributes - default NULL
     */
    public function __construct(array $attributes = NULL)
    {
        $this->initialize();
        $this->setAttribute('class', 'data-grid table');
        if ($attributes) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * Initializes data grid columns
     */
    abstract public function initialize();

    /**
     * Adds data grid text column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\TextColumn
     */
    public function addTextColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\TextColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid text area column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\TextareaColumn
     */
    public function addTextareaColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\TextareaColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid number column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\NumberColumn
     */
    public function addNumberColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\NumberColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid date column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\DateColumn
     */
    public function addDateColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\DateColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid select box column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\CheckboxColumn
     */
    public function addSelectColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\SelectColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid check box column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\CheckboxColumn
     */
    public function addCheckboxColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\CheckboxColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid media column
     * @param  string $id
     * @param  string $label
     * @param  array $attributes - default NULL
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column\MediaColumn
     */
    public function addMediaColumn(string $id, string $label, array $attributes = null)
    {
        return $this->addColumn(new Column\MediaColumn($id, $label, $attributes));
    }

    /**
     * Adds data grid column
     * @param  \Eshopera\Core\Lib\UI\Component\DataGrid\Column $column
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column
     */
    public function addColumn(Column $column)
    {
        $this->columns[$column->getId()] = $column;
        return $column;
    }

    /**
     * Checks if data grid has column of given ID
     * @param  string $id
     * @return bool
     */
    public function hasColumn(string $id)
    {
        return (isset($this->columns[$id]) ? true : false);
    }

    /**
     * Gets column of given id
     * @param  string $id
     * @return \Eshopera\Core\Lib\UI\Component\DataGrid\Column | null
     */
    public function getColumn(string $id)
    {
        if (isset($this->columns[$id])) {
            return $this->columns[$id];
        } else {
            return null;
        }
    }
}
