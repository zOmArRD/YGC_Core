<?php
declare(strict_types=1);

namespace zOmArRD\core\providers;

use pocketmine\level\Position;
use pocketmine\Server;
use zOmArRD\core\Main;
use zOmArRD\core\providers\FormAPI\SimpleForm;
use pocketmine\Player;

class FormsGames {

    public static function serversForm(Player $player){
        $form = new SimpleForm(function (Player $player, ?int $data){
           if (!is_null($data)){
               switch ($data){
                   case 0:
                       $player->sendMessage(Main::PREFIX. "§7Joining to Gapple FFA");
                       $player->teleport(new Position(249.00, 23.00, 253.00, Server::getInstance()->getLevelByName("gapple")));
                       Kits::setKit($player, 0);
                       break;
                   default:
                       return;
               }
           }
        });

        $form->setTitle("§l§7» §bYGC §fNetwork §7«");
        $form->setContent("§eSelect which ffa you want to transfer to");
        $images = [
            "ServerPractice" => "textures/gui/newgui/mob_effects/strength_effect",
        ];


        $form->addButton("§7» §6Gapple §7«\n" . "Click to enter to gapple ffa", 0, $images["ServerPractice"]);
        $player->sendForm($form);
    }

}