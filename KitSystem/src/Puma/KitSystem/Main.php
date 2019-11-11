<?php

declare(strict_types=1);

namespace Puma\KitSystem;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use muqsit\invmenu\{InvMenu,InvMenuHandler};
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\utils\Config;
use pocketmine\inventory;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\block\Block;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerTransferEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\ProtectionEnchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\utils\TextFormat as f;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class Main extends PluginBase implements Listener{
	
	public $prefix = "§bKitSystem §8> §f";

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info($this->prefix . "wurde erfolgreich geladen!");
        $this->saveDefaultConfig();
        $this->reloadConfig();
		if (!InvMenuHandler::isRegistered()) {
			InvMenuHandler::register($this);
		}
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		switch($command->getName()){
			case "kit":
					$sender->sendMessage($this->prefix . "Dir wird nun das Kit Menu angezeigt!");
					$this->menu($sender);
			return true;
		}
	}
	
	public function menu(Player $player) {
		
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$menu->setName("§bKitSystem");
		$menu->readonly();
		$minv = $menu->getInventory();
		$air = Item::get(Item::STAINED_GLASS_PANE, 8)->setCustomName("");
		$air = Item::get(Item::AIR);;
		$d = Item::get(264)->setCustomName("§bDiamond Kit");
		$g = Item::get(266)->setCustomName("§6Gold Kit");
		$b = Item::get(7)->setCustomName("§8Bedrock Kit");
		$minv->setItem(0, $air);
		$minv->setItem(1, $air);
		$minv->setItem(2, $air);
		$minv->setItem(3, $air);
		$minv->setItem(4, $air);
		$minv->setItem(5, $air);
		$minv->setItem(6, $air);
		$minv->setItem(7, $air);
		$minv->setItem(8, $air);
		$minv->setItem(9, $g);
		$minv->setItem(10, $air);
		$minv->setItem(11, $air);
		$minv->setItem(12, $air);
		$minv->setItem(13, $d);
		$minv->setItem(14, $air);
		$minv->setItem(15, $air);
		$minv->setItem(16, $air);
		$minv->setItem(17, $b);
		$minv->setItem(18, $air);
		$minv->setItem(19, $air);
		$minv->setItem(20, $air);
		$minv->setItem(21, $air);
		$minv->setItem(22, $air);
		$minv->setItem(23, $air);
		$minv->setItem(24, $air);
		$minv->setItem(25, $air);
		$minv->setItem(26, $air);
		$menu->send($player);
		$menu->setListener([new KitListener($this, $menu->getInventory()), "onTransaction"]);
	}
	
	public function goldkit(Player $player){
		
		$boots = Item::get(314);
		$hose = Item::get(315);
		$chest = Item::get(316);
		$helm = Item::get(317);
		$enchantment = Enchantment::getEnchantment(17);
        $level = 3;
        $hb = new EnchantmentInstance($enchantment, $level);
        $boots->addEnchantment($hb);
		$hose->addEnchantment($hb);
		$chest->addEnchantment($hb);
		$helm->addEnchantment($hb);
		$player->getInventory()->addItem($boots);
		$player->getInventory()->addItem($hose);
		$player->getInventory()->addItem($chest);
		$player->getInventory()->addItem($helm);
	}
	
	public function diakit(Player $player){
		
		$boots = Item::get(310);
		$hose = Item::get(311);
		$chest = Item::get(312);
		$helm = Item::get(313);
		$enchantment = Enchantment::getEnchantment(17);
        $level = 1;
        $hb = new EnchantmentInstance($enchantment, $level);
        $boots->addEnchantment($hb);
		$hose->addEnchantment($hb);
		$chest->addEnchantment($hb);
		$helm->addEnchantment($hb);
		$player->getInventory()->addItem($boots);
		$player->getInventory()->addItem($hose);
		$player->getInventory()->addItem($chest);
		$player->getInventory()->addItem($helm);
		
	}
	
	public function bedrockkit(Player $player){
		
	}
	
	public function onDisable() : void{
		$this->getLogger()->info("Bye");
	}
}
