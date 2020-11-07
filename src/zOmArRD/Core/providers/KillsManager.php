<?php

namespace zOmArRD\core\providers;

use pocketmine\Player;
use zOmArRD\core\Main;

class KillsManager {
    public static $kills;
	protected $plugin;
	
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}

    /**
     * @param Player $player
    */
    public function setKills(Player $player){
    	self::$kills = $this->plugin->getConfiguration("kills");
    	self::$kills->set($player->getName(), self::$kills->get($player->getName()) + 1);
    	self::$kills->save();
    }
    

    /**
     * @param Player $player
    */
    public function getKills(Player $player){
    	self::$kills = $this->plugin->getConfiguration("kills");
    	return self::$kills->get($player->getName());
    }	
}