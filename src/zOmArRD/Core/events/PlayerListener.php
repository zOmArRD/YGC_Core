<?php
declare(strict_types=1);

namespace zOmArRD\core\events;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\LeavesDecayEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\level\Position;
use pocketmine\Server;
use zOmArRD\core\providers\BossAPI;
use zOmArRD\core\utils\DeviceData;
use zOmArRD\core\utils\PlayerUtils;
use pocketmine\Player;

/**
 * Class PlayerListener
 * @package zOmArRD\core\events
 * @author zOmArRD
 */
class PlayerListener implements Listener
{
    use PlayerUtils;

    public function playerJoin(PlayerJoinEvent $ev) : void {
        $player = $ev->getPlayer();

        $this->healPlayer($player);
        $this->clearPlayer($player);
        $this->joinServer($player);
        $this->LobbyItems($player);

        BossAPI::sendBossBarText($player, "§l§bYGC §fNetwork");
        if ($player->hasPermission("ygc.fly")){
            $player->setAllowFlight(true);
        } else {
            $player->setAllowFlight(false);
        }
        $device = DeviceData::getDeviceName($player);
        $controller = DeviceData::getController($player);
        $player->setScoreTag("§l§★§a".$device."§7 | §f$controller");

    }

    /**
     * @param PlayerExhaustEvent $ev
     */
    public function PlayerExhaustEvent(PlayerExhaustEvent $ev) : void {
        $player = $ev->getPlayer();
        $level = $player->getLevel()->getName();
        $world = Server::getInstance()->getDefaultLevel()->getName();
        if ($level == $world) {
            $ev->setCancelled(true);
        }
    }

    /**
     * @param BlockBreakEvent $ev
     */
    public function BlockBreakEvent(BlockBreakEvent $ev) : void {
        $player = $ev->getPlayer();
        $level = $player->getLevel()->getName();
        foreach (["gapple", "lobby13", "fist", "nodebuff", "scrim", "resistance"] as $world){
            if ($level == $world) {
                $ev->setCancelled(true);
                if ($player->isOp()) {
                    $ev->setCancelled(false);
                }
            }
        }
    }

    /**
     * @param BlockPlaceEvent $ev
     */
    public function BlockPlaceEvent(BlockPlaceEvent $ev) : void {
        $player = $ev->getPlayer();
        $level = $player->getLevel()->getName();
        foreach (["gapple", "lobby13", "fist", "nodebuff", "scrim", "resistance"] as $world){
            if ($level == $world) {
                $ev->setCancelled(true);
                if ($player->isOp()) {
                    $ev->setCancelled(false);
                }
            }
        }
    }

    /**
     * @param PlayerDropItemEvent $event
     */
    public function NoDropLobby(PlayerDropItemEvent $ev) : void {
        $player = $ev->getPlayer();
        $level = $player->getLevel()->getName();
        foreach (["gapple", "lobby13", "fist", "nodebuff", "scrim", "resistance"] as $world){
            if ($level == $world) {
                $ev->setCancelled(true);
                if ($player->isOp()) {
                    $ev->setCancelled(false);
                }
            }
        }
    }

    public function noFallDamage(EntityDamageEvent $event)
    {
        if ($event->getCause() === EntityDamageEvent::CAUSE_FALL) {
            $event->setCancelled(true);
        }
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function EntityDamageEvent(EntityDamageEvent $event) : void {
        $player = $event->getEntity();
        $level = $player->getLevel()->getName();
        $world = Server::getInstance()->getDefaultLevel()->getName();
        if ($level == $world) {
            if ($player instanceof Player) {

                $event->setCancelled(true);
            }
        }
    }

    /**
     * @param InventoryTransactionEvent $event
     */
    public function noChangeItemSlot(InventoryTransactionEvent $event) : void {
        $entity = $event->getTransaction()->getSource();
        if ($entity->getLevel()->getName() === "lobby") {
            $event->setCancelled(true);
            if ($entity->isOp()) {
                $event->setCancelled(false);
            }
        }
    }

    /**
     * @param LeavesDecayEvent $ev
     */
    public function onDecay(LeavesDecayEvent $ev) : void {
        $ev->setCancelled(true);
    }

    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();

        $event->setRespawnPosition(new Position(2.00, 58.00, -51.00, Server::getInstance()->getLevelByName("lobby13")));
        $this->LobbyItems($player);
    }

}
