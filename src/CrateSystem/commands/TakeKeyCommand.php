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

use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\lang\TranslationContainer;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use CrateSystem\Main;

class TakeKeyCommand extends BaseCommand{

    /** @var Main $main */
    private $main;
    /** @var Config $cfg */
    private $cfg;

    public function __construct(Main $main){
        parent::__construct("takekey", $main);
        $this->main = $main;
        $this->setAliases(["takekey", "removekey"]);
        $this->setDescription("Take key to a player.");
    }

    /**
     * @param CommandSender $sender
     * @param string        $commandLabel
     * @param array         $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        $usage = "Usage: /takekey <player> <key> <amount>";

        if(!$sender->hasPermission("cratesystem.key")){
            $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));
            return false;
        }

        if(count($args) < 1){
            $sender->sendMessage($usage);
            return false;
        }

        if(!isset($args[1])){
            $sender->sendMessage($usage);
            return false;
        }

        if(!is_numeric($args[2])){
            $sender->sendMessage(TextFormat::RED . "Please use number.");
            return false;
        }

        if($args[2] < 0){
            $sender->sendMessage(TextFormat::RED . "$args[2] is a invalid number.");
            return false;
        }

        $player = $this->getServer()->getPlayerExact($args[0]);
        if(!$player instanceof Player){
            if($player instanceof ConsoleCommandSender){
                $sender->sendMessage(TextFormat::RED . "Please provide a player.");
                return false;
            }
            $sender->sendMessage(TextFormat::RED . "$args[0] player cannot be found.");
            return false;
        }

        if($args[1] == in_array($args[1], ["Common", "Vote", "Rare", "Legendary"])){
            $this->cfg = $this->getMain()->getPlayerCfg($player);
            $this->cfg->set($args[1], $this->cfg->get($args[1]) - $args[2]);
            $this->cfg->save();
            $sender->sendMessage(TextFormat::GREEN . "Successfully Removed {$player->getName()} $args[2] $args[1] Crate Key!");
            $player->sendMessage(TextFormat::RED . "$args[2] $args[1] Crate key has been removed from your account!");
            $player->sendMessage(TextFormat::RED . "You now have " . $this->cfg->get($args[1]) . " $args[1] Key.");
        }else{
            $sender->sendMessage(TextFormat::RED . "Could'nt found Crate $args[1]");
            return false;
        }
        return true;
    }

    public function getMain() : Main{
        return $this->main;
    }
}