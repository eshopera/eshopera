<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Model\Facade;

use Eshopera\Core\Lib\Mvc\Model\BaseFacade;
use Eshopera\Core\Model\Entity\User;

/**
 * User model facade
 */
class UserFacade extends BaseFacade
{

    /**
     * Finds first user by given email
     * @param  string $email
     * @return \Eshopera\Core\Model\Entity\User | null
     */
    public function findFirstUserByEmail(string $email)
    {
        return User::findFirst([
                'conditions' => 'email LIKE :email:',
                'bind' => ['email' => $email]
        ]);
    }
}
