<?php
declare(strict_types=1);

namespace zOmArRD\core\utils;

use pocketmine\item\Item;

use pocketmine\level\Position;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TE;
use zOmArRD\core\providers\BossAPI;

/**
 * Trait PlayerUtils
 * @package core\utils
 * @author zOmArRD
 */
trait PlayerUtils{

    public function healPlayer(Player $player){
        $player->setGamemode(2);
        $player->setHealth(20);
        $player->setFood(20);
    }

    public function clearPlayer(Player $player){
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getCursorInventory()->clearAll();
        $player->removeAllEffects();
    }

    public function joinServer(Player $player){
        $pn = $player->getName();

        $player->setAutoJump(true);
        $player->teleport(new Position(2.00, 58.00, -51.00, Server::getInstance()->getLevelByName("lobby13")));
        $player->addTitle("§b§lYGC §fNetwork", "§fWelcome $pn", 35, 75, 35);
        $player->getLevel()->addSound(new EndermanTeleportSound(new Vector3($player->getX(), $player->getY(), $player->getZ())));

    }

    public function LobbyItems(Player $player){

        $cosmetics = Item::get(Item::NETHER_STAR, 0, 1);
        $cosmetics->setCustomName("§aCosmetics");

        $navigator = Item::get(Item::COMPASS, 0, 1);
        $navigator->setCustomName("§aGames");

        $bow = Item::get(Item::BOW, 0, 1);
        $bow->setCustomName("§aBow Teleporter");


        $stats = Item::get(397, 3, 1);
        $stats->setCustomName("§7§l» §aProfile & Stats §7«");

        $player->getArmorInventory()->clearAll();
        $player->getInventory()->clearAll();
        $player->removeAllEffects();
        BossAPI::sendBossBarText($player, "§l§bYGC §fNetwork");

        $player->getInventory()->setItem(1, $cosmetics);

        $player->getInventory()->setItem(4, $navigator);

        $player->getInventory()->setItem(7, $bow);
    }

}