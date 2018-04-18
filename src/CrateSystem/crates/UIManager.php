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
use jojoe77777\FormAPI\FormAPI;
use pocketmine\utils\{
    Config, TextFormat
};
use CrateSystem\Main;

class UIManager{

    /** @var Main */
    private $main;
    /** @var Config $cfg */
    private $cfg;
    /** @var CrateManager $CrateManager */
    private $CrateManager;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function crateUI(Player $player) : void{
        $this->CrateManager = new CrateManager($this->getMain());
        $this->cfg = $this->getMain()->getPlayerCfg($player);

        #UI Config
        $title = $this->getMain()->getMsgCfg()->getNested("UI.Title");
        $exit = $this->getMain()->getMsgCfg()->getNested("UI.Buttons.Exit");
        $common = $this->getMain()->getMsgCfg()->getNested("UI.Buttons.Common");
        $common = str_replace("{key}", $this->cfg->get("Common"), $common);
        $vote = $this->getMain()->getMsgCfg()->getNested("UI.Buttons.Vote");
        $vote = str_replace("{key}", $this->cfg->get("Vote"), $vote);
        $rare = $this->getMain()->getMsgCfg()->getNested("UI.Buttons.Rare");
        $rare = str_replace("{key}", $this->cfg->get("Rare"), $rare);
        $legendary = $this->getMain()->getMsgCfg()->getNested("UI.Buttons.Legendary");
        $legendary = str_replace("{key}", $this->cfg->get("Legendary"), $legendary);

        /** @var FormAPI $formapi */
        $formapi = $this->getMain()->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function (Player $player, $data){
            if($data !== null){
                switch($data){
                    case 1:
                        $this->CrateManager->Common($player);
                        return;
                    case 2:
                        $this->CrateManager->Vote($player);
                        return;
                    case 3:
                        $this->CrateManager->Rare($player);
                        return;
                    case 4:
                        $this->CrateManager->Legendary($player);
                        return;
                }
            }
        });

        $form->setTitle($title);
        $form->addButton($exit);
        $form->addButton($common);
        $form->addButton($vote);
        $form->addButton($rare);
        $form->addButton($legendary);
        $form->sendToPlayer($player);
    }

    public function getMain() : Main{
        return $this->main;
    }
}
