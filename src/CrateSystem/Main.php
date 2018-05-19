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

namespace CrateSystem;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{
    Config, TextFormat
};

use CrateSystem\commands\CommandManager;
use CrateSystem\crates\CrateManager;
use CrateSystem\events\EventManager;

class Main extends PluginBase{

    /** @var CrateManager $CrateManager */
    public $CrateManager;
    /** @var $formapi */
    public $formapi;

    public function onEnable() : void{
        if($this->checkDepends()) return;
        $this->registerManager();
        $this->getLogger()->info(TextFormat::GREEN . "CrateSystem has been loaded!");
    }

    public function registerManager() : void{
        new Configuration($this);
        new CommandManager($this);
        new EventManager($this);
        $this->CrateManager = new CrateManager($this);
        //$this->KeyManager = new KeyManager($this);
    }

    public function checkDepends(){
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        if(is_null($this->formapi)){
            $this->getLogger()->error("Please install FormAPI Plugin.");
            $this->getPluginLoader()->disablePlugin($this);
            return true;
        }
        return false;
    }

    public function regPlayer(Player $player) : void{
        new Config($this->getPlayer($player), Config::YAML, [
            "Common" => 0,
            "Vote" => 0,
            "Rare" => 0,
            "Legendary" => 0
        ]);
    }

    public function getCfg() : Config{
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function getPlayerCfg(Player $player) : Config{
        return new Config($this->getPlayer($player), Config::YAML);
    }

    public function getItemCfg() : Config{
        return new Config($this->getDataFolder() . "items.yml", Config::YAML);
    }

    public function getMsgCfg() : Config{
        return new Config($this->getDataFolder() . "lang/messages.yml", Config::YAML);
    }

    public function getPlayer(Player $player) : string{
        return $this->getDataFolder() . "players" . DIRECTORY_SEPARATOR . strtolower($player->getName()) . ".yml";
    }
}