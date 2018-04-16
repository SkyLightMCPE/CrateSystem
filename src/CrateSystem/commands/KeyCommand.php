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
use pocketmine\utils\TextFormat as C;

use CrateSystem\Main;

class KeyCommand extends BaseCommand{

    /** @var Main */
    private $main;
    /** @var Config */
    private $cfg;

    public function __construct(Main $main){
        parent::__construct("key", $main);
        $this->main = $main;
        $this->setDescription("Check player key.");
    }

    /**
     * @param CommandSender $sender
     * @param string        $commandLabel
     * @param array         $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if(!isset($args[0])){
            if(!$sender instanceof Player){
                $sender->sendMessage("Usage: /key <player>");
                return false;
            }
            $this->cfg = $this->getMain()->getPlayerCfg($sender);

            $this->common = $this->cfg->get("Common");
            $this->vote = $this->cfg->get("Vote");
            $this->rare = $this->cfg->get("Rare");
            $this->legendary = $this->cfg->get("Legendary");

            $sender->sendMessage(
                C::WHITE . "====>" . C::BLUE . "Your Crates" . C::WHITE . "<====" . "\n" . 
                C::GREEN . "Common " . C::YELLOW . $this->common . "\n" . 
                C::RED . "Vote " . C::YELLOW . $this->vote . "\n" . 
                C::GOLD . "Rare " . C::YELLOW . $this->rare . "\n" . 
                C::AQUA . "Legendary " . C::YELLOW . $this->legendary
            );
            return false;
        }

        $player = $this->getServer()->getPlayerExact($args[0]);

        if(isset($args[0])){
            if($player instanceof Player){
                $this->cfg = $this->getMain()->getPlayerCfg($player);

                $this->common = $this->cfg->get("Common");
                $this->vote = $this->cfg->get("Vote");
                $this->rare = $this->cfg->get("Rare");
                $this->legendary = $this->cfg->get("Legendary");

                $player->sendMessage(
                    C::WHITE . "====>" . C::BLUE . "{$player->getName()}'s Crates" . C::WHITE . "<====" . "\n" . 
                    C::GREEN . "Common " . C::YELLOW . $this->common . "\n" . 
                    C::RED . "Vote " . C::YELLOW . $this->vote . "\n" . 
                    C::GOLD . "Rare " . C::YELLOW . $this->rare . "\n" . 
                    C::AQUA . "Legendary " . C::YELLOW . $this->legendary
                );
            }else{
                $sender->sendMessage(C::RED . "$args[0] player cannot be found.");
                return false;
            }
        }
        return true;
    }

    public function getMain() : Main{
        return $this->main;
    }
}