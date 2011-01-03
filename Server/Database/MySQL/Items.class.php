<?php

namespace Database\MySQL;

define('SQL_LOADITEM', 'SELECT i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.sockets, ie.slots, ie.slotType, is.socketedIn FROM `items` i LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` is ON i.itemId=is.itemId WHERE i.itemId=?');
define('SQL_LOADITEM_TEMPLATE', 'SELECT it.name, it.description, it.buyPrice, it.sellPrice, it.itemType, it.createdOn, ite.sockets, ite.slots, ite.slotType, ite.onEquip, ite.onUnequip, ite.onAttack, ite.onDefend, its.onSocket, itc.onUse FROM `item_templates` it LEFT JOIN `item_template_equippables` ite ON it.itemTemplateId=ite.itemTemplateId LEFT JOIN `item_template_socketables` its ON it.itemTemplateId=its.itemTemplateId LEFT JOIN `item_template_consumables` itc ON itc.itemTemplateId=it.itemTemplateId WHERE it.itemTemplateId=?');
define('SQL_DELETEITEM', 'DELETE FROM `items` WHERE `itemId`=?');

define('SQL_INSERTITEM', 'INSERT INTO  `items` (`itemId`, `itemTemplateId`, `itemType`, `inventoryId`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_CONSUMABLE', 'INSERT INTO  `item_consumables` (`itemId`, `onUse`) VALUES (?, ?)');
define('SQL_INSERTITEM_EQUIPPABLE', 'INSERT INTO  `item_equippables` (`itemId`, `sockets`, `slots`, `slotType`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_SOCKETABLE', 'INSERT INTO  `item_socketables` (`itemId`, `socketedIn`, `onSocket`) VALUES (?, ?, ?)');

define('SQL_INSERTITEM_TEMPLATE', 'INSERT INTO  `item_templates` (`itemTemplateId`, `itemType`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES (?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_TEMPLATE_CONSUMABLE', 'INSERT INTO  `item_template_consumables` (`itemTemplateId`, `onUse`) VALUES (?, ?)');
define('SQL_INSERTITEM_TEMPLATE_EQUIPPABLE', 'INSERT INTO  `item_template_equippables` (`itemTemplateId`, `sockets`, `slots`, `slotType`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_TEMPLATE_SOCKETABLE', 'INSERT INTO  `item_template_socketables` (`itemTemplateId`, `onSocket`) VALUES (?, ?)');

define('SQL_UPDATEITEM', 'UPDATE `items` SET `name`=?, `description`=?, `buyPrice`=?, `sellPrice`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_CONSUMABLE', 'UPDATE `item_consumables` SET `onUse`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_EQUIPPABLE', 'UPDATE `item_equippables` SET `sockets`=?, `slots`=?, `onEquip`=?, `onUnequip`=?, `onAttack`=?, `onDefend`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_SOCKETABLE', 'UPDATE `item_socketables` SET `socketedIn`=?, `onSocket`=? WHERE `itemId`=?');

define('SQL_UPDATEITEM_TEMPLATE', 'UPDATE `item_templates` SET `name`=?, `description`=?, `buyPrice`=?, `sellPrice`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_CONSUMABLE', 'UPDATE `item_template_consumables` SET `onUse`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_EQUIPPABLE', 'UPDATE `item_template_equippables` SET `sockets`=?, `slots`=?, `onEquip`=?, `onUnequip`=?, `onAttack`=?, `onDefend`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_SOCKETABLE', 'UPDATE `item_template_socketables` SET `socketedIn`=?, `onSocket`=? WHERE `itemTemplateId`=?');

define('SQL_LOADRACEDEFAULTITEMS', 'SELECT rdi.itemTemplateId, it.name, it.description, it.buyPrice, it.sellPrice, it.itemType, ite.sockets, ite.slots, ite.slotType, ite.onEquip, ite.onUnequip, ite.onAttack, ite.onDefend, its.onSocket, itc.onUse FROM `item_templates` it INNER JOIN `race_default_items` rdi ON rdi.itemTemplateId=it.itemTemplateId LEFT JOIN `item_template_equippables` ite ON it.itemTemplateId=ite.itemTemplateId LEFT JOIN `item_template_socketables` its ON it.itemTemplateId=its.itemTemplateId LEFT JOIN `item_template_consumables` itc ON itc.itemTemplateId=it.itemTemplateId WHERE rdi.raceId=?');

