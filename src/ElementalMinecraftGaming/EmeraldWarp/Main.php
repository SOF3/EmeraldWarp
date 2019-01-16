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
					$sender->sendMessage(TextFormat::GOLD . "Setting warp");
					$player = $this->getPlayer();
					//ToDo
					$leveled = $player->getLevel()->getFolderName();
					$z = $player->getZ();
					$x = $player->getX();
					$y = $player->getY();
					$this->getConfig->set("$warpname", $leveled, $x, $y, $z);
					$this->getConfig->save();
					$sender->sendMessage(TextFormat::GOLD . "Warp set at: $leveled, $x, $y, $z");
					return true;
				} else {
					sender->sendMessage(TextFormat::RED . "Incorrect usage or privlages!");
					return false;
				}
			}
			
			if ($sender->hasPermission("emerald.warp")) {
				if (strtolower($command->getName()) == "emeraldwarp") {
					if ($sender instanceof Player) {
						$sender->sendMessage(TextFormat::GOLD . "Warping!");
						//ToDo
						return true;
					} else {
						$sender->sendMessage(TextFormat::RED . "Potty trouble!");
						return false;
