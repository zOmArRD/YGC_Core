<?php
declare(strict_types=1);
namespace core\entity;

use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;

class NPC extends Human
{
    public function __construct(Level $level, CompoundTag $nbt)
    {
        parent::__construct($level, $nbt);
        $this->propertyManager->setFloat(self::DATA_SCALE, 1.00);
    }

    public function getName(): string
    {
        return "";
    }
}