define('SQL_ITEMCHANGEINVENTORY', 'UPDATE `items` SET `inventoryId`=? WHERE `itemId`=?');
define('SQL_LOADINVENTORY', 'SELECT i.itemId, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.sockets, ie.slots, ie.slotType FROM `items` i INNER JOIN `inventories` in ON i.inventoryId=in.inventoryId LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` is ON i.itemId=is.itemId WHERE in.characterId=? AND is.socketedIn IS NULL');
define('SQL_INSERTINVENTORYFORCHARACTER', 'INSERT INTO `inventories` (`inventoryId`, `characterId`) VALUES (?, ?)');

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
	 * Load an Item Template
	 *
	 * @param $Item
	 *   The Item entity that will be loaded
	 *   Must have it's itemTemplateId property set
	 *
	 * @return Boolean
	 *   Whether or not the load succeeded
	 */
	public function LoadTemplateById(\Entities\Item $Item)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADITEMTEMPLATE);
		$Query->bind_param('s', $Item->ItemTemplateId);

		$Query->Execute();
		$AnItem = new \Entities\Item();
		$Query->bind_result($AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->CreatedOn, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType);
		if($Query->Fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Item
	 *
	 * @param $Item
	 *   The Item entity that will be Inserted
	 *   Must have it's itemTemplateId property set
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function Insert(\Entities\Item $Item)
	{
		$Item->ItemId = uniqid('ITEM_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTITEM);
		$Query->bind_param('ssisssii', $Item->ItemId, $Item->ItemTemplateId, $Item->ItemType, $Item->InventoryId, $Item->Name, $Item->Description, $Item->BuyPrice, $Item->SellPrice);
		$Query->Execute();

		if($Query->affected_rows > 0)
		{
			$Query->close();
			switch($Item->ItemType)
			{
				case IT_CONSUMABLE:
					$Query = $this->Database->Connection->prepare(SQL_INSERTITEMCONSUMABLE);
					$Query->bind_param('ss', $Item->ItemId, $Item->OnUse);
					break;
				case IT_SOCKETABLE:
					$Query = $this->Database->Connection->prepare(SQL_INSERTITEMSOCKETABLE);
					$Query->bind_param('sss', $Item->ItemId, $Item->SocketedIn, $Item->OnSocket);
					break;
				case IT_EQUIPPABLE:
					$Query = $this->Database->Connection->prepare(SQL_INSERTITEMEQUIPPABLE);
					$Query->bind_param('siiissss', $Item->ItemId, $Item->Sockets, $Item->Slots, $Item->SlotType, $Item->OnEquip, $Item->OnUnequip, $Item->OnAttack, $Item->OnDefend);
					break;
				default:
					return true;
					break;
			}
			$Query->Execute();
			if($Query->affected_rows > 0)
				return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Insert an Inventory for a character
	 *
	 * @param $Character
	 *   The Character entity that the inventory will belong to
	 *   Must have it's characterId property set
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function InsertInventoryForCharacter(\Entities\Character $Character)
	{
		$InventoryId = uniqid('IVTY_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTINVENTORYFORCHARACTER);
		$Query->bind_param('ss', $InventoryId, $Character->CharacterId);
		$Query->Execute();

		if($Query->affected_rows > 0)
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

	/**
	 * Load a race's default items
	 *
	 * @param $Race
	 *   The race entity that will be used to load the list.
	 *   Must have it's race id property set
	 *
	 * @return Array
	 *   An array containing all the default items
	 */
	public function LoadRaceDefaultItems(\Entities\Race $Race)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADRACEDEFAULTITEMS);
		$Query->bind_param('s', $Race->RaceId);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AnItem = new \Entities\Item();
			$Query->bind_result($AnItem->ItemTemplateId, $AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->ItemType, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType, $AnItem->OnEquip, $AnItem->OnUnequip, $AnItem->OnAttack, $AnItem->OnDefend, $AnItem->OnSocket, $AnItem->OnUse);
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