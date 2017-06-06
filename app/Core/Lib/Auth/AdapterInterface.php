<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Auth;

/**
 * Interface for authentification identity
 */
interface AdapterInterface
{

    /**
     * Authenticates a user
     * @param  array $credentials
     * @return \Eshopera\Core\Lib\Auth\IdentityInterface
     * @throw  \Eshopera\Core\Lib\Exception\AuthException
     */
    public function authenticate(Array $credentials);
}
