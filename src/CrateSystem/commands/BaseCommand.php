<?php

/*
 * CrateSystem, a public plugin for crates for PocketMine-MP
 * Copyright (C) 2017-2018 CLADevs
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY;  without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

declare(strict_types=1);

namespace CrateSystem\commands;

use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\command\{
    Command, PluginIdentifiableCommand
};
use CrateSystem\Main;

abstract class BaseCommand extends Command implements PluginIdentifiableCommand{

    /** @var Main */
    private $main;

    /**
     * BaseCommand constructor.
     * @param string $name
     * @param Main   $main
     */
    public function __construct(string $name, Main $main){
        parent::__construct($name);
        $this->main = $main;
        $this->usageMessage = "";
    }

    public function getPlugin() : Plugin{
        return $this->getMain();
    }

    public function getServer() : Server{
        return $this->getMain()->getServer();
    }

    public function getMain() : Main{
        return $this->main;
    }
}