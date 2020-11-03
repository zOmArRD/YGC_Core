<?php
declare(strict_types=1);

namespace zOmArRD\core\events;

use zOmArRD\core\providers\FormsGames;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Server;

class ItemListener implements Listener
{

    public function playerInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $pi = $player->getInventory();
        $id = $event->getItem()->getId();
        $custom = $event->getItem()->getCustomName();


        if ($id == Item::COMPASS && $custom == "§aGames"){
            FormsGames::serversForm($player);
        }


    }

}