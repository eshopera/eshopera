<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Controller\Backend;

use Eshopera\Core\Lib\Mvc\BackendController;
use Eshopera\Core\Form\Backend\LoginForm;

/**
 * Backend authorization controller
 */
class AuthController extends BackendController
{

    const COOKIE_USERNAME_NAME = 'uid';
    const COOKIE_USERNAME_TTL = 31536000;

    /**
     * Login page
     */
    public function indexAction()
    {
        if ($this->user->isLoggedIn()) {
            return $this->redirect('/');
        }

        $username = $this->cookies->get(self::COOKIE_USERNAME_NAME)->getValue();
        $back = $this->request->get('back');

        $form = new LoginForm();
        $form->setAction($this->url->get('core/auth'));
        $form->get('username')->setDefault($username);
        $form->get('back')->setDefault($back);

        if ($this->request->isPost() && $form->isValid($this->request->getPost(), new \stdClass(), true)) {
            if ($this->handleSignIn($form)) {
                return $this->response->redirect(($back ? $back : '/'));
            }
        }

        $config = $this->application->getConfig();

        $this->view->appName = $config->name;
        $this->view->form = $form;
        $this->view->bodyClass = 'app flex-row align-items-center';

        $this->tag->setTitle($this->translate->t('CORE_AUTH_LOGIN_TITLE'));
    }

    /**
     * Handles user login
     * @param  \Eshopera\Core\Form\Backend\LoginForm $form
     * @return bool
     */
    private function handleSignIn(LoginForm $form)
    {
        return true;

        $username = $form->getValue('username');
        $passwd = $form->getValue('password');

        $this->cookies->set(
            self::COOKIE_USERNAME_NAME, $username, time() + self::COOKIE_USERNAME_TTL, '/', true, null, true
        );

        $user = $this->coreUserFacade->findFirstByValidCredentials($username, $passwd);

        if (empty($user)) {
            $this->fillFlashMessages($this->usersFacade->getMessages());
            return false;
        }

        return $this->loginUser($user, false);
    }
}
