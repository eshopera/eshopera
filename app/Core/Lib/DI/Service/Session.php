<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\DI\Service;

use Phalcon\Session\Adapter\Files;
use Phalcon\Config;
use Phalcon\Http\RequestInterface;

/**
 * Session with enhanced security
 */
final class Session extends Files
{

    const DEFAULT_NAME = 'SESSION';
    const DEFAULT_LIFETIME = 14400;
    const DEFAULT_VALIDATE_IP = false;
    const REGENERATE_EVERY = 900;

    /**
     * Configuration and dependency injection
     * @param \Phalcon\Http\RequestInterface $request
     * @param \Phalcon\Config $config - default null
     */
    public function __construct(RequestInterface $request, $config = null)
    {
        parent::__construct();

        if ($config instanceof Config) {
            $lifetime = (empty($config->lifetime) ? self::DEFAULT_LIFETIME : $config->lifetime);
            $name = (empty($config->name) ? self::DEFAULT_NAME : $config->name);
            $validateIp = (empty($config->validateIp) ? self::DEFAULT_VALIDATE_IP : $config->validateIp);
        } else {
            $lifetime = self::DEFAULT_LIFETIME;
            $name = self::DEFAULT_NAME;
            $validateIp = self::DEFAULT_VALIDATE_IP;
        }

        session_set_cookie_params(0, '/', null, ($request->getScheme() == 'https'), true);

        ini_set('session.gc_maxlifetime', $lifetime);

        $this->setName($name);
        $this->start();

        $hash = md5($request->getBestLanguage() . ($validateIp ? $request->getClientAddress(true) : ''));

        // preventing session hijack
        if (($savedHash = $this->get('__hash'))) {
            if ($hash != $savedHash) {
                $this->destroy(true);
                $this->start();
            }
        } else {
            $this->set('__hash', $hash);
        }

        $lastUpdate = $this->get('__ts', 0);
        $ts = time();

        // periodically regenerating session ID
        if ($lastUpdate + self::REGENERATE_EVERY < $ts) {
            $this->set('__ts', $ts);
            $this->regenerateId(true);
        }
    }
}
