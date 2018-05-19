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

namespace CrateSystem\crates;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use CrateSystem\Main;

class CrateManager{

    /** @var Main $main */
    private $main;
    /** @var Config $cfg */
    private $cfg;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function Common(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);
        $message = $this->getMain()->getMsgCfg()->getNested("Crates.Common.Opened");
        $nokey = $this->getMain()->getMsgCfg()->getNested("Crates.Common.No-Key");

        if($this->cfg->get("Common") >= 1){
            $itemscfg = $this->getMain()->getItemCfg()->getNested("common.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            if(isset($values[3])) $item->setCustomName($values[3]);

            $message = str_replace("{name}", $item->getName(), $message);
            $message = str_replace("{id}", $item->getId(), $message);
            $message = str_replace("{damage}", $item->getDamage(), $message);
            $message = str_replace("{amount}", $item->getCount(), $message);

            $player->getInventory()->addItem($item);
            $player->sendMessage($message);

            $this->cfg->set("Common", $this->cfg->get("Common") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage($nokey);
        }
    }

    public function Vote(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);
        $message = $this->getMain()->getMsgCfg()->getNested("Crates.Vote.Opened");
        $nokey = $this->getMain()->getMsgCfg()->getNested("Crates.Vote.No-Key");

        if($this->cfg->get("Vote") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("vote.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $message = str_replace("{name}", $item->getName(), $message);
            $message = str_replace("{id}", $item->getId(), $message);
            $message = str_replace("{damage}", $item->getDamage(), $message);
            $message = str_replace("{amount}", $item->getCount(), $message);

            $player->getInventory()->addItem($item);
            $player->sendMessage($message);

            $this->cfg->set("Vote", $this->cfg->get("Vote") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage($nokey);
        }
    }

    public function Rare(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);
        $message = $this->getMain()->getMsgCfg()->getNested("Crates.Rare.Opened");
        $nokey = $this->getMain()->getMsgCfg()->getNested("Crates.Rare.No-Key");

        if($this->cfg->get("Rare") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("rare.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $message = str_replace("{name}", $item->getName(), $message);
            $message = str_replace("{id}", $item->getId(), $message);
            $message = str_replace("{damage}", $item->getDamage(), $message);
            $message = str_replace("{amount}", $item->getCount(), $message);

            $player->getInventory()->addItem($item);
            $player->sendMessage($message);

            $this->cfg->set("Rare", $this->cfg->get("Rare") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage($nokey);
        }
    }

    public function Legendary(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);
        $message = $this->getMain()->getMsgCfg()->getNested("Crates.Legendary.Opened");
        $nokey = $this->getMain()->getMsgCfg()->getNested("Crates.Legendary.No-Key");

        if($this->cfg->get("Legendary") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("legendary.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $message = str_replace("{name}", $item->getName(), $message);
            $message = str_replace("{id}", $item->getId(), $message);
            $message = str_replace("{damage}", $item->getDamage(), $message);
            $message = str_replace("{amount}", $item->getCount(), $message);

            $player->getInventory()->addItem($item);
            $player->sendMessage($message);

            $this->cfg->set("Legendary", $this->cfg->get("Legendary") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage($nokey);
        }
    }


    public function getMain() : Main{
        return $this->main;
    }
}