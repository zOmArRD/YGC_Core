<?php
declare(strict_types=1);

namespace zOmArRD\core;


use pocketmine\plugin\PluginBase;

/**
 * Class Main
 * @package zOmArRD\core
 * @author zOmArRD
 */
class Main extends PluginBase
{

    public function onEnable()
    {
        $logger = $this->getLogger();

        $logger->info("§aPlugin enabled");
    }
}
