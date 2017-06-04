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
 * Backend login form
 */
class LoginForm extends Form
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

        // password field
        $label = $this->translate->t('CORE_USER_PASSWORD');
        $passwd = new Element\Password('password', [
            'class' => 'form-control',
            'placeholder' => $label,
            'required' => 'required',
            'autocomplete' => 'off',
            'data-focus' => '1'
        ]);
        $passwd->addValidator(new Validator\PresenceOf([
            'message' => $this->translate->t('CORE_VALIDATION_REQUIRED', ['name' => $label])
        ]));

        $this->add($passwd);

        // back url field
        $back = new Element\Hidden('back');

        $this->add($back);
    }
}
