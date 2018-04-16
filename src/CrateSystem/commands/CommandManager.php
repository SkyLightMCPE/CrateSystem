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

use CrateSystem\Main;

class CommandManager{

    /** @var Main */
    private $main;

    /**
     * CommandManager constructor.
     * @param Main $main
     */
    public function __construct(Main $main){
        $this->main = $main;
        $this->registerCommands();
    }

    private function registerCommands() : void{
        $commands = [
            new CrateCommand($this->main),
            new AddKeyCommand($this->main),
            new TakeKeyCommand($this->main),
            new SetKeyCommand($this->main),
            new KeyCommand($this->main)
        ];
        $this->main->getServer()->getCommandMap()->registerAll("CrateSystem", $commands);
    }
}