<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/davihu/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application\Module;

/**
 * Interface for module installer
 */
interface InstallerInterface
{

    /**
     * Checks if module is installed
     * @return bool
     */
    public function isInstalled();

    /**
     * Installs module
     * @return bool
     */
    public function install();

    /**
     * Upgrades module to the last version
     * @param  string $version
     * @return bool
     */
    public function upgrade();

    /**
     * Checks if module is active
     * @return bool
     */
    public function isActive();

    /**
     * Activates installed module
     * @return bool
     */
    public function activate();

    /**
     * Deactivates installed module
     * @return bool
     */
    public function deactivate();
}
