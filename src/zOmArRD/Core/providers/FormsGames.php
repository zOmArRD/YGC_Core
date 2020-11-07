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
                       $player->teleport(new Position(249.00, 43.00, 253.00, Server::getInstance()->getLevelByName("gapple")));
                       Kits::setKit($player, 0);
                       break;
                   case 1:
                       $player->sendMessage(Main::PREFIX. "§7Joining to Fist FFA");
                       $player->teleport(new Position(256.00, 39.00, 257.00, Server::getInstance()->getLevelByName("fist")));
                       Kits::setKit($player, 1);
                       break;
                   case 2:
                       $player->sendMessage(Main::PREFIX. "§7Joining to NoDebuff FFA");
                       $player->teleport(new Position(256.00, 34.00, 256.00, Server::getInstance()->getLevelByName("nodebuff")));
                       Kits::setKit($player, 2);
                       break;
                   case 3:
                       $player->sendMessage(Main::PREFIX. "§7Joining to Resistance FFA");
                       $player->teleport(new Position(255.00, 34.00, 255.00, Server::getInstance()->getLevelByName("nodebuff")));
                       Kits::setKit($player, 3);
                       break;
                   case 4:
                      $player->sendMessage(Main::PREFIX. "§7Joining to Scrim");
                       $player->teleport(new Position(257, 39, 256, Server::getInstance()->getLevelByName("scrim")));
                       Kits::setKit($player, 4);
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
        $pl_scrim = count(Server::getInstance()->getLevelByName("scrim")->getPlayers());
        $form->addButton("§7» §6Gapple §7«\n" . "§a" . $pl_gapple . " §7players", 0, $images["gapple"]);
        $form->addButton("§7» §cFist §7«\n" . "§a" . $pl_fist . " §7players", 0, $images["fist"]);
        $form->addButton("§7» §bNoDebuff §7«\n" . "§a" . $pl_nodebuff . " §7players", 0, $images["nodebuff"]);
        $form->addButton("§7» §gResistance §7«\n" . "§a" . $pl_resistance . " §7players", 0, $images["fist"]);
        $form->addButton("§7» §dScrims §7«\n" . "§a" . $pl_scrim . " §7players", 0, $images["scrims"]);
        $player->sendForm($form);
    }

}