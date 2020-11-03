<?php
declare(strict_types=1);

namespace zOmArRD\core;

use pocketmine\network\mcpe\protocol\types\SkinAdapterSingleton;
use pocketmine\plugin\PluginBase;
use zOmArRD\core\events\DataPacketListener;
use zOmArRD\core\events\ItemListener;
use zOmArRD\core\events\PlayerListener;
use zOmArRD\core\utils\ParsonaSkinAdapter;

/**
 * Class Main
 * @package zOmArRD\core
 * @author zOmArRD
 */
class Main extends PluginBase
{

    /** @var $instance */
    public static $instance;

    /** @var null $originalAdaptor */
    private $originalAdaptor = null;

    /** @var string $PREFIX */
    public const PREFIX = "§7[§bYGC§7] §r";

    /**
     * Returns an instance of the plugin
     * @return mixed
     */
    public static function getInstance() : Main
    {
        return self::$instance;
    }

    public function getPrefix(){
        return self::PREFIX;
    }


    public function onLoad() : void
    {   /** @var  instance */
        self::$instance = $this;
    }

    public function onEnable()
    {

        $server = $this->getServer();

        $logger = $this->getLogger();

        /** @var  originalAdaptor */
        $this->originalAdaptor = SkinAdapterSingleton::get();
        SkinAdapterSingleton::set(new ParsonaSkinAdapter());

        $lobby = $server->getLevelByName("lobby13");
        $lobby->setTime(0);
        $lobby->stopTime();

        $this->registerEvents();

        $logger->info("§aPlugin enabled");
    }

    public function registerEvents() : void {
        $manager = $this->getServer()->getPluginManager();

        $manager->registerEvents(new PlayerListener(), $this);
        $manager->registerEvents(new ItemListener(), $this);
        $manager->registerEvents(new DataPacketListener(), $this);
    }
}
