<?php
declare(strict_types=1);

namespace zOmArRD\core\events;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InteractPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\Player;
use core\providers\BungeeCord;
use core\Main;
use core\entity\NPC;
use core\server\Server;
use core\server\ServerManager;
use core\providers\FormAPI\SimpleForm;


class EntityListener implements Listener
{
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onHitNpc(EntityDamageByEntityEvent $ev)
    {
        $entity = $ev->getEntity();
        $damager = $ev->getDamager();
        if ($entity instanceof NPC) {
            if ($ev->getDamager() instanceof Player) {
                switch ($entity->getSkin()->getSkinId()) {
                    case "creative":
                        $creative = ServerManager::getServerByName("creative1");
                        $msg = "§l§c» §r§7Could not connect to the server.";
                        if ($creative && $creative->isOnline()) {
                            if ($creative->getOnlinePlayers() >= 200 && !$damager->hasPermission("endgames.bypass.fullserver")) {
                                $msg = "§l§6» §r§7The server is full, to enter buy your Rank at §ehttps://shop.endgames.cf";
                            } else {
                                $msg = "§l§a» §r§7Connecting to the database...";
                                BungeeCord::transferPlayer($damager, "creative1");
                            }
                            $damager->sendMessage($msg);
                        } else {
                            $damager->sendMessage($msg);
                        }
                        break;
                    case "practice":
                        self::PracticeLobbySelector($damager);
                        break;
                    case "comboffa":
                        $combo = ServerManager::getServerByName("ffa1");
                        $msg = "§l§c» §r§7Could not connect to the server.";
                        if ($combo && $combo->isOnline()) {
                            if ($combo->getOnlinePlayers() >= 50 && !$damager->hasPermission("endgames.bypass.fullserver")) {
                                $msg = "§l§6» §r§7The server is full, to enter buy your Rank at §ehttps://shop.endgames.cf";
                            } else {
                                $msg = "§l§a» §r§7Connecting to the database...";
                                BungeeCord::transferPlayer($damager, "ffa1");
                            }
                            $damager->sendMessage($msg);
                        } else {
                            $damager->sendMessage($msg);
                        }
                        break;
                }
                $ev->setCancelled();
            } else {
                $ev->setCancelled();
            }
        }
    }

    /**
     * @param DataPacketReceiveEvent $source
     */
    public function onInventoryTransaction(DataPacketReceiveEvent $source)
    {
        $player = $source->getPlayer();
        if ($source->getPacket() instanceof InventoryTransactionPacket) {
            try {
                $action = $source->getPacket()->trData->actionType == InventoryTransactionPacket::USE_ITEM_ON_ENTITY_ACTION_INTERACT;
            } catch (\ErrorException $e) {
                return;
            }
            if ($action) {
                try {
                    $target = $source->getPlayer()->level->getEntity($source->getPacket()->trData->entityRuntimeId);
                } catch (\ErrorException $e) {
                    return;
                }
                if ($target instanceof NPC) {
                    switch ($target->getSkin()->getSkinId()) {
                        case "creative":
                            $creative = ServerManager::getServerByName("creative1");
                            $msg = "§l§c» §r§7Could not connect to the server.";
                            if ($creative && $creative->isOnline()) {
                                if ($creative->getOnlinePlayers() >= 200 && !$player->hasPermission("endgames.bypass.fullserver")) {
                                    $msg = "§l§6» §r§7The server is full, to enter buy your Rank at §ehttps://shop.endgames.cf";
                                } else {
                                    $msg = "§l§a» §r§7Connecting to the database...";
                                    BungeeCord::transferPlayer($player, "creative1");
                                }
                                $player->sendMessage($msg);
                            } else {
                                $player->sendMessage($msg);
                            }
                            break;
                        case "practice":
                            self::PracticeLobbySelector($player);
                            break;
                        case "comboffa":
                            $combo = ServerManager::getServerByName("ffa1");
                            $msg = "§l§c» §r§7Could not connect to the server.";
                            if ($combo && $combo->isOnline()) {
                                if ($combo->getOnlinePlayers() >= 50 && !$player->hasPermission("endgames.bypass.fullserver")) {
                                    $msg = "§l§6» §r§7The server is full, to enter buy your Rank at §ehttps://shop.endgames.cf";
                                } else {
                                    $msg = "§l§a» §r§7Connecting to the database...";
                                    BungeeCord::transferPlayer($player, "ffa1");
                                }
                                $player->sendMessage($msg);
                            } else {
                                $player->sendMessage($msg);
                            }
                            break;
                        case "skywars":
                            break;
                        case "buildffa":
                            break;
                    }
                }
            }
        }
    }

    /** Practice Form For Lobbys */
    public function PracticeLobbySelector(Player $player){
        $servers = ServerManager::getGroup("practice")->getServers();
        $form = new SimpleForm(function (Player $player, $data){
            if (!is_null($data)){
                $msg = "§l§c» §r§7Could not connect to the server.";
                if($data !== "exit"){
                    $server = ServerManager::getServerByName($data);
                    if($server && $server->isOnline()){
                        if($server->getOnlinePlayers() >= 40 && !$player->hasPermission("endgames.bypass.fullserver")){
                            $msg = "§l§6» §r§7The server is full, to enter buy your Rank at §ehttps://shop.endgames.cf";
                        } else {
                            $msg = "§l§a» §r§7Connecting to the database...";
                            BungeeCord::transferPlayer($player, $data);
                        }
                        $player->sendMessage($msg);
                    } else {
                        $player->sendMessage($msg);
                    }
                }
            }
        });
        $form->setTitle("§l§cEnd§fGames §7| §6Practice");
        $images = [
            "return" => "textures/ui/refresh_light",
            "lobby" => "textures/gui/newgui/mob_effects/strength_effect",
            "exit" => "textures/ui/crossout"
        ];
        for($i = 1; $i < count($servers) +1; $i++){
            $server = $servers[$i -1];
            if($server instanceof Server){
                $players = $server->isOnline() ? $server->getOnlinePlayers() : "§cOFFLINE";
                $form->addButton("§l§6Arena PvP $i\n§r§7Players Connected: §a".$players, 0, $images["lobby"], $server->getName());
            }
        }
        $form->addButton("§cClose", 0, $images["exit"], "exit");
        $player->sendForm($form);
    }


}