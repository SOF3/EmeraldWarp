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

class Main extends PluginBase implements listener {

    private $config;

    public function onEnable() {
        $this->getLogger()->info(TextFormat::GREEN . "Created by MrDevCat -Discord- ");
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
                        $leveled = $sender->getLevel()->getFolderName();
                        $z = $sender->getZ();
                        $x = $sender->getX();
                        $y = $sender->getY();
                        $warp = $args[0];
                        $config = $plugin->getConfig();
                        $config->set([$leveled, $x, $y, $z, "entry 2"], $warp);
                        $config->save();
                        $sender->sendMessage(TextFormat::GOLD . "Warp set at: $leveled, $x, $y, $z");
                        return true;
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Warp creation failed!");
                        return false;
                    }
                }
            }
        }

        if ($sender->hasPermission("emerald.warp")) {
            if (strtolower($command->getName()) == "emeraldwarp") {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $warpp = $args[0];
                        $configg = $plugin->getConfig();
                        $configg->get([$leveled, $x, $y, $z, "entry 2"], $warpp);
                        $sender->sendMessage(TextFormat::GOLD . "Warping!");
                        $sender->teleport(new Position($leveled, $x, $y, $z));
                        return true;
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Warp failed: Not set or no perms!");
                        return false;
                    }
                }
            }
        }
    }
}
