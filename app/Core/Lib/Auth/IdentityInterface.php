<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Auth;

/**
 * Interface for user identity
 */
interface IdentityInterface extends \Serializable
{

    const DEFAULT_NAME = 'guest';

    /**
     * Checks if user is successfully logged in
     * @return bool
     */
    public function isLoggedIn();

    /**
     * Gets identity unique ID
     * @return string
     */
    public function getId();

    /**
     * Gets identity name
     * @return string
     */
    public function getName();

    /**
     * Gets identity first name letter
     * @return string
     */
    public function getNameLetter();

    /**
     * Initializes identity data
     * @param \Eshopera\Core\Lib\Auth\IdentityInterface $identity
     */
    public function initialize(IdentityInterface $identity);

    /**
     * Persists actual identity
     */
    public function persist();

    /**
     * Clears all persisted data
     */
    public function clear();
}
