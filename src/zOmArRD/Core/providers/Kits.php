<?php
declare(strict_types=1);

namespace zOmArRD\core\providers;


use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;

class Kits {

    public static function setKit(Player $player, int $kit){

        switch ($kit){
            case 0:
                $player->setGamemode(0);
                $player->getInventory()->clearAll();
                $player->getArmorInventory()->clearAll();
                $player->setAllowFlight(false);
                $player->setFlying(false);
                $helmet = Item::get(Item::DIAMOND_HELMET, 0, 1);
                $chestplate = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
                $leggings = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
                $boots = Item::get(Item::DIAMOND_BOOTS, 0, 1);
                $sword = Item::get(Item::DIAMOND_SWORD, 0, 1);
                $unbreakable = Enchantment::getEnchantment(17);

                $protection = Enchantment::getEnchantment(0);
                $protecc = new EnchantmentInstance($protection, 1);

                $sharpness = Enchantment::getEnchantment(9);
                $filo = new EnchantmentInstance($sharpness, 1);

                $enchantmentInstance = new EnchantmentInstance($unbreakable, 2);
                $helmet->addEnchantment($enchantmentInstance);
                $chestplate->addEnchantment($enchantmentInstance);
                $leggings->addEnchantment($enchantmentInstance);
                $boots->addEnchantment($enchantmentInstance);

                $helmet->addEnchantment($protecc);
                $chestplate->addEnchantment($protecc);
                $leggings->addEnchantment($protecc);
                $boots->addEnchantment($protecc);

                $sword->addEnchantment($enchantmentInstance);
                $sword->addEnchantment($filo);
                $player->getArmorInventory()->setHelmet($helmet);
                $player->getArmorInventory()->setChestplate($chestplate);
                $player->getArmorInventory()->setLeggings($leggings);
                $player->getArmorInventory()->setBoots($boots);
                $player->getInventory()->addItem($sword);
                $player->getInventory()->setItem(1, Item::get(Item::GOLDEN_APPLE, 0, 12));
                break;
            case 4:
                $player->setGamemode(0);
                $player->getInventory()->clearAll();
                $player->getArmorInventory()->clearAll();
                $player->setAllowFlight(false);
                $player->setFlying(false);
                $scrim = Item::get(320, 0, 32);

                $player->getInventory()->addItem($scrim);
                break;
            default:
                break;
        }
    }
}