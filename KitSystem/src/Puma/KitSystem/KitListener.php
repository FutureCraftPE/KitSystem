<?php

namespace Puma\KitSystem;

use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\Config;

class KitListener {

	public function __construct($plugin, Inventory $inv)
	{
		/**
		 * @param KitSystem $plugin
		 * @param Player $player
		 */
		 
		$this->plugin = $plugin;
		$this->inv = $inv;
	}

	public function onTransaction(Player $player, Item $itemClickedOn, Item $itemClickedWith)
	{
		if($itemClickedOn->getCustomName() == "§6Gold Kit") {
			$player->removeAllWindows();
			$player->sendMessage($this->plugin->prefix . "§aDu hast das §6Gold Kit §aerhalten!");
			$this->plugin->goldkit($player);
		}elseif($itemClickedOn->getCustomName() == "§bDiamond Kit") {
			$player->removeAllWindows();
			$player->sendMessage($this->plugin->prefix . "§aDu hast das §bDiamond Kit §aerhalten!");
			$this->plugin->diakit($player);
		}elseif($itemClickedOn->getCustomName() == "§8Bedrock Kit") {
			$player->removeAllWindows();
			$player->sendMessage($this->plugin->prefix . "§aDu hast das §8Bedrock Kit §aerhalten!");
		}
	}

}