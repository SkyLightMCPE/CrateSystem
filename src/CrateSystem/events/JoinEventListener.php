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

namespace CrateSystem\events;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use CrateSystem\Main;

class JoinEventListener implements Listener{

    /** @var Main $main */
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
        $main->getServer()->getPluginManager()->registerEvents($this, $main);
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        if(!file_exists($this->main->getDataFolder() . "players" . DIRECTORY_SEPARATOR . strtolower($player->getName()) . ".yml")){
            $this->regPlayer($player);
        }
    }

    public function regPlayer(Player $player) : void{
        new Config($this->main->getPlayer($player), Config::YAML, [
            "Common" => 0,
            "Vote" => 0,
            "Rare" => 0,
            "Legendary" => 0
        ]);
    }
}