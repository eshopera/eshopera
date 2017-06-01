<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application\Module;

use Eshopera\Core\Lib\Application\ModuleInterface;
use Eshopera\Core\Lib\Exception\ApplicationException;
use Eshopera\Core\Model\Entity\Module;
use Phalcon\Db\AdapterInterface;

/**
 * Base module installer interface
 */
abstract class BaseInstaller implements InstallerInterface
{

    const TABLE_MODULES = 'CoreModule';

    /**
     * @var \Eshopera\Core\Lib\Application\ModuleInterface
     */
    protected $module;

    /**
     * @var \Phalcon\Db\AdapterInterface
     */
    protected $db;

    /**
     * @var \Eshopera\Core\Model\Entity\Module
     */
    protected $entity;

    /**
     * Dependency injection
     * @param \Eshopera\Core\Lib\Application\ModuleInterface $module
     * @param \Phalcon\Db\AdapterInterface $db
     */
    public function __construct(ModuleInterface $module, AdapterInterface $db)
    {
        $this->module = $module;
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function isInstalled()
    {
        if ($this->entity) {
            return true;
        }
        if ($this->db->tableExists(self::TABLE_MODULES)) {
            return false;
        }
        $this->entity = Module::findFirst($this->module->getAlias());
        return ($this->entity ? true : false);
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        if (!$this->isInstalled()) {
            return false;
        }
        return $this->entity->active;
    }

    /**
     * {@inheritdoc}
     */
    public function activate()
    {
        if (!$this->isInstalled()) {
            throw new ApplicationException('Module "' . $this->module->getAlias() . '" is not installed');
        }
        $this->entity->active = true;
        return $this->entity->update();
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate()
    {
        if (!$this->isInstalled()) {
            throw new ApplicationException('Module "' . $this->module->getAlias() . '" is not installed');
        }
        $this->entity->active = false;
        return $this->entity->update();
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        if ($this->isInstalled()) {
            throw new ApplicationException('Module "' . $this->module->getAlias() . '" is already installed');
        }
        $this->persistInstall();
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade()
    {
        if (!$this->isInstalled()) {
            throw new ApplicationException('Module "' . $this->module->getAlias() . '" is not inslalled');
        }
        $this->persistUpgrade($this->module->getVersion());
    }

    protected function persistInstall()
    {
        $this->entity = new Module();
        $this->entity->id = $this->module->getAlias();
        $this->entity->active = true;
        if (!$this->entity->create()) {
            throw new ApplicationException('Cannot persist install for module "' . $this->module->getAlias() . '"');
        }
    }

    protected function persistUpgrade(string $version)
    {
        $this->entity->version = $version;
        if (!$this->entity->upgrade()) {
            throw new ApplicationException('Cannot persist upgrade for module "' . $this->module->getAlias() . '"');
        }
    }
}
