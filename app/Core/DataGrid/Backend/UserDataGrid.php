<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\DataGrid\Backend;

use Eshopera\Core\Lib\UI\Component\DataGrid;

/**
 * Data grid for users
 */
class UserDataGrid extends DataGrid
{

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->addTextColumn('email', $this->translate->t('CORE_USER_EMAIL'));
        $this->addTextColumn('name', $this->translate->t('CORE_USER_NAME'));
    }
}
