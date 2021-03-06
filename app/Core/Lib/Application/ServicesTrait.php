<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Application;

use Eshopera\Core\Lib\Exception\ApplicationException;

/**
 * Application services registration
 */
trait ServicesTrait
{

    /**
     * {@inheritdoc}
     */
    public function registerServices()
    {
        $configPath = $this->rootDir . '/config/services.' . self::CONTEXT . '.json';

        if (!is_file($configPath)) {
            throw new ApplicationException('Configuration "config/services.' . self::CONTEXT . '.json" does not exist');
        }

        $config = json_decode(file_get_contents($configPath), true);

        if (!is_array($config)) {
            throw new ApplicationException('Parse error for configuration "config/services.json"');
        }

        if (!empty($config['shared'])) {
            $this->registerInternalServices($config['shared'], true);
        }

        if (!empty($config['instance'])) {
            $this->registerInternalServices($config['instance'], false);
        }

        return $this;
    }

    private function registerInternalServices(Array $services, $shared)
    {
        foreach ($services as $name => $config) {
            if (empty($config['className'])) {
                throw new ApplicationException('Invalid className for service "' . $name . '"');
            }
            $this->getDI()->set($name, $config, $shared);
        }
    }
}
