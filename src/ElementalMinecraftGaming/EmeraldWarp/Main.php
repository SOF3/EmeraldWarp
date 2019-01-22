<?php

namespace ElementalMinecraftGaming\EmeraldWarp;

use pocketmine\CommandReader;
use pocketmine\CommandExecuter;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat;
use pocketmine\level\{Level,Position,ChunkManager};
use pocketmine\Server;

class Main extends PluginBase implements listener {

    private $config;

    public function onEnable() {
        $this->getLogger()->info("Created by MrDevCat -Discord- ");
        @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($sender->hasPermission("emerald.setwarp")) {
            if (strtolower($command->getName()) == "emeraldsetwarp") {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $sender->sendMessage(TextFormat::GOLD . "Setting warp");
                        $a = $sender->getLevel()->getFolderName();
                        $z = $sender->getZ();
                        $x = $sender->getX();
                        $y = $sender->getY();
                        $warp = $args[0];
                        $config = $this->getConfig();
                        $config->set($warp, [$a, $x, $y, $z]);
                        $config->save();
                        $sender->sendMessage(TextFormat::GOLD . "Warp $warp set at: $a, $x, $y, $z");
                        return true;
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Warp creation failed: No perms!");
                        return false;
                    }
                }
            }
        }

        if ($sender->hasPermission("emerald.warp")) {
            if (strtolower($command->getName()) == "emeraldwarp") {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $warp = $args[0];
                        $config = $this->getConfig();
                        $data = $config->get($args[0]);
                        if (is_array($data)) {
                            $land = $data[0];
                            $x = $data[1];
                            $y = $data[2];
                            $z = $data[3];
                        }
                        $sender->sendMessage(TextFormat::GOLD . "Warping $warp at $land, $x, $y, $z!");
                        $sender->teleport(new Position($x, $y, $z, $this->getServer()->getLevelByName($land))); //
                        return true;
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Warp failed: Not set or no perms!");
                        return false;
                    }
                }
            }
        }

	if ($sender->hasPermission("emerald.delwarp")) {
            if (strtolower($command->getName()) == "emeraldelwarp") {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $warp = $args[0];
                        $config = $this->getConfig();
			unset($config->$warp);
			$this->getConfig()->save();
                        return true;
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Delete failed: Not set or no perms!");
                        return false;
                    }
                }
            }
        }

        if ($sender->hasPermission("emerald.listw")) {
            if (strtolower($command->getName()) == "emeraldlistwarps") {
                if ($sender instanceof Player) {
                    $config = $this->getConfig();
                    $list = $this->config->getAll();
                    $warps = implode(", ", $list);
                    $sender->sendMessage("----------");
                    $sender->sendMessage($warps);
		    $sender->sendMessage("----------");
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Warp List failed: Not set or no perms!");
                    return false;
                }
            }
        }
    }
}
