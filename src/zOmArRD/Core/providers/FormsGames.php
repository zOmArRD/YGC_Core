<?php
declare(strict_types=1);

namespace zOmArRD\core\providers;

use pocketmine\level\Position;
use pocketmine\Server;
use zOmArRD\core\Main;
use zOmArRD\core\providers\FormAPI\SimpleForm;
use pocketmine\Player;

/**
 * Class FormsGames
 * @package zOmArRD\core\providers
 * @author zOmArRD
 */
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
                       $player->sendMessage(Main::PREFIX . "§cHa ocurrido un error.");
                       return;
               }
           }
        });

        $form->setTitle("§l§7» §bYGC §fNetwork §7«");
        $form->setContent("§eSelect which ffa you want to transfer to");
        $images = [
            "gapple" => "textures/items/apple_golden",
            "fist" => "textures/items/beef_cooked",
            "nodebuff" => "textures/items/potion_bottle_splash_heal",
            "scrims" => "textures/items/stick",
        ];

        $pl_gapple = count(Server::getInstance()->getLevelByName("gapple")->getPlayers());
        $pl_fist = count(Server::getInstance()->getLevelByName("fist")->getPlayers());
        $pl_nodebuff = count(Server::getInstance()->getLevelByName("nodebuff")->getPlayers());
        $pl_resistance = count(Server::getInstance()->getLevelByName("resistance")->getPlayers());
        $form->addButton("§7» §6Gapple §7«\n" . "§a" . $pl_gapple . " §7players", 0, $images["gapple"]);
        $form->addButton("§7» §cFist §7«\n" . "§a" . $pl_fist . " §7players", 0, $images["fist"]);
        $form->addButton("§7» §bNoDebuff §7«\n" . "§a" . $pl_nodebuff . " §7players", 0, $images["nodebuff"]);
        $form->addButton("§7» §gResistance §7«\n" . "§a" . $pl_resistance . " §7players", 0, $images["fist"]);
        $form->addButton("§7» §dScrims §7«\n" . "§a" . $pl_resistance . " §7players", 0, $images["scrims"]);
        $player->sendForm($form);
    }

}