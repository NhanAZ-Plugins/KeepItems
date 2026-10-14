<?php

declare(strict_types=1);

namespace NhanAZ\KeepItems;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

final class Main extends PluginBase implements Listener{
	private bool $keepInventory = true;
	private bool $messageAfterDeath = false;
	private string $messageToPlayerAfterDeath = "§aItems in your inventory have been kept";
	private string $messageType = "message";
	private bool $notices = true;

	protected function onEnable() : void{
		$this->saveDefaultConfig();
		$config = $this->getConfig();
		$this->keepInventory = $this->readBooleanOption($config, "KeepInventory", true);
		$this->messageAfterDeath = $this->readBooleanOption($config, "MessageAfterDeath", false);
		$this->notices = $this->readBooleanOption($config, "Notices", true);

		$message = $config->get("MessageToPlayerAfterDeath", $this->messageToPlayerAfterDeath);
		if(is_string($message)){
			$this->messageToPlayerAfterDeath = $message;
		}else{
			$this->getLogger()->warning("MessageToPlayerAfterDeath must be a string; using the default message.");
		}

		$messageType = $config->get("MessageType", "message");
		if(is_string($messageType) && in_array(strtolower($messageType), ["message", "popup", "tip", "title", "subtitle", "actionbarmessage"], true)){
			$this->messageType = strtolower($messageType);
		}else{
			$this->getLogger()->warning("MessageType is invalid; using message.");
		}

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if($this->notices){
			$this->getLogger()->notice($this->keepInventory ? "Inventory retention on death is enabled." : "Inventory retention is disabled; other plugins may still retain inventory.");
		}
	}

	public function onPlayerDeath(PlayerDeathEvent $event) : void{
		if(!$this->keepInventory){
			return;
		}

		$event->setKeepInventory(true);
		if(!$this->messageAfterDeath){
			return;
		}

		$player = $event->getPlayer();
		switch($this->messageType){
			case "popup":
				$player->sendPopup($this->messageToPlayerAfterDeath);
				break;
			case "tip":
				$player->sendTip($this->messageToPlayerAfterDeath);
				break;
			case "title":
				$player->sendTitle($this->messageToPlayerAfterDeath);
				break;
			case "subtitle":
				$player->sendTitle("", $this->messageToPlayerAfterDeath);
				break;
			case "actionbarmessage":
				$player->sendActionBarMessage($this->messageToPlayerAfterDeath);
				break;
			default:
				$player->sendMessage($this->messageToPlayerAfterDeath);
				break;
		}
	}

	private function readBooleanOption(Config $config, string $key, bool $default) : bool{
		$value = $config->get($key, $default);
		if(!is_bool($value)){
			$this->getLogger()->warning($key . " must be true or false; using its default value.");
			return $default;
		}
		return $value;
	}
}
