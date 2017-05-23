<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\DI\Service;

use Eshopera\Core\Lib\Auth\IdentityInterface;
use Phalcon\Session\AdapterInterface;

/**
 * Authenticated user identity
 */
final class Identity implements IdentityInterface
{

    const SESSION_KEY = 'identity';

    /**
     * @var \Phalcon\Session\AdapterInterface
     */
    private $session;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name = IdentityInterface::DEFAULT_NAME;

    /**
     * Dependency injection
     * @param \Phalcon\Session\AdapterInterface $session
     */
    public function __construct(AdapterInterface $session)
    {
        $this->session = $session;
        $stored = $session->get(self::SESSION_KEY);
        if ($stored instanceof IdentityInterface) {
            $this->initialize($identity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(IdentityInterface $identity)
    {
        $this->id = $identity->getId();
        $this->name = $identity->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function persist()
    {
        $this->session->set(self::SESSION_KEY, $this);
        $this->session->regenerateId(true);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        if ($this->session->has(self::SESSION_KEY)) {
            $this->session->remove(self::SESSION_KEY);
        }
        $this->session->regenerateId(true);
    }

    /**
     * {@inheritdoc}
     */
    public function isLoggedIn()
    {
        return ($this->id ? true : false);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getNameLetter()
    {
        return mb_strtoupper(mb_substr($this->name, 0, 1));
    }

    /**
     * Serialize handler
     * @return string
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->name
        ]);
    }

    /**
     * Unserialize handler
     * @param string $data
     */
    public function unserialize($data)
    {
        list($this->id, $this->name) = unserialize($data);
    }
}
