<?php
/*
 * Copyright (c) Todo56 2020 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Gottfried Rosenberger <gottfried@todo56.dev>
 */

namespace zOmArRD\core\tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TE;
use Scoreboards\Scoreboards;
use zOmArRD\core\Main;
use zOmArRD\core\YGCPlayer;

class YGCScore extends Task
{
    /**
     * @inheritDoc
     */
    public function onRun(int $currentTick)
    {
        /*foreach($this->plugin->getServer()->getDefaultLevel()->getPlayers() as $player){
            $settings = $this->plugin->settings->get($player->getName());
            if ($settings["scoreboard"]) {
                $this->addScoreboord($player);
            }
        }*/
        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            $this->addScoreboord($player);
        }
    }
    public function addScoreboord(Player $player)
    {
        //if ($player instanceof YGCPlayer) {
            $nick = $player->getName();
            $api = Scoreboards::getInstance();
            $plugin = Main::getInstance();
            $pl = $player;
            $api->new($player, $pl->getName(), TE::BOLD . '§l§b》YGC §fNetwork《');
            $api->setLine($pl, 7, TE::RESET . "§7────────");
            $api->setLine($pl, 6, TE::GRAY . "§bRank: §7Unknow");
            $api->setLine($pl, 5, TE::RED . "§a§e");
            $api->setLine($pl, 2, TE::GRAY . "§bPing: §7". $player->getPing());
            $api->setLine($pl, 1, TE::GRAY . "§7────────");
            $api->setLine($pl, 0, TE::GRAY . "§b@YGCNetwork");

            $api->getObjectiveName($pl);
       // }
    }



}
