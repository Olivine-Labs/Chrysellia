<?php

namespace Database\MySQL;

define('SQL_LOADITEM', 'SELECT i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.sockets, ie.slots, ie.slotType, is.socketedIn FROM `items` i LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` is ON i.itemId=is.itemId WHERE i.itemId=?');
define('SQL_LOADITEM_TEMPLATE', 'SELECT it.name, it.description, it.buyPrice, it.sellPrice, it.itemType, it.createdOn, ite.sockets, ite.slots, ite.slotType, ite.onEquip, ite.onUnequip, ite.onAttack, ite.onDefend, its.onSocket FROM `item_templates` it LEFT JOIN `item_template_equippables` ite ON it.itemTemplateId=ite.itemTemplateId LEFT JOIN `item_template_socketables` its ON it.itemTemplateId=its.itemTemplateId LEFT JOIN `item_template_comsumables` itc ON itc.itemTemplateId=it.itemTemplateId WHERE it.itemTemplateId=?');
define('SQL_LOADINVENTORY', 'SELECT i.itemId, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.sockets, ie.slots, ie.slotType FROM `items` i INNER JOIN `inventories` in ON i.inventoryId=in.inventoryId LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` is ON i.itemId=is.itemId WHERE in.characterId=? AND is.socketedIn IS NULL');

define('SQL_INSERTITEM', 'INSERT INTO  `items` (`itemId`, `itemTemplateId`, `itemType`, `inventoryId`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_CONSUMABLE', 'INSERT INTO  `item_consumables` (`itemId`, `onUse`) VALUES (?, ?)');
define('SQL_INSERTITEM_EQUIPPABLE', 'INSERT INTO  `item_equippables` (`itemId`, `sockets`, `slots`, `slotType`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_SOCKETABLE', 'INSERT INTO  `item_socketables` (`itemId`, `socketedIn`, `onSocket`) VALUES (?, ?, ?)');

define('SQL_INSERTITEM_TEMPLATE', 'INSERT INTO  `item_templates` (`itemTemplateId`, `itemType`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES (?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_TEMPLATE_CONSUMABLE', 'INSERT INTO  `item_template_consumables` (`itemTemplateId`, `onUse`) VALUES (?, ?)');
define('SQL_INSERTITEM_TEMPLATE_EQUIPPABLE', 'INSERT INTO  `item_template_equippables` (`itemTemplateId`, `sockets`, `slots`, `slotType`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_TEMPLATE_SOCKETABLE', 'INSERT INTO  `item_template_socketables` (`itemTemplateId`, `onSocket`) VALUES (?, ?)');

define('SQL_UPDATEITEM', 'UPDATE `items` SET `inventoryId`=?, `name`=?, `description`=?, `buyPrice`=?, `sellPrice`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_CONSUMABLE', 'UPDATE `item_consumables` SET `onUse`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_EQUIPPABLE', 'UPDATE `item_equippables` SET `sockets`=?, `slots`=?, `onEquip`=?, `onUnequip`=?, `onAttack`=?, `onDefend`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_SOCKETABLE', 'UPDATE `item_socketables` SET `socketedIn`=?, `onSocket`=? WHERE `itemId`=?');

define('SQL_UPDATEITEM_TEMPLATE', 'UPDATE `item_templates` SET `name`=?, `description`=?, `buyPrice`=?, `sellPrice`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_CONSUMABLE', 'UPDATE `item_template_consumables` SET `onUse`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_EQUIPPABLE', 'UPDATE `item_template_equippables` SET `sockets`=?, `slots`=?, `onEquip`=?, `onUnequip`=?, `onAttack`=?, `onDefend`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_SOCKETABLE', 'UPDATE `item_template_socketables` SET `socketedIn`=?, `onSocket`=? WHERE `itemTemplateId`=?');

/**
 * Class that holds definitions for Item query functions
 */
class Items
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Items Queries class
	 *
	 * Contains all queries for loading Items from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Load an Item
	 *
	 * @param $Item
	 *   The Item entity that will be loaded
	 *   Must have it's itemId property set
	 *
	 * @return Boolean
	 *   Whether or not the load succeeded
	 */
	public function LoadById(\Entities\Item $Item)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADITEM);
		$Query->bind_param('s', $Item->ItemId);

		$Query->Execute();
		$AnItem = new \Entities\Item();
		$Query->bind_result($AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->CreatedOn, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType);
		if($Query->Fetch())
			return true;
		else
			return false;
	}

	/**
	 * Load a character's inventory
	 *
	 * @param $Character
	 *   The Character entity that will be used to load the inventory.
	 *   Must have it's character id property set
	 *
	 * @return Array
	 *   An array containing all the inventory items
	 */
	public function LoadInventory(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADINVENTORY);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AnItem = new \Entities\Item();
			$Query->bind_result($AnItem->ItemId, $AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->CreatedOn, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$Index] = $AnItem;
				$Index++;
			}
		}

		return $Result;
	}
}
?>