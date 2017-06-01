<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core;

use Eshopera\Core\Lib\Application\BaseModule;
use Eshopera\Core\Lib\DI\Service\Session;
use Eshopera\Core\Lib\DI\Service\Identity;
use Eshopera\Core\Lib\Http\AjaxResponse;
use Eshopera\Core\Lib\Events\Listener\ApplicationListener;
use Eshopera\Core\Lib\Events\Listener\ViewListener;
use Eshopera\Core\Lib\ApplicationInterface;
use Phalcon\DiInterface;
use Phalcon\Http\Response;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Cache\Frontend\Data as DataCache;
use Phalcon\Cache\Frontend\Output as OutputCache;
use Phalcon\Cache\Backend as CacheBackend;
use Phalcon\Events\ManagerInterface;
use Phalcon\Assets\Manager as AssetsManager;

/**
 * Core module
 */
class Module extends BaseModule
{

    const MODULE_DIR = __DIR__;
    const MODULE_VER = '1.0';
    const HAS_FRONTEND = true;
    const HAS_BACKEND = true;

    /**
     * {@inheritdoc}
     */
    public function registerServices(DiInterface $di, string $appContext)
    {
        $config = $this->getConfig();

        $this->getDI()->set('logger', function () use ($config) {
            $rootDir = $this->get('application')->getRootDir();
            $logger = new FileLogger($rootDir . '/log/app-' . date('ym') . '.log');
            if (!empty($config->logger->level)) {
                $logger->setLogLevel($config->logger->level);
            }
            return $logger;
        }, true);

        $di->set('db', function () use ($config) {
            $mysql = new Mysql([
                'host' => $config->db->master->host,
                'username' => $config->db->master->username,
                'password' => $config->db->master->password,
                'dbname' => $config->db->master->name,
                'charset' => 'utf8mb4'
            ]);
            $mysql->getInternalHandler()->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
            return $mysql;
        }, true);

        $di->set('modelsCache', function () use ($config) {
            $front = new DataCache([
                'lifetime' => $config->cache->lifetime
            ]);

            if ($config->cache->adapter == 'redis') {
                $config->cache->options->prefix .= '_m_';
                return new CacheBackend\Redis($front, $config->cache->options->toArray());
            } else {
                $rootDir = $this->get('application')->getRootDir();
                return new CacheBackend\File($front, [
                    'cacheDir' => $rootDir . '/temp/cache',
                    'prefix' => 'model_'
                ]);
            }
        }, true);

        $di->set('viewsCache', function () use ($config) {
            $front = new OutputCache([
                'lifetime' => $config->lifetime
            ]);

            if ($config->cache->adapter == 'redis') {
                $config->cache->options->prefix .= '_v_';
                return new CacheBackend\Redis($front, $config->cache->options->toArray());
            } else {
                $rootDir = $this->get('application')->getRootDir();
                return new CacheBackend\File($front, [
                    'cacheDir' => $rootDir . '/temp/cache',
                    'prefix' => 'view_'
                ]);
            }
        }, true);

        $di->set('response', function () {
            if ($this->get('request')->isAjax()) {
                return new AjaxResponse();
            } else {
                return new Response();
            }
        }, true);

        $di->set('session', function () use ($config) {
            return new Session($this->get('request'), $config['session']);
        }, true);

        $di->set('user', function () {
            return new Identity('__user');
        }, true);
    }

    /**
     * {@inheritdoc}
     */
    public function registerEventListeners(ManagerInterface $eventsManager, string $appContext)
    {
        $di = $this->getDI();

        $eventsManager->attach('application', new ApplicationListener($di->get('dispatcher')));
        $eventsManager->attach('view', new ViewListener($di->get('application')));
    }

    /**
     * {@inheritdoc}
     */
    public function registerAssets(AssetsManager $assetsManager, string $appContext)
    {
        if ($appContext == ApplicationInterface::CONTEXT_FRONTEND) {
            $this->registerFrontendAssets($assetsManager);
        } elseif ($appContext == ApplicationInterface::CONTEXT_BACKEND) {
            $this->registerBackendAssets($assetsManager);
        }
    }

    /**
     * Registers core frontend assets
     * @param \Phalcon\Assets\Manager $assetsManager
     */
    private function registerFrontendAssets(AssetsManager $assetsManager)
    {

    }

    /**
     * Registers core backend assets
     * @param \Phalcon\Assets\Manager $assetsManager
     */
    private function registerBackendAssets(AssetsManager $assetsManager)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getInstaller()
    {
        return new Installer($this, $this->getDI()->get('db'));
    }
}
