<?php
/**
 * Created by PhpStorm.
 * User: zOmArRD
 *       ___               _         ____  ____
 *  ____/ _ \ _ __ ___    / \   _ __|  _ \|  _ \
 * |_  / | | | '_ ` _ \  / _ \ | '__| |_) | | | |
 *  / /| |_| | | | | | |/ ___ \| |  |  _ <| |_| |
 * /___|\___/|_| |_| |_/_/   \_\_|  |_| \_\____/
 *
 */
namespace zOmArRD\core\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use zOmArRD\core\Main;

/**
 * Class HubCmd
 * @package zOmArRD\core\commands
 */
class HubCmd extends Command
{
    protected $description;
    protected $usageMessage;
    protected $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("hub");
        $this->description = "Return to the lobby.";
        $this->usageMessage = "/hub";
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if(!$sender instanceof Player){
            return true;
        }

        $sender->teleport(new Position(2.00, 58.00, -51.00, Server::getInstance()->getLevelByName("lobby13")));
        return true;
    }
}