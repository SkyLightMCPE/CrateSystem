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
    Config, TextFormat as C
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
        $form = Server::getInstance()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data){
            // NOTE: $data returns int (SimpleForm key)
            if($data !== null) {
                switch ($data) {
                    case 1:
                        $this->Common($player);
                        return;
                    case 2:
                        var_dump("Vote");
                        return;
                }
            }
        });

        $form->setTitle(C::BLUE . "Crates List");
        $form->addButton(C::WHITE . "Exit");
        $form->addButton(C::GREEN . "Common " . C::GRAY . "- " . C::YELLOW . $this->cfg->get("Common"));
        $form->addButton(C::RED . "Vote " . C::GRAY . "- " . C::YELLOW . $this->cfg->get("Vote"));
        $form->addButton(C::GOLD . "Rare " . C::GRAY . "- " . C::YELLOW . $this->cfg->get("Rare"));
        $form->addButton(C::AQUA . "Legendary " . C::GRAY . "- " . C::YELLOW . $this->cfg->get("Legendary"));
        $form->sendToPlayer($player);
    }

    /**
     * @param Player $player
     * @return void
     */
    public function Common(Player $player) : void{
        $this->cfg = $this->getMain()->getPlayerCfg($player);

        if($this->cfg->get("Common") >= 1){
            $player->getInventory()->addItem(Item::get(276, 1, 1));
            $this->cfg->set("Common", $this->cfg->get("Common") - 1);
            $this->cfg->save();
        }else{
            $player->sendMessage(C::RED . "You don't have any Common key.");
        }
    }

    public function getMain() : Main{
        return $this->main;
    }
}
