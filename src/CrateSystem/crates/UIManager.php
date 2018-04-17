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
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\utils\{
    Config, TextFormat
};
use CrateSystem\Main;

class UIManager{

    /** @var Main */
    private $main;
    /** @var Config $cfg */
    private $cfg;

    /**
     * UIManager constructor.
     * @param Main $main
     */
    public function __construct(Main $main){
        $this->main = $main;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function crateUI(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);
        $formapi = $this->getMain()->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $player, $data){
            if($data !== null) {
                switch ($data) {
                    case 1:
                        $this->Common($player);
                        return;
                    case 2:
                        $this->Vote($player);
                        return;
                    case 3:
                        $this->Rare($player);
                        return;
                    case 4:
                        $this->Legendary($player);
                        return;
                }
            }
        });

        $form->setTitle(TextFormat::BLUE . "Crates List");
        $form->addButton(TextFormat::WHITE . "Exit");
        $form->addButton(TextFormat::GREEN . "Common " . TextFormat::GRAY . "- " . TextFormat::YELLOW . $this->cfg->get("Common"));
        $form->addButton(TextFormat::RED . "Vote " . TextFormat::GRAY . "- " . TextFormat::YELLOW . $this->cfg->get("Vote"));
        $form->addButton(TextFormat::GOLD . "Rare " . TextFormat::GRAY . "- " . TextFormat::YELLOW . $this->cfg->get("Rare"));
        $form->addButton(TextFormat::AQUA . "Legendary " . TextFormat::GRAY . "- " . TextFormat::YELLOW . $this->cfg->get("Legendary"));
        $form->sendToPlayer($player);
    }

    /**
     * @param Player $player
     * @return void
     */
    public function Common(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);

        if($this->cfg->get("Common") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("common.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $player->getInventory()->addItem($item);
            $message = TextFormat::GREEN . "You recivied " . $item->getName() . " (" . $item->getId() . ":" . $item->getDamage() . ") * " . $item->getCount() . " from Common Crate!";
            $player->sendMessage($message);

            $this->cfg->set("Common", $this->cfg->get("Common") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage(TextFormat::RED . "You don't have any Common key.");
        }
    }

    public function Vote(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);

        if($this->cfg->get("Vote") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("vote.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $player->getInventory()->addItem($item);
            $message = TextFormat::GREEN . "You recivied " . $item->getName() . " (" . $item->getId() . ":" . $item->getDamage() . ") * " . $item->getCount() . " from Vote Crate!";
            $player->sendMessage($message);

            $this->cfg->set("Vote", $this->cfg->get("Vote") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage(TextFormat::RED . "You don't have any Vote key.");
        }
    }

    public function Rare(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);

        if($this->cfg->get("Rare") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("rare.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $player->getInventory()->addItem($item);
            $message = TextFormat::GREEN . "You recivied " . $item->getName() . " (" . $item->getId() . ":" . $item->getDamage() . ") * " . $item->getCount() . " from Rare Crate!";
            $player->sendMessage($message);

            $this->cfg->set("Rare", $this->cfg->get("Rare") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage(TextFormat::RED . "You don't have any Rare key.");
        }
    }

    public function Legendary(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);

        if($this->cfg->get("Legendary") >= 1){

            $itemscfg = $this->getMain()->getItemCfg()->getNested("legendary.items");
            $randomitem = $itemscfg[array_rand($itemscfg)];
            $values = explode(":", $randomitem);
            $item = Item::get(intval($values[0]), intval($values[1]), intval($values[2]));
            $item->setCustomName($values[3]);

            $player->getInventory()->addItem($item);
            $message = TextFormat::GREEN . "You recivied " . $item->getName() . " (" . $item->getId() . ":" . $item->getDamage() . ") * " . $item->getCount() . " from Legendary Crate!";
            $player->sendMessage($message);

            $this->cfg->set("Legendary", $this->cfg->get("Legendary") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage(TextFormat::RED . "You don't have any Legendary key.");
        }
    }

    public function getMain() : Main{
        return $this->main;
    }
}
