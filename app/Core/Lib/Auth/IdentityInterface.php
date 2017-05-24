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
interface IdentityInterface
{

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
     * Gets identity email
     * @return string
     */
    public function getEmail();

    /**
     * Gets identity name
     * @return string
     */
    public function getName();

    /**
     * Initializes identity data
     * @param \Eshopera\Core\Lib\Auth\IdentityInterface $identity
     */
    public function fill(IdentityInterface $identity);

    /**
     * Clears all persisted data
     */
    public function clear();

    /**
     * Destroys persisted data
     */
    public function destroy();
}
