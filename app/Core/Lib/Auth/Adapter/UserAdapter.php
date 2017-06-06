<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Auth\Adapter;

use Eshopera\Core\Lib\Auth\AdapterInterface;
use Eshopera\Core\Model\Facade\UserFacade;
use Eshopera\Core\Lib\Exception\AuthException;
use Phalcon\Translate\AdapterInterface as TranslateInterface;

/**
 * Authentification based on local user model
 */
class UserAdapter implements AdapterInterface
{

    /**
     * @var \Eshopera\Core\Model\Facade\UserFacade
     */
    private $userFacade;

    /**
     * @var \Phalcon\Translate\AdapterInterface
     */
    private $translate;

    /**
     * Dependency injection
     * @param \Eshopera\Core\Model\Facade\UserFacade $userFacade
     * @param \Phalcon\Translate\AdapterInterface $translate
     */
    public function __construct(UserFacade $userFacade, TranslateInterface $translate)
    {
        $this->userFacade = $userFacade;
        $this->translate = $translate;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(array $credentials)
    {
        if (empty($credentials['username']) || empty($credentials['password'])) {
            throw new AuthException($this->translate->t('CORE_AUTH_INVALID_CREDENTIALS'));
        }

        $user = $this->userFacade->findFirstUserByEmail($credentials['username']);

        if (empty($user) || $user->getTrash()) {
            throw new AuthException($this->translate->t('CORE_AUTH_INVALID_CREDENTIALS'));
        }

        if (!$user->active) {
            throw new AuthException($this->translate->t('CORE_AUTH_ACCOUNT_INACTIVE'));
        }

        if ($time = $user->hasAccountLocked()) {
            throw new AuthException($this->translate->t('CORE_AUTH_ACCOUNT_LOCKED', ['time' => ceil($time / 60)]));
        }

        if (!$user->isValidPassword($credentials['password'])) {
            $user->incrementFailedLoginAttempts();
            throw new AuthException($this->translate->t('CORE_AUTH_INVALID_CREDENTIALS'));
        }

        return $user;
    }
}
