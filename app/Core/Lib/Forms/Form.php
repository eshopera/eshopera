<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Forms;

use Eshopera\Core\Lib\Mvc\ExtendedModelInterface;
use Phalcon\Forms\Form as PhalconForm;
use Phalcon\ValidationInterface;

/**
 * Abstract form, extends standard Phalcon form
 */
abstract class Form extends PhalconForm
{

    const CSRF_KEY_BLANK = 'csrf';

    /**
     * @var \Phalcon\Translate\AdapterInterface
     */
    protected $translate;

    /**
     * Initialize form attributes
     */
    public function initialize()
    {
        $di = $this->getDI();
        $this->translate = $di->get('translate');
    }

    /**
     * Validates form data
     * Gets model validation and sets it to form elements
     * @param  array $data - default null
     * @param  object $entity - default null
     * @param  bool $destroyToken - default false
     * @return bool
     */
    public function isValid($data = null, $entity = null, $destroyToken = false)
    {
        if (!$this->hasValidCsrfToken($data, $destroyToken)) {
            return false;
        }

        if (!is_object($entity)) {
            $entity = new \stdClass();
        }

        $this->bind($data, $entity);

        if ($entity instanceof ExtendedModelInterface) {
            $this->addModelValidation($entity->getValidation());
        }

        $valid = parent::isValid();

        if (!$valid) {
            $this->populateMessages();
        }

        return $valid;
    }

    /**
     * Gets element error messages
     * @param  string $name
     * @return string
     */
    public function error($name)
    {
        if (!$this->hasMessagesFor($name)) {
            return '';
        }

        $data = [];
        $messages = $this->getMessagesFor($name);

        foreach ($messages as $message) {
            $data[] = $message->getMessage();
        }

        return '<div class="text-danger"><small>' . implode('<br>', $data) . '</small></div>';
    }

    /**
     * Gets the CSRF form protection fields
     * @param  bool $fresh - generates new fresh security token, default false
     * @return string
     */
    public function csrf($fresh = false)
    {
        return '<div class="collapse">'
            . '<input type="text" name="' . self::CSRF_KEY_BLANK . '" value="" class="form-control">'
            . '<input type="hidden" name="' . $this->security->getTokenKey($fresh) . '" value="' . $this->security->getToken($fresh) . '">'
            . '</div>';
    }

    /**
     * Adds field validators from model
     * @param \Phalcon\ValidationInterface $validation
     */
    protected function addModelValidation(ValidationInterface $validation)
    {
        $validators = $validation->getValidators();

        foreach ($validators as $item) {
            $field = $item[0];
            $validator = $item[1];

            if ($this->has($field)) {
                $elem = $this->get($field);
                $elem->addValidator($validator);
            }
        }
    }

    /**
     * Checks if CSRF token is valid
     * @param  array $data
     * @param  bool $destroyToken - default false
     * @param  bool $getToken - default false
     * @return boolean
     */
    protected function hasValidCsrfToken(Array $data, $destroyToken = false, $getToken = false)
    {
        if (isset($data[self::CSRF_KEY_BLANK]) && $data[self::CSRF_KEY_BLANK] === '' && $this->security->checkToken(null, null, $destroyToken)) {
            return true;
        }

        $this->flashSession->error(
            $this->translate->t('CORE_FORM_INVALID_CSRF_TOKEN')
        );

        return false;
    }
}
