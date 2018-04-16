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

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\utils\{
    Config, TextFormat as C
};

use CrateSystem\crates\UIManager;
use CrateSystem\Main;

class CrateCommand extends BaseCommand{

    /** @var Main */
    private $main;
    /** @var UIManager */
    private $UIManager;
    /** @var Config */
    private $cfg;

    /**
     * CrateCommand constructor.
     * @param Main $main
     */
    public function __construct(Main $main){
        parent::__construct("crate", $main);
        $this->main = $main;
        $this->setDescription("Crate Command.");
    }

    /**
     * @param CommandSender $sender
     * @param string        $commandLabel
     * @param array         $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        $this->cfg = new Config($this->getMain()->getDataFolder() . "config.yml", Config::YAML);
        $this->UIManager = new UIManager($this->getMain());

        if(!$sender instanceof Player){
            $sender->sendMessage(C::RED . "Please use this command ingame.");
            return false;
        }

        if($this->getMain()->getCfg()->get("type") == "ui"){
            $this->UIManager->crateUI($sender);
        }
        return true;
    }

    public function getMain() : Main{
        return $this->main;
    }
}