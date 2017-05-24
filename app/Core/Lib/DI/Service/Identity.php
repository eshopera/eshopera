<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\DI\Service;

use Eshopera\Core\Lib\Auth\IdentityInterface;
use Eshopera\Core\Lib\Exception\AuthException;
use Phalcon\Session\Bag;

/**
 * Authenticated user identity
 */
final class Identity extends Bag implements IdentityInterface
{

    const DEFAULT_NAME = 'guest';
    const PERSITENT_KEY = 'identity';

    /**
     * {@inheritdoc}
     */
    public function fill(IdentityInterface $identity)
    {
        $this->set('id', $identity->getId());
        $this->set('email', $identity->getEmail());
        $this->set('name', $identity->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        if ($this->has('id')) {
            $this->remove('id');
            $this->remove('email');
            $this->remove('name');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isLoggedIn()
    {
        return ($this->getId() ? true : false);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->get('email');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->get('name', self::DEFAULT_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getNameLetter()
    {
        return mb_strtoupper(mb_substr($this->name, 0, 1));
    }

    /**
     * Disable magic setter
     * @param  string $property
     * @param  mixed $value
     * @throws \Eshopera\Core\Lib\Exception\AuthException
     */
    public function __set($property, $value)
    {
        throw new AuthException('Identity values cannot be set directly');
    }
}
