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
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array("example" => "world 123 134 543"));
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
  
//ToDo
