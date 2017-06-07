<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Form\Backend;

use Eshopera\Core\Lib\Forms\Form;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

/**
 * Backend forgotten password form
 */
class ForgottenPasswordForm extends Form
{

    public function initialize()
    {
        parent::initialize();

        // username field
        $label = $this->translate->t('CORE_USER_USERNAME');
        $username = new Element\Text('username', [
            'class' => 'form-control',
            'placeholder' => $label,
            'required' => 'required'
        ]);
        $username->setFilters(['trim', 'string']);
        $username->addValidator(new Validator\PresenceOf([
            'message' => $this->translate->t('CORE_VALIDATION_REQUIRED', ['name' => $label])
        ]));

        $this->add($username);
    }
}
