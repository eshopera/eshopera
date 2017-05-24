<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core;

use Eshopera\Core\Lib\Application\Module\BaseInstaller;

/**
 * Installer for core
 */
class Installer extends BaseInstaller
{

    public function install()
    {
        if ($this->isInstalled()) {
            throw new ApplicationException('Module "' . $this->module->getAlias() . '" is already installed');
        }

        $this->db->execute("CREATE TABLE `CoreModule` (
            `id` varchar(100) NOT NULL,
            `createdAt` datetime NOT NULL,
            `updatedAt` datetime NOT NULL,
            `version` varchar(20) NOT NULL,
            `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `frontend` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `backend` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `api` tinyint(1) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");

        $this->db->execute("CREATE TABLE `CoreUser` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `createdAt` datetime NOT NULL,
            `updatedAt` datetime NOT NULL,
            `email` varchar(100) NOT NULL,
            `name` varchar(200) NOT NULL,
            `passwdHash` varchar(200) NOT NULL,
            `externalId` varchar(50) DEFAULT NULL,
            `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `trash` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `failedLoginAttempts` tinyint(3) unsigned NOT NULL DEFAULT '0',
            `failedLoginTs` int(10) unsigned NOT NULL DEFAULT '0',
            `lastLoginTs` int(10) unsigned DEFAULT NULL,
            `lastLoginIp` varchar(45) DEFAULT NULL,
            `prefLang` char(2) DEFAULT NULL,
            `prefLocale` char(6) DEFAULT NULL,
            `prefTimezone` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unq_email` (`email`),
            UNIQUE KEY `unq_external` (`externalId`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");

        $this->persistInstall();
    }

    public function upgrade()
    {
        if (!$this->isInstalled()) {
            throw new ApplicationException('Module "' . $this->module->getAlias() . '" is not inslalled');
        }

        if (version_compare('1.0.0', $this->entity->version) > 0) {
            $this->persistUpgrade('1.0.0');
        }
    }
}
